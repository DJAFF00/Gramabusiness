<?php
// Vérifier si l'ID de l'article a été passé en paramètre GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    // Connexion à la base de données
    $conn = new mysqli('sql304.infinityfree.com', 'if0_38858947', 'HQ5IIe6qUzg', 'if0_38858947_dbsite_ventes');

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Préparer la requête de suppression
    $sql = "DELETE FROM articles WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Lier le paramètre
        $stmt->bind_param("i", $article_id);

        // Exécuter la requête
        if ($stmt->execute()) {
            // La suppression a réussi
            header("Location: admin.php?suppression_reussie=1");
            exit();
        } else {
            // Erreur lors de la suppression
            header("Location: admin.php?suppression_echec=1");
            exit();
        }

        // Fermer la requête préparée
        $stmt->close();
    } else {
        // Erreur lors de la préparation de la requête
        header("Location: admin.php?erreur_sql=1");
        exit();
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Si l'ID n'est pas valide, rediriger avec un message d'erreur
    header("Location: admin.php?id_invalide=1");
    exit();
}
?>