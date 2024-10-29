<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte d'identité scolaire - {{ $registration->student->firstname }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        .card {
            width: 85.6mm;
            height: 54mm;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 10px;
            padding: 15px;
            position: relative;
            border: 2px solid #1a365d;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #2c5282;
            padding-bottom: 5px;
        }
        .logo {
            width: 60px;
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .school-name {
            font-size: 16px;
            font-weight: bold;
            color: #1a365d;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .student-photo {
            width: 25mm;
            height: 32mm;
            position: absolute;
            right: 15px;
            top: 25px;
            border: 2px solid #2c5282;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .info {
            margin-left: 10px;
            margin-top: 25px;
            font-size: 11px;
            width: 60%;
        }
        .info p {
            margin: 6px 0;
            color: #2d3748;
        }
        .label {
            font-weight: bold;
            color: #1a365d;
            display: inline-block;
            width: 60px;
        }
        .qr-code {
            position: absolute;
            bottom: 10px;
            left: 10px;
            width: 20mm;
            height: 20mm;
        }
        .academic-year {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 10px;
            color: #4a5568;
        }
        .card-number {
            position: absolute;
            top: 5px;
            right: 15px;
            font-size: 9px;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-number">N° {{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</div>
        <img src="{{ $schoolLogo }}" alt="Logo" class="logo">
        
        <div class="header">
            <div class="school-name">MYSCHOOL</div>
            <div style="font-size: 12px; color: #4a5568;">Carte d'identité scolaire</div>
        </div>
        
        <img src="{{ $studentPhoto }}" alt="Photo" class="student-photo">
        
        <div class="info">
            <p><span class="label">Nom:</span> {{ strtoupper($registration->student->lastname) }}</p>
            <p><span class="label">Prénom:</span> {{ ucfirst($registration->student->firstname) }}</p>
            <p><span class="label">Classe:</span> {{ $registration->classroom->wording }}</p>
            <p><span class="label">Série:</span> {{ $registration->classroom->serie->wording }}</p>
            <p><span class="label">Contact:</span> {{ $registration->student->phone }}</p>
        </div>
        
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" class="qr-code">
        <div class="academic-year">{{ $registration->schoolYear->wording }}</div>
    </div>
</body>
</html>