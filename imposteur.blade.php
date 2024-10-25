<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imposteur</title>
    <style>
        /* Style général pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        /* Conteneur central pour le message */
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            text-align: center;
        }

        /* Style du message principal */
        h3 {
            color: #e74c3c;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Style du lien de connexion */
        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2980b9;
        }

        /* Style pour le corps de texte */
        p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h3>Vous êtes un imposteur !</h3>
        <p>Si vous n'êtes pas un imposteur, veuillez <a href="index.php">vous reconnecter</a>.</p>
    </div>

</body>
</html>
