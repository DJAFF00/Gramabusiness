<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'rif0_38831282oot';
$password = '1OY5B3bJzXjO';
$dbname = 'if0_38831282_site_ventes';

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Ajouter un nouvel article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['title']; // Correspond au champ 'titre' dans la table
    $description = $_POST['description']; // Ajoutez ce champ dans le formulaire
    $prix = $_POST['price']; // Correspond au champ 'prix' dans la table
    $image = $_FILES['image']['name'];
    $categorie = $_POST['categorie'];

    // Chemin pour l'image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Créer le dossier uploads s'il n'existe pas
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Déplacer l'image téléchargée
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO articles (titre, description, prix, image, categorie) VALUES ('$titre', '$description', '$prix', '$image', '$categorie')";
        if ($conn->query($sql) === TRUE) {
            // Redirection vers admin.php après insertion
            header("Location: admin.php");
            exit();
        } else {
            echo "Erreur : " . $conn->error;
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}

// Fermer la connexion
$conn->close();
?>
