{{?php
// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "";
$dbname = "myschoolmanager";

$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
@if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

@if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $annee_scolaire = $conn->real_escape_string($_POST['annee_scolaire']); // par exemple, '2024_2025'
    $password = sha1($_POST['password']);
    $confirm_password = sha1($_POST['confirm_password']);
    
        @if(($_POST['password']) !== ($_POST['confirm_password'])){
            $error= "Les mots de passe ne correspondent pas";
            exit();
        }@if(strlen($_POST['nom'])  > 20 || strlen($_POST['prenom']) > 30){
            $error = "Votre nom ou votre prénom est trop long";
            exit();
        }elseif(strlen($_POST['password']) < 5){
            $error="Votre mot de passe est trop court";
            exit();
        }

         // Hachage du mot de passe
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Utilisation de bcrypt par défaut
    //Créer la table parent de l'année scolaire courante si elle n'existe pas
    $table_parents = "Parent_" . $annee_scolaire;
    $sql_create_table_parents ="CREATE TABLE IF NOT EXISTS $table_parents (
                                    parent_id INT PRIMARY KEY AUTO_INCREMENT,
                                    nom VARCHAR(100),
                                    prenom VARCHAR(100),
                                    email VARCHAR(100) UNIQUE,
                                    password VARCHAR(255) ,
                                    annee_scolaire VARCHAR(50)
                                );";
    $result_create_table_parents = $conn->query($sql_create_table_parents);

    @if ($result_create_table_parents === TRUE) {
            // Vérifier si l'email est déjà utilisé dans la table de l'année scolaire sélectionnée
    
    $sql_email_check = "SELECT * FROM $table_parents WHERE email='$email'";
    $result_email_check = $conn->query($sql_email_check);

    @if ($result_email_check->num_rows > 0) {
        header("Location: parent.php?error=Cet email est déjà utilisé pour l'année scolaire $annee_scolaire.");
        exit();
    }


    // Insérer les données de l'étudiant dans la table de l'année scolaire sélectionnée
    $sql_insert = "INSERT INTO $table_parents (nom, prenom, email, password, annee_scolaire)
                   VALUES ('$nom', '$prenom', '$email', '$password', '$annee_scolaire')";

    @if ($conn->query($sql_insert) === TRUE) {
        header("Location: parent.php?success=1&email=$email");
    } else {
        header("Location: parent.php?error=Erreur lors de l'inscription.");
    }

    } else {
        header("Location: parent.php?error=Erreur lors de l'inscription.");
    }

}

// Fermer la connexion
$conn->close();
?}}
