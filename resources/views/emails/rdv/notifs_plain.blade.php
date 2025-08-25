Nouvelle prise de rendez-vous

Nom : {{ $rdv->client_prenom ?? '' }} {{ $rdv->client_nom }}
Email : {{ $rdv->client_email ?? 'Non renseigné' }}
Téléphone : {{ $rdv->client_tel }}
Date : {{ \Carbon\Carbon::parse($rdv->date_prise_rdv)->format('d/m/Y H:i') }}
Détails : {{ $rdv->commentaires ?? 'Aucun' }}