<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'inscription - {{ $registration->student->firstname }} {{ $registration->student->lastname }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        .logo {
            position: absolute;
            top: 0;
            width: 100px;
        }
        .logo-left { left: 0; }
        .logo-right { right: 0; }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        h2 {
            color: #34495e;
            font-style: italic;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
        }
        .label {
            font-weight: bold;
            color: #2980b9;
            display: block;
            margin-bottom: 5px;
        }
        .value {
            color: #333;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 250px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $imagePath }}" alt="Logo Gauche" class="logo logo-left">
            <img src="{{ $imagePath }}" alt="Logo Droit" class="logo logo-right">
            <h1>Fiche d'inscription</h1>
            <h2>Année scolaire : {{ $registration->schoolYear->wording }}</h2>
        </div>

        <div class="info-grid">
            <div class="info">
                <span class="label">Nom de l'élève</span>
                <span class="value">{{ $registration->student->lastname }}</span>
            </div>
            <div class="info">
                <span class="label">Prénom de l'élève</span>
                <span class="value">{{ $registration->student->firstname }}</span>
            </div>
            <div class="info">
                <span class="label">Email</span>
                <span class="value">{{ $registration->student->email }}</span>
            </div>
            <div class="info">
                <span class="label">Téléphone</span>
                <span class="value">{{ $registration->student->phone }}</span>
            </div>
            <div class="info">
                <span class="label">Classe</span>
                <span class="value">{{ $registration->classroom->wording }}</span>
            </div>
            <div class="info">
                <span class="label">Série</span>
                <span class="value">{{ $registration->classroom->serie->wording }}</span>
            </div>
            <div class="info">
                <span class="label">Date d'inscription</span>
                <span class="value">{{ $registration->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="signature">
            <p>Signature du parent :</p>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>