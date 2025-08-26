<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nouvelle prise de rendez-vous</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
            color: #333;
        }

        .container {
            background: #fff;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #e63946;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Nouvelle demande de rendez-vous</h1>
        <p>Un client vient de prendre rendez-vous.</p>
        <p><strong>Nom :</strong> {{ $rdv->client_prenom ?? '' }} {{ $rdv->client_nom }}</p>
        <p><strong>Email :</strong> {{ $rdv->client_email ?? 'Non renseigné' }}</p>
        <p><strong>Téléphone :</strong> {{ $rdv->client_tel }}</p>
        <p><strong>Date du rendez-vous :</strong> {{ \Carbon\Carbon::parse($rdv->date_prise_rdv)->format('d/m/Y H:i') }}
        </p>
        <p><strong>Détails :</strong> {{ $rdv->commentaires ?? 'Aucun détail fourni' }}</p>
        <p class="footer">Ceci est une notification automatique.</p>
    </div>
</body>

</html>