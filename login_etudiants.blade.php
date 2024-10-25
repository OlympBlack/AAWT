<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Étudiants</title>
</head>

</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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

        /* Conteneur principal pour le formulaire */
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        /* Style des champs de saisie */
        input[type="email"],
        input[type="password"], select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Style des boutons */
        input[type="submit"] {
            background-color: #5c6bc0;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #3949ab;
        }

        
        /* Style pour le message d'erreur */
        i {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: block;
        }

    </style>
</head>
<body>
    <form method="post" action="etudiants.php"> 
        Login:<input type="email" name="login" placeholder="Entrer votre email"><br><br>
        Mot de passe:<input type="password" name="password" placeholder="Entrer votre mot de passe"><br><br>
        <label for="annee_scolaire">Année Scolaire:</label>
            <select id="annee_scolaire" name="annee_scolaire" required>
                <option value="2024_2025">2024-2025</option>
                <option value="2023_2024">2023-2024</option>
                <option value="2022_2023">2022-2023</option>
            </select><br><br>

        <input type="submit" name="connexion" value="Etudiants"><br><br>
        <i style="color:red">
            {{?php
            if(isset($_GET['message'])){
                echo $_GET['message'] ."<br>";
            }
            ?}}
        </i>
    </form>
</body>
</html>
