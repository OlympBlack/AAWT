<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"], button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        button:hover {
            background-color: #4cae4c;
        }

        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription Étudiant</h2>
        <form action="inscription.php" method="POST">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="classe">Classe:</label>
            <select id="classe" name="classe" required>
                <option value="6e">6e</option>
                <option value="5e">5e</option>
                <option value="4e">4e</option>
                <option value="3e">3e</option>
                <option value="2nde">2nde</option>
                <option value="1ère">1ère</option>
                <option value="Tle">Tle</option>
            </select>

            <label for="annee_scolaire">Année Scolaire:</label>
            <select id="annee_scolaire" name="annee_scolaire" required>
                <option value="2024_2025">2024-2025</option>
                <option value="2023_2024">2023-2024</option>
                <option value="2022_2023">2022-2023</option>
            </select>

            <input type="submit" value="S'inscrire">
        </form>
        {{?php if (isset($_GET['error'])): ?}}
            <div class="error">{{?php echo $_GET['error']; }}</div>
        {{?php endif; ?}}
        {{?php @if (isset($_GET['success'])): ?}}
            <div class="success">
                Inscription réussie ! Votre matricule est : {{?php echo $_GET['matricule']; ?}}<br>
                <button><a href="accueil.php">Accueil</a></button>
            </div>
        {{?php endif; ?}}
    </div>
</body>
</html>
