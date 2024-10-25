{{?php
session_start();
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
    $classe = $conn->real_escape_string($_POST['classe']);
    $annee_scolaire = $conn->real_escape_string($_POST['annee_scolaire']); // par exemple, '2024_2025'
    $parent_email = $_SESSION['parent_email']; // Get parent email from session

    //Créer la table étudiant de l'année scolaire courante si elle n'existe pas
    $table_parents = "Parent_" . $annee_scolaire;
    $table_etudiants = "Etudiant_" . $annee_scolaire;
    $sql_create_table_etudiants =  "CREATE TABLE IF NOT EXISTS $table_etudiants (
                                        etudiant_id INT PRIMARY KEY AUTO_INCREMENT,
                                        matricule VARCHAR(20) UNIQUE,
                                        nom VARCHAR(100),
                                        prenom VARCHAR(100),
                                        parent_email VARCHAR(100),
                                        classe VARCHAR(50),
                                        annee_scolaire VARCHAR(50),
                                        FOREIGN KEY (parent_email) REFERENCES $table_parents(email)
                                    );";
    $result_create_table_etudiants = $conn->query($sql_create_table_etudiants);

    @if ($result_create_table_etudiants === TRUE) {
            // Vérifier si l'email est déjà utilisé dans la table de l'année scolaire sélectionnée
   /* $sql_email_check = "SELECT * FROM $table_etudiants WHERE email='$email'";
    $result_email_check = $conn->query($sql_email_check);

    @if ($result_email_check->num_rows > 0) {
        header("Location: index.php?error=Cet email est déjà utilisé pour l'année scolaire $annee_scolaire.");
        exit();
    }*/

    // Générer un numéro de matricule unique
    $matricule = strtoupper(substr($prenom, 0, 2)) . strtoupper(substr($nom, 0, 2)) . rand(1000, 9999);

    // Vérifier si le matricule est déjà utilisé dans la table de l'année scolaire
    $sql_matricule_check = "SELECT * FROM $table_etudiants WHERE matricule='$matricule'";
    $result_matricule_check = $conn->query($sql_matricule_check);

    while ($result_matricule_check->num_rows > 0) {
        $matricule = strtoupper(substr($prenom, 0, 2)) . strtoupper(substr($nom, 0, 2)) . rand(1000, 9999);
        $result_matricule_check = $conn->query($sql_matricule_check);
    }

    // Insérer les données de l'étudiant dans la table de l'année scolaire sélectionnée
    $sql_insert = "INSERT INTO $table_etudiants (matricule, nom, prenom, parent_email, classe, annee_scolaire)
                   VALUES ('$matricule', '$nom', '$prenom', '$parent_email', '$classe', '$annee_scolaire')";

    @if ($conn->query($sql_insert) === TRUE) {
        header("Location: etudiant.php?success=1&matricule=$matricule");
    } else {
        header("Location: etudiant.php?error=Erreur lors de l'inscription.");
    }

    } else {
        header("Location: etudiant.php?error=Erreur lors de l'inscription.");
    }


}

// Fermer la connexion
$conn->close();
?}}
