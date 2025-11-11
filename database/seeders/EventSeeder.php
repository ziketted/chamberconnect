<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Chamber;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $chambers = Chamber::all();
        $users = User::all();

        if ($chambers->isEmpty() || $users->isEmpty()) {
            $this->command->info('Aucune chambre ou utilisateur trouvé. Veuillez d\'abord exécuter les seeders pour les chambres et utilisateurs.');
            return;
        }

        $events = [
            [
                'title' => 'Networking Business Evening',
                'type' => 'networking',
                'description' => 'Événement de networking professionnel pour étendre votre réseau et créer de nouvelles opportunités d\'affaires. Organisé...',
                'date' => Carbon::now()->addDays(5),
                'time' => '16:30:00',
                'location' => 'Hôtel Sultani',
                'max_participants' => 100,
                'mode' => 'presentiel',
                'status' => 'upcoming'
            ],
            [
                'title' => 'Formation Export International',
                'type' => 'conference',
                'description' => 'Formation certifiante pour approfondir vos connaissances et développer vos compétences professionnelles. Organisé par CC...',
                'date' => Carbon::now()->addDays(2),
                'time' => '18:30:00',
                'location' => 'Hôtel Pullman Kinshasa',
                'max_participants' => 82,
                'mode' => 'presentiel',
                'status' => 'upcoming'
            ],
            [
                'title' => 'Forum Entrepreneurial Jeunes',
                'type' => 'forum',
                'description' => 'Événement de networking professionnel pour étendre votre réseau et créer de nouvelles opportunités d\'affaires. Organisé...',
                'date' => Carbon::now()->addDays(3),
                'time' => '16:30:00',
                'location' => 'Salle de Conférences BCDC',
                'max_participants' => 87,
                'mode' => 'presentiel',
                'status' => 'upcoming'
            ],
            [
                'title' => 'Atelier Digital Marketing',
                'type' => 'networking',
                'description' => 'Atelier pratique sur les stratégies de marketing digital pour les entreprises modernes.',
                'date' => Carbon::now()->addDays(7),
                'time' => '14:00:00',
                'location' => 'Centre de Formation Numérique',
                'max_participants' => 50,
                'mode' => 'presentiel',
                'status' => 'upcoming'
            ],
            [
                'title' => 'Conférence Innovation Technologique',
                'type' => 'conference',
                'description' => 'Découvrez les dernières innovations technologiques et leur impact sur les entreprises.',
                'date' => Carbon::now()->addDays(10),
                'time' => '09:00:00',
                'location' => 'Palais des Congrès',
                'max_participants' => 200,
                'mode' => 'presentiel',
                'status' => 'upcoming'
            ]
        ];

        foreach ($events as $eventData) {
            $chamber = $chambers->random();
            $creator = $users->random();

            $event = Event::create([
                'chamber_id' => $chamber->id,
                'created_by' => $creator->id,
                'title' => $eventData['title'],
                'type' => $eventData['type'],
                'description' => $eventData['description'],
                'date' => $eventData['date'],
                'time' => $eventData['time'],
                'location' => $eventData['location'],
                'max_participants' => $eventData['max_participants'],
                'mode' => $eventData['mode'],
                'status' => $eventData['status']
            ]);

            // Ajouter quelques participants aléatoirement
            $maxParticipants = min($users->count() - 1, min(50, $eventData['max_participants'] - 10));
            $participantCount = rand(5, max(5, $maxParticipants));
            $participants = $users->random(min($participantCount, $users->count()));
            
            foreach ($participants as $participant) {
                $event->participants()->attach($participant->id, [
                    'status' => 'reserved',
                    'reserved_at' => now()
                ]);
            }

            // Ajouter quelques likes aléatoirement
            $maxLikers = min($users->count(), 15);
            $likeCount = rand(3, $maxLikers);
            $likers = $users->random(min($likeCount, $users->count()));
            
            foreach ($likers as $liker) {
                $event->likes()->attach($liker->id);
            }

            $this->command->info("Événement créé: {$event->title} avec {$participantCount} participants et {$likeCount} likes");
        }
    }
}