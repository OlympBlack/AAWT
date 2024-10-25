<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
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
            flex-direction: column;
            min-height: 100vh;
        }

        /* Style pour le lien de retour */
        a {
            color: #5c6bc0;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        a:hover {
            color: #3949ab;
        }

        /* Style pour le titre principal */
        h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        h4 {
            color: #555;
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Style pour le tableau */
        table {
            border-collapse: collapse;
            width: 90%;
            max-width: 1000px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }

        table th {
            background-color: #5c6bc0;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Style du bouton */
        button {
            background-color: #5c6bc0;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3949ab;
        }

        button a {
            color: white;
            text-decoration: none;
        }

        /* Bouton d'impression */
        .print-button {
            background-color: #ff7043;
        }

        .print-button:hover {
            background-color: #ff5722;
        }

    </style>
</head>
<body>
    <a href="accueil.php">Retour à l'accueil</a>

{{?php
// Connexion au serveur
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myschoolmanager";
$idcom = new mysqli($servername, $username, $password, $dbname);

@if (isset($_POST['connexion'])) {
    @if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['annee_scolaire'])) {
        $email = htmlspecialchars($_POST['login']);
        $password = sha1($_POST['password']);
        $annee_scolaire = $_POST['annee_scolaire'];

        $table_parents = "Parent_" . $annee_scolaire;
        $table_etudiants = "Etudiant_" . $annee_scolaire;

        $request = $idcom->prepare("SELECT * FROM $table_parents WHERE email = ? AND password = ?");
        $request->bind_param('ss', $email, $password);
        $request->execute();
        $verify = $request->get_result();
        
            // Requête pour récupérer l'utilisateur à partir de l'email
           /* $sql = "SELECT * FROM $table_parents WHERE email = ?";
            $stmt = $idcom->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
        
            @if ($result->num_rows > 0) {
                // Récupérer l'utilisateur
                $user = $result->fetch_assoc();
        
                // Vérifier le mot de passe avec password_verify()
                @if (password_verify($password, $user['password'])) {
                    // Connexion réussie
                } else {
                    // Mot de passe incorrect
                    
                }
            } else {
                // Utilisateur non trouvé
                echo "Aucun utilisateur trouvé avec cet email.";
            }
        
            $stmt->close();*/        

        @if ($verify->num_rows == 1) {
                    $requete = "SELECT * FROM $table_etudiants WHERE parent_email = '$email'";
                    $result = $idcom->query($requete);
        
                    @if (!$result) {
                        $message = "Lecture impossible";
                    } else {
                        $users = $result->num_rows;
                        echo "<h3>Mes étudiants</h3>";
                        echo "<h4>Vous avez inscrit $users étudiants</h4>";
                        echo "<table>";
                        echo "<tr><th>N° d'incription</th> <th>N° matricule</th> <th>Nom</th> <th>Prénom</th> <th>Email</th> <th>Classe</th> <th>Année Scolaire</th></tr>";
        
                        while ($ligne = $result->fetch_array(MYSQLI_NUM)) {
                            echo "<tr>";
                            foreach ($ligne as $valeur) {
                                echo "<td>$valeur</td>";
                            }
                            echo "</tr>";
                        }
        
                        echo "</table>";
                    }
                    $result->free();

        } else {
            header("Location: imposteur.php");
            exit();
        }
    } else {
        header("Location: login_etudiants.php?message=Veuillez remplir tous les champs");
        exit();
    }
}
$idcom->close();
?}}

    <!-- Bouton d'impression -->
    <button class="print-button" onclick="window.print()">Imprimer la liste</button>
    
    <!-- Bouton Ajouter un étudiant -->
    <button><a href="login_inscription.php">Ajouter</a></button>

</body>
</html>
