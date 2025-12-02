<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de votre chambre</title>
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
            background-color: #0b1464;
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
            background-color: #10B981;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .state-number {
            background-color: #180a58;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .button {
            background-color: #180a58;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>🎉 Félicitations !</h1>
        <p>Votre chambre a été validée</p>
    </div>

    <div class="content">
        <div class="success-badge">✅ VALIDÉE</div>

        <h2>Bonjour,</h2>

        <p>Nous avons le plaisir de vous informer que votre demande de création de chambre a été
            <strong>approuvée</strong> !
        </p>

        <h3>Détails de votre chambre :</h3>
        <ul>
            <li><strong>Nom :</strong> {{ $chamber->name }}</li>
            <li><strong>Province :</strong> {{ $chamber->location }}</li>
            <li><strong>Date de validation :</strong> {{ $chamber->agrément_date->format('d/m/Y') }}</li>
        </ul>

        <h3>Votre numéro officiel :</h3>
        <div class="state-number">{{ $stateNumber }}</div>

        <p><strong>Vous disposez désormais des droits de gestionnaire de chambre.</strong></p>

        <p>Cela signifie que vous pouvez maintenant :</p>
        <ul>
            <li>Gérer les membres de votre chambre</li>
            <li>Organiser des événements</li>
            <li>Publier des annonces</li>
            <li>Créer des forums de discussion</li>
            <li>Établir des partenariats</li>
        </ul>

        <a href="{{ route('chamber.show', $chamber) }}" class="button">Voir ma chambre</a>

        <p>Merci de votre confiance et bienvenue dans l'écosystème ChamberConnect DRC !</p>

        <div class="footer">
            <p>Cordialement,<br>
                L'équipe ChamberConnect DRC</p>

            <p><small>Cet email a été envoyé automatiquement. Si vous avez des questions, n'hésitez pas à nous
                    contacter.</small></p>
        </div>
    </div>
</body>

</html>