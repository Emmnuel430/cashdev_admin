<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre rendez-vous</title>
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
            color: #2d6cdf;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #666;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-height: 60px;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('logo.png') }}" alt="Logo CashDev" class="logo" />
        <h1>Bonjour {{ $rdv->client_prenom ?? '' }} {{ $rdv->client_nom }},</h1>
        <p>Votre demande de rendez-vous a bien été reçue.</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($rdv->date_prise_rdv)->format('d/m/Y H:i') }}</p>
        <p>Nous vous contacterons sous peu pour confirmer votre rendez-vous.</p>
        <p class="footer">Cordialement,<br>L'équipe CashDev</p>
    </div>
</body>

</html>