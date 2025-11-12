<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refus de votre demande</title>
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
            background-color: #DC2626;
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
        .rejection-badge {
            background-color: #DC2626;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .reason-box {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .button {
            background-color: #E71D36;
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
        <h1>Demande non approuvée</h1>
        <p>Concernant votre chambre : {{ $chamber->name }}</p>
    </div>
    
    <div class="content">
        <div class="rejection-badge">❌ NON APPROUVÉE</div>
        
        <h2>Bonjour,</h2>
        
        <p>Nous vous remercions pour votre demande de création de chambre de commerce. Après examen attentif de votre dossier, nous ne pouvons malheureusement pas donner suite à votre demande à ce stade.</p>
        
        <h3>Motif du refus :</h3>
        <div class="reason-box">
            {{ $rejectionReason }}
        </div>
        
        <h3>Que faire maintenant ?</h3>
        <p>Cette décision n'est pas définitive. Vous pouvez :</p>
        <ul>
            <li>Corriger les points mentionnés ci-dessus</li>
            <li>Compléter votre dossier avec les documents manquants</li>
            <li>Soumettre une nouvelle demande</li>
            <li>Nous contacter pour obtenir des clarifications</li>
        </ul>
        
        <a href="{{ route('portal.chamber.create') }}" class="button">Soumettre une nouvelle demande</a>
        
        <p>Nous restons à votre disposition pour vous accompagner dans cette démarche et vous aider à constituer un dossier complet.</p>
        
        <div class="footer">
            <p>Cordialement,<br>
            L'équipe ChamberConnect DRC</p>
            
            <p><small>Cet email a été envoyé automatiquement. Pour toute question, n'hésitez pas à nous contacter.</small></p>
        </div>
    </div>
</body>
</html>