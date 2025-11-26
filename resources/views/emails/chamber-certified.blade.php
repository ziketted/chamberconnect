<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certification de votre chambre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #073066 0%, #052347 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }

        .success-badge {
            background-color: #fcb357;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .state-number-box {
            background-color: #073066;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            border-left: 4px solid #fcb357;
        }

        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #073066;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .button {
            background-color: #073066;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #666;
        }

        ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        li {
            margin: 8px 0;
        }

        strong {
            color: #073066;
        }

        .date-time {
            background-color: #fff3e0;
            border-left: 4px solid #fcb357;
            padding: 10px 15px;
            border-radius: 3px;
            margin: 10px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>🏆 Certification Délivrée !</h1>
        <p>Votre chambre a été officiellement certifiée</p>
    </div>

    <div class="content">
        <div class="success-badge">✅ CERTIFIÉE</div>

        <h2>Bonjour {{ $manager->name }},</h2>

        <p>Nous avons le plaisir de vous informer que votre chambre a été <strong>officiellement certifiée</strong> par
            le Super Administrateur de ChamberConnect DRC.</p>

        <h3>Détails de certification :</h3>
        <ul>
            <li><strong>Chambre :</strong> {{ $chamber->name }}</li>
            <li><strong>Localisation :</strong> {{ $chamber->location }}</li>
            <li><strong>Type :</strong> {{ $chamber->type === 'bilateral' ? 'Bilatérale' : 'Nationale' }}</li>
        </ul>

        <h3>Numéro d'État Officiel :</h3>
        <div class="state-number-box">{{ $stateNumber }}</div>

        <div class="info-box">
            <strong>📅 Date de certification :</strong><br>
            <span class="date-time">{{ $certificationDate }}</span>
        </div>

        @if($chamber->certification_notes)
        <div class="info-box">
            <strong>📝 Notes :</strong><br>
            {{ $chamber->certification_notes }}
        </div>
        @endif

        <h3>Prochaines étapes :</h3>
        <ul>
            <li>Votre chambre est maintenant officiellement reconnue</li>
            <li>Vous pouvez continuer à gérer vos membres et événements</li>
            <li>Utilisez votre numéro d'état pour les documents officiels</li>
            <li>Consultez votre tableau de bord pour tous les détails</li>
        </ul>

        <a href="{{ route('manage-chambers.index') }}" class="button">Accéder au Tableau de Bord</a>

        <p style="margin-top: 30px; font-style: italic;">
            Merci de votre engagement envers l'écosystème ChamberConnect DRC. Votre chambre contribue à renforcer les
            liens commerciaux et professionnels en RDC.
        </p>

        <div class="footer">
            <p>Cordialement,<br>
                <strong>L'équipe SuperAdmin ChamberConnect DRC</strong></p>

            <p><small>Cet email a été envoyé automatiquement. Si vous avez des questions, n'hésitez pas à nous
                    contacter via notre portail.</small></p>
        </div>
    </div>
</body>

</html>
