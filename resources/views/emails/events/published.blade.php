<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject ?? 'Événement' }}</title>
    <style>
        /* Basic reset for email clients */
        body {
            margin: 0;
            padding: 0;
            background: #0b1220;
            color: #e5e7eb;
            font-family: ui-sans-serif, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        }

        a {
            color: #fcb357;
            text-decoration: none;
        }

        .container {
            width: 100%;
            background: #0b1220;
            padding: 24px 0;
        }

        .card {
            max-width: 640px;
            margin: 0 auto;
            background: #0f172a;
            border: 1px solid #1f2937;
            border-radius: 16px;
            overflow: hidden;
        }

        .header {
            background: #0c1a3a;
            padding: 16px 20px;
            color: #ffffff;
            display: flex;
            align-items: center;
        }

        .badge {
            display: inline-block;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #fcb357;
            color: #0c1a3a;
            font-weight: 700;
            margin-left: auto;
        }

        .content {
            padding: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 6px;
        }

        .meta {
            font-size: 13px;
            color: #cbd5e1;
            margin: 6px 0;
        }

        .meta i {
            font-style: normal;
            display: inline-block;
            min-width: 14px;
        }

        .cover {
            width: 100%;
            height: auto;
            display: block;
        }

        .desc {
            margin: 16px 0 20px;
            line-height: 1.6;
            font-size: 14px;
            color: #e5e7eb;
        }

        .cta {
            display: inline-block;
            padding: 12px 18px;
            background: #073066;
            color: #ffffff !important;
            border-radius: 10px;
            font-weight: 700;
        }

        .cta+.cta-secondary {
            margin-left: 8px;
        }

        .cta-secondary {
            display: inline-block;
            padding: 12px 18px;
            border: 1px solid #334155;
            color: #e5e7eb !important;
            border-radius: 10px;
            font-weight: 600;
            background: #0f172a;
        }

        .footer {
            padding: 16px 20px;
            border-top: 1px solid #1f2937;
            font-size: 12px;
            color: #94a3b8;
        }

        .small {
            font-size: 12px;
            color: #94a3b8;
        }

        .spacer {
            height: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div
                        style="width:32px;height:32px;border-radius:8px;background:#fcb357;color:#0c1a3a;display:flex;align-items:center;justify-content:center;font-weight:800;">
                        {{ strtoupper(mb_substr($event->chamber->name ?? 'CC', 0, 1)) }}
                    </div>
                    <div style="font-weight:800;">{{ $event->chamber->name ?? 'Chambre' }}</div>
                </div>
                <span class="badge">{{ $action === 'updated' ? 'Mise à jour' : 'Nouveau' }}</span>
            </div>

            @if(!empty($event->cover_image_path))
            <img class="cover" src="{{ asset('storage/'.$event->cover_image_path) }}" alt="Couverture de l'événement">
            @endif

            <div class="content">
                <p class="small" style="margin:0 0 4px;">Bonjour {{ $notifiable->name ?? '' }},</p>
                <h1 class="title">{{ $title ?? $event->title }}</h1>

                <div class="meta"><i>📅</i> {{ optional($event->date)->format('d/m/Y') }} à {{ $event->time ?? '—' }}
                </div>
                <div class="meta"><i>🏷️</i> Type: {{ ucfirst($event->type ?? '—') }}</div>
                <div class="meta">
                    <i>{{ $event->mode === 'online' ? '🖥️' : ($event->mode === 'hybride' ? '🖥️🏢' : '📍') }}</i>
                    Mode: {{ ucfirst($event->mode ?? '—') }}
                </div>
                @if(in_array($event->mode, ['presentiel','hybride']))
                <div class="meta"><i>📍</i> {{ trim(($event->address ? $event->address.' — ' : '').($event->city ??
                    '').($event->country ? ', '.$event->country : '' )) }}</div>
                @endif
                @if($event->mode === 'online' && $event->lien_live)
                <div class="meta"><i>🔗</i> Lien: <a href="{{ $event->lien_live }}" target="_blank">{{ $event->lien_live
                        }}</a></div>
                @endif
                @if(!empty($event->max_participants))
                <div class="meta"><i>👥</i> Places max: {{ $event->max_participants }}</div>
                @endif

                @if(!empty($event->description))
                <div class="desc">{!! nl2br(e($event->description)) !!}</div>
                @endif

                <div style="margin:18px 0 4px;">
                    <a href="{{ $ctaUrl }}" class="cta" target="_blank">Voir l’événement</a>
                    @if($event->mode === 'online' && $event->lien_live)
                    <a href="{{ $event->lien_live }}" class="cta-secondary" target="_blank">Accéder au live</a>
                    @endif
                </div>
                <div class="spacer"></div>
                <p class="small">Cet email vous est adressé car vous êtes membre de la chambre {{ $event->chamber->name
                    ?? '' }}.</p>
            </div>

            <div class="footer">
                © {{ now()->year }} ChamberConnect • Tous droits réservés
            </div>
        </div>
    </div>
</body>

</html>

