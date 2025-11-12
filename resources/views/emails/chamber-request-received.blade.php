<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de création de chambre reçue</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 60px;
            height: 60px;
            background-color: #dc2626;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .logo svg {
            width: 30px;
            height: 30px;
            fill: white;
        }
        h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .highlight-box {
            background-color: #fef3c7;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .highlight-box h2 {
            color: #92400e;
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }
        .status-badge {
            display: inline-block;
            background-color: #f59e0b;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-section {
            margin: 30px 0;
        }
        .info-section h3 {
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #dc2626;
        }
        .info-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .info-value {
            color: #6b7280;
            font-size: 14px;
        }
        .next-steps {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .next-steps h3 {
            color: #1e40af;
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 15px 0;
        }
        .steps-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .steps-list li {
            color: #1e40af;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .steps-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }
        .footer-links {
            margin: 20px 0;
        }
        .footer-links a {
            color: #3b82f6;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .footer-text {
            color: #6b7280;
            font-size: 12px;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #b91c1c;
        }
        @media (max-width: 600px) {
            .email-container {
                padding: 20px;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"/>
                </svg>
            </div>
            <h1>Demande reçue avec succès !</h1>
            <p class="subtitle">
                Votre demande de création de chambre de commerce a été soumise et est en cours d'examen par notre équipe.
            </p>
        </div>

        <!-- Status Highlight -->
        <div class="highlight-box">
            <h2>Votre demande est en cours de traitement</h2>
            <div class="status-badge">EN ATTENTE D'EXAMEN</div>
        </div>

        <!-- Chamber Information -->
        <div class="info-section">
            <h3>Informations de votre demande</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Nom de la chambre</div>
                    <div class="info-value">{{ $chamber->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Province/Ville</div>
                    <div class="info-value">{{ $chamber->location }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email de contact</div>
                    <div class="info-value">{{ $chamber->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">{{ $chamber->phone }}</div>
                </div>
            </div>
            <div class="info-item" style="margin-top: 15px;">
                <div class="info-label">Date de soumission</div>
                <div class="info-value">{{ $chamber->created_at->format('d/m/Y à H:i') }}</div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="next-steps">
            <h3>Prochaines étapes :</h3>
            <ul class="steps-list">
                <li>Votre demande sera examinée par notre équipe d'administration</li>
                <li>Nous vérifierons tous les documents soumis</li>
                <li>Vous recevrez un email de confirmation ou de demande de complément d'information</li>
                <li>En cas d'approbation, vous obtiendrez automatiquement les droits de gestionnaire</li>
                <li>Un numéro d'enregistrement officiel vous sera attribué</li>
            </ul>
        </div>

        <!-- Action Button -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('portal.chamber.my-requests') }}" class="button">
                Suivre ma demande
            </a>
        </div>

        <!-- Additional Information -->
        <div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; margin: 30px 0;">
            <h3 style="color: #374151; font-size: 16px; margin: 0 0 15px 0;">Informations importantes :</h3>
            <ul style="color: #6b7280; font-size: 14px; margin: 0; padding-left: 20px;">
                <li>Le délai d'examen est généralement de 5 à 10 jours ouvrables</li>
                <li>Vous pouvez suivre l'état de votre demande dans votre espace portail</li>
                <li>En cas de questions, n'hésitez pas à nous contacter</li>
                <li>Conservez cet email comme preuve de soumission de votre demande</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-links">
                <a href="{{ route('portal.index') }}">Portail</a>
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
                <a href="{{ route('chambers') }}">Chambres</a>
                <a href="mailto:support@chamberconnect.org">Support</a>
            </div>
            <div class="footer-text">
                <p>© {{ date('Y') }} ChamberConnect RDC. Tous droits réservés.</p>
                <p>Chambre de Commerce Accréditée - République Démocratique du Congo</p>
                <p>
                    Cet email a été envoyé à {{ $user->email }} concernant votre demande de création de chambre.
                    <br>
                    Si vous n'êtes pas à l'origine de cette demande, veuillez nous contacter immédiatement.
                </p>
            </div>
        </div>
    </div>
</body>
</html>