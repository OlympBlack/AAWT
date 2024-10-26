<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'inscription</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fiche d'inscription</h1>
        <h2>Année scolaire : {{ $registration->schoolYear->wording }}</h2>
    </div>

    <div class="info">
        <span class="label">Nom de l'élève :</span> {{ $registration->student->lastname }}
    </div>
    <div class="info">
        <span class="label">Prénom de l'élève :</span> {{ $registration->student->firstname }}
    </div>
    <div class="info">
        <span class="label">Email :</span> {{ $registration->student->email }}
    </div>
    <div class="info">
        <span class="label">Téléphone :</span> {{ $registration->student->phone }}
    </div>
    <div class="info">
        <span class="label">Classe :</span> {{ $registration->classroom->wording }}
    </div>
    <div class="info">
        <span class="label">Série :</span> {{ $registration->classroom->serie->wording }}
    </div>
    <div class="info">
        <span class="label">Date d'inscription :</span> {{ $registration->created_at->format('d/m/Y') }}
    </div>

    <div style="margin-top: 50px;">
        <p>Signature du parent :</p>
        <div style="border-bottom: 1px solid black; width: 200px; height: 50px;"></div>
    </div>
</body>
</html>

