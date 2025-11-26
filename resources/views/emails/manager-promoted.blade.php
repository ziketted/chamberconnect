<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion - Gestionnaire de Chambre</title>
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
            background: linear-gradient(135deg, #fcb357 0%, #f5a742 100%);
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

        .promo-badge {
            background-color: #073066;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .role-box {
            background-color: #f0f4ff;
            border-left: 4px solid #073066;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }

        .role-title {
            font-size: 24px;
            font-weight: bold;
            color: #073066;
            margin: 10px 0;
        }

        .chamber-info {
            background-color: #e8f5e9;
            border-left: 4px solid #fcb357;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
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

        .button-secondary {
            background-color: #fcb357;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 5px 10px 0;
        }

        .permissions-list {
            background-color: #fafafa;
            padding: 20px;
            border-radius: 5px;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>🎉 Félicitations !</h1>
        <p>Vous avez été promu gestionnaire de chambre</p>
    </div>

    <div class="content">
        <div class="promo-badge">⭐ PROMOTION</div>

        <h2>Bienvenue {{ $user->name }},</h2>

        <p>Nous avons le plaisir de vous informer que vous avez été <strong>promu gestionnaire de chambre</strong> sur
            ChamberConnect DRC. C'est une grande responsabilité et une opportunité d'impacter positivement notre
            écosystème commercial !</p>

        <div class="role-box">
            <div style="font-size: 40px; margin-bottom: 10px;">👔</div>
            <div class="role-title">Gestionnaire de Chambre</div>
            <p style="margin: 5px 0; color: #666;">Vous pouvez maintenant gérer une ou plusieurs chambres</p>
        </div>

        @if($chamber)
        <div class="chamber-info">
            <strong>Chambre assignée :</strong><br>
            📍 <strong>{{ $chamber->name }}</strong><br>
            <small>{{ $chamber->location }}</small>
        </div>
        @endif

        <h3>Vos nouvelles permissions :</h3>
        <div class="permissions-list">
            <ul>
                <li>✅ Gérer les membres de la chambre</li>
                <li>✅ Créer et publier des événements</li>
                <li>✅ Publier des annonces et actualités</li>
                <li>✅ Créer des forums de discussion</li>
                <li>✅ Établir des partenariats</li>
                <li>✅ Consulter les statistiques et rapports</li>
                <li>✅ Accéder au tableau de bord complet</li>
            </ul>
        </div>

        <h3>Prochaines étapes :</h3>
        <ol>
            <li>Accédez à votre tableau de bord</li>
            <li>Configurez les informations de votre chambre</li>
            <li>Commencez à gérer vos premiers membres et événements</li>
            <li>Consultez la documentation pour plus d'informations</li>
        </ol>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('manage-chambers.index') }}" class="button">Accéder au Tableau de Bord</a>
            <a href="{{ route('dashboard') }}" class="button-secondary">Aller au Portail</a>
        </div>

        <div class="info-box" style="background-color: #fff3e0; border-left-color: #fcb357;">
            <strong>💡 Conseil :</strong><br>
            Explorez le centre d'aide et la documentation complète pour comprendre toutes les fonctionnalités
            disponibles en tant que gestionnaire.
        </div>

        <p style="margin-top: 30px; font-style: italic; text-align: center;">
            Nous comptons sur vous pour faire prospérer votre chambre et contribuer à la croissance économique de la
            RDC.
        </p>

        <div class="footer">
            <p>Cordialement,<br>
                <strong>L'équipe ChamberConnect DRC</strong></p>

            <p><small>Cet email a été envoyé automatiquement suite à votre promotion. Si vous avez des questions ou
                    besoin d'assistance, contactez-nous via le portail.</small></p>
        </div>
    </div>
</body>

</html>
