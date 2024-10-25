<!-- resources/views/accueil.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }

        /* Conteneur principal */
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            text-align: center;
        }

        /* Style pour les titres */
        h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h4 {
            color: #555;
            font-size: 20px;
            margin-bottom: 15px;
        }

        /* Style pour le paragraphe */
        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }

        /* Style pour les liens */
        a {
            display: block;
            color: #5c6bc0;
            text-decoration: none;
            margin: 10px 0;
            font-size: 18px;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Style du bouton */
        button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff5252;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        /* Style pour centrer le contenu de la page */
        .center {
            text-align: center;
        }

    </style>
    <title>Accueil</title>
</head>
<body>

    <div class="container">
        <h3>Bienvenue sur notre plateforme</h3>
        <p>Profitez de nos services</p>
        <h4>Nos services</h4>
        <a href="login_inscription.php">Inscrire un étudiant</a>
        <a href="login_etudiants.php">Mes étudiants</a>
        <button><a href="index.php">Déconnexion</a></button>
    </div>
</body>
</html>
