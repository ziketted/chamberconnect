<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamber;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin() || $user->isChamberManager()) {
            // Dashboard pour les admins
            $chambers = Chamber::withCount('members')->get();
            $popular_chambers = $chambers->take(3);
            
            // Récupérer les événements populaires avec les likes
            $popularEvents = Event::with(['chamber', 'creator', 'participants', 'likes'])
                ->where('date', '>=', now())
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get()
                ->map(function ($event) use ($user) {
                    $userChamberIds = $user->chambers()->pluck('chambers.id');
                    $isUserChamber = $userChamberIds->contains($event->chamber_id);
                    return $this->formatEventForDisplay($event, $isUserChamber);
                });
            
            return view('dashboard', compact('chambers', 'popular_chambers', 'popularEvents'));
        } else {
            // Dashboard pour les utilisateurs normaux
            return $this->userDashboard($request);
        }
    }
    
    public function searchEvents(Request $request)
    {
        $user = Auth::user();
        $userChamberIds = $user->chambers()->pluck('chambers.id');
        
        $query = Event::with(['chamber', 'creator'])
            ->where('date', '>=', now());
        
        // Recherche par terme
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('chamber', function($chamberQuery) use ($searchTerm) {
                      $chamberQuery->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }
        
        // Filtres
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'this-month':
                    $query->whereMonth('date', now()->month)
                          ->whereYear('date', now()->year);
                    break;
                    
                case 'this-week':
                    $query->whereBetween('date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                    
                case 'certified':
                    $query->whereHas('chamber', function($chamberQuery) {
                        $chamberQuery->where('verified', true);
                    });
                    break;
                    
                case 'forum':
                    $query->where('title', 'LIKE', '%forum%');
                    break;
                    
                case 'networking':
                    $query->where(function($q) {
                        $q->where('title', 'LIKE', '%networking%')
                          ->orWhere('title', 'LIKE', '%réseau%')
                          ->orWhere('description', 'LIKE', '%networking%');
                    });
                    break;
            }
        }
        
        $events = $query->orderBy('date', 'asc')
                       ->limit(20)
                       ->get()
                       ->map(function ($event) use ($userChamberIds) {
                           $isUserChamber = $userChamberIds->contains($event->chamber_id);
                           return $this->formatEventForDisplay($event, $isUserChamber);
                       });
        
        return response()->json([
            'events' => $events,
            'count' => $events->count()
        ]);
    }
    
    private function userDashboard()
    {
        $user = Auth::user();
        
        // Statistiques de l'utilisateur
        $userChambers = $user->chambers()->withCount('members')->get();
        $userChambersCount = $userChambers->count();
        
        // Nombre d'événements auxquels l'utilisateur a participé (simulé pour l'instant)
        $participatedEventsCount = 0; // À implémenter quand le système d'événements sera prêt
        
        // Récupérer les événements réels de la base de données
        $userChamberIds = $userChambers->pluck('id');
        
        // Événements des chambres de l'utilisateur seulement
        // Filtrer pour ne montrer que ceux non réservés par l'utilisateur et à venir
        $allEvents = Event::with(['chamber', 'creator', 'participants', 'likes'])
            ->whereIn('chamber_id', $userChamberIds)
            ->where('date', '>=', now())
            ->whereDoesntHave('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($event) {
                return $this->formatEventForDisplay($event, true);
            });
        
        // Chambres dont l'utilisateur n'est pas membre (pour la sidebar droite)
        $suggestedChambers = Chamber::withCount('members')
            ->whereNotIn('id', $userChamberIds)
            ->where('verified', true)
            ->orderBy('members_count', 'desc')
            ->limit(5)
            ->get();
        
        // Informations sur l'investissement en RDC
        $investmentInfo = [
            'title' => 'Investir en RDC',
            'description' => 'Découvrez les opportunités d\'investissement en République Démocratique du Congo',
            'steps' => [
                [
                    'number' => 1,
                    'title' => 'Explorez les secteurs',
                    'description' => 'Identifiez les secteurs porteurs : mines, agriculture, télécoms, énergie'
                ],
                [
                    'number' => 2,
                    'title' => 'Connectez-vous',
                    'description' => 'Rejoignez les chambres de commerce sectorielles pour étendre votre réseau'
                ],
                [
                    'number' => 3,
                    'title' => 'Participez aux événements',
                    'description' => 'Assistez aux forums d\'affaires et événements de networking'
                ],
                [
                    'number' => 4,
                    'title' => 'Obtenez un accompagnement',
                    'description' => 'Bénéficiez de conseils d\'experts et d\'un accompagnement personnalisé'
                ]
            ]
        ];
        
        return view('dashboard.user', compact(
            'user',
            'userChambers',
            'userChambersCount',
            'participatedEventsCount',
            'allEvents',
            'suggestedChambers',
            'investmentInfo'
        ));
    }
    
    private function generateEventsForUserChambers($userChambers)
    {
        $events = collect();
        
        foreach ($userChambers as $chamber) {
            // Générer 2-3 événements par chambre de l'utilisateur
            $chamberEvents = $this->generateEventsForChamber($chamber, true);
            $events = $events->merge($chamberEvents);
        }
        
        return $events->sortBy('date');
    }
    
    private function generateOtherEvents($allChambers, $userChambers)
    {
        $events = collect();
        $userChamberIds = $userChambers->pluck('id');
        
        // Événements des autres chambres
        $otherChambers = $allChambers->whereNotIn('id', $userChamberIds)->take(5);
        
        foreach ($otherChambers as $chamber) {
            // Générer 1-2 événements par autre chambre
            $chamberEvents = $this->generateEventsForChamber($chamber, false);
            $events = $events->merge($chamberEvents);
        }
        
        return $events->sortBy('date');
    }
    
    private function generateEventsForChamber($chamber, $isUserChamber = false)
    {
        $eventTypes = ['forum', 'atelier', 'networking', 'conference', 'formation'];
        $eventTitles = [
            'forum' => ['Forum des Investisseurs', 'Forum d\'Affaires', 'Forum Entrepreneurial', 'Forum Innovation'],
            'atelier' => ['Atelier Export-Import', 'Atelier Digital', 'Atelier Marketing', 'Atelier Financement'],
            'networking' => ['Networking Business', 'Soirée Networking', 'Rencontre Professionnelle', 'Cocktail d\'Affaires'],
            'conference' => ['Conférence Fintech', 'Conférence Innovation', 'Conférence Leadership', 'Conférence Économique'],
            'formation' => ['Formation Digital', 'Formation Management', 'Formation Comptabilité', 'Formation Export']
        ];
        
        $events = collect();
        $eventCount = $isUserChamber ? rand(2, 3) : rand(1, 2);
        
        for ($i = 0; $i < $eventCount; $i++) {
            $type = $eventTypes[array_rand($eventTypes)];
            $title = $eventTitles[$type][array_rand($eventTitles[$type])];
            
            // Dates futures pour les prochains 30 jours
            $daysFromNow = rand(1, 30);
            $eventDate = now()->addDays($daysFromNow);
            
            $events->push([
                'id' => uniqid(),
                'title' => $title,
                'type' => $type,
                'chamber_id' => $chamber->id,
                'chamber_name' => $chamber->name,
                'chamber_logo' => $chamber->logo_path,
                'date' => $eventDate->format('d M'),
                'full_date' => $eventDate,
                'time' => rand(8, 18) . ':00',
                'participants' => rand(15, 100),
                'max_participants' => rand(50, 150),
                'location' => $chamber->location ?? 'En ligne',
                'description' => $this->generateEventDescription($type, $chamber->name),
                'is_user_chamber' => $isUserChamber,
                'price' => $type === 'formation' ? rand(50, 200) . ' USD' : 'Gratuit',
                'status' => rand(0, 10) > 8 ? 'complet' : 'ouvert'
            ]);
        }
        
        return $events;
    }
    
    private function generateEventDescription($type, $chamberName)
    {
        $descriptions = [
            'forum' => "Participez à ce forum organisé par {$chamberName} pour échanger avec des experts et développer votre réseau professionnel.",
            'atelier' => "Atelier pratique proposé par {$chamberName} pour acquérir de nouvelles compétences et techniques.",
            'networking' => "Événement de networking organisé par {$chamberName} pour rencontrer d'autres professionnels de votre secteur.",
            'conference' => "Conférence exclusive de {$chamberName} avec des intervenants de renom et des insights précieux.",
            'formation' => "Formation certifiante proposée par {$chamberName} pour développer vos compétences professionnelles."
        ];
        
        return $descriptions[$type] ?? "Événement organisé par {$chamberName}.";
    }
    
    public function myChambers(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer toutes les chambres de l'utilisateur avec leurs informations
        $userChambers = $user->chambers()->withCount('members')->get();
        
        // Statistiques
        $stats = [
            'total_chambers' => $userChambers->count(),
            'verified_chambers' => $userChambers->where('verified', true)->count(),
            'total_members' => $userChambers->sum('members_count')
        ];
        
        return view('my-chambers', compact('userChambers', 'stats'));
    }

    private function formatEventForDisplay($event, $isUserChamber = false)
    {
        $user = Auth::user();
        
        // Déterminer le type d'événement basé sur le titre
        $type = $event->type ?? 'conference'; // Utiliser le type de l'événement ou par défaut
        if (!$event->type) {
            $title = strtolower($event->title);
            if (str_contains($title, 'forum')) {
                $type = 'forum';
            } elseif (str_contains($title, 'atelier')) {
                $type = 'atelier';
            } elseif (str_contains($title, 'networking') || str_contains($title, 'réseau')) {
                $type = 'networking';
            } elseif (str_contains($title, 'formation')) {
                $type = 'formation';
            }
        }
        
        // Vérifier si l'utilisateur a réservé cet événement
        $booking = null;
        $isBooked = false;
        $bookingStatus = null;
        
        if ($user) {
            // Utiliser la relation Eloquent pour vérifier la réservation
            $isBooked = $event->isBookedBy($user);
            $bookingStatus = $event->getBookingStatus($user);
        }
        
        // Calculer le nombre de participants réels en utilisant la relation
        $participantsCount = $event->participants()->count();
        
        // Informations sur les likes
        $likesCount = $event->likes()->count();
        $isLiked = $user ? $event->isLikedBy($user) : false;
        
        return [
            'id' => $event->id,
            'title' => $event->title,
            'type' => $type,
            'chamber_id' => $event->chamber_id,
            'chamber_name' => $event->chamber->name,
            'chamber_logo' => $event->chamber->logo_path,
            'date' => $event->date->format('d M'),
            'full_date' => $event->date,
            'time' => $event->time ?? '09:00',
            'participants' => $participantsCount,
            'max_participants' => $event->max_participants ?? 100,
            'location' => $event->location ?? $event->chamber->location ?? 'En ligne',
            'description' => $event->description ?? $this->generateEventDescription($type, $event->chamber->name),
            'is_user_chamber' => $isUserChamber,
            'price' => $event->price ?? ($type === 'formation' ? '50 USD' : 'Gratuit'),
            'status' => $event->status ?? 'ouvert',
            'is_booked' => $isBooked,
            'booking_status' => $bookingStatus,
            'likes_count' => $likesCount,
            'is_liked' => $isLiked
        ];
    }
}
