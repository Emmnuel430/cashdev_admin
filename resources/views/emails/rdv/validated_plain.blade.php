Bonjour {{ $rdv->client_prenom ?? '' }} {{ $rdv->client_nom }},

Votre demande de rendez-vous a bien été reçue.
Date : {{ \Carbon\Carbon::parse($rdv->date_prise_rdv)->format('d/m/Y H:i') }}

Nous vous contacterons sous peu pour confirmer votre rendez-vous.

Cordialement,
L'équipe CashDev