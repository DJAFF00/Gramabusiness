<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Gestion des Articles</title>
    <link href="gen.jpg" rel="icon">
    <link href="gen.jpg" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
    <style>
        .alert-fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="text-center">Administration - Gestion des Articles</h1>
        </div>
    </header>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Ajouter un nouvel article</h2>
            <form method="POST" action="" enctype="multipart/form-data" class="row g-3" id="articleForm">
            <div id="articlesContainer">
                <div class="row g-3 article-item">
                    <div class="col-md-6">
                        <label class="form-label">Titre de l'article</label>
                        <input type="text" class="form-control" name="title[]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description[]" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prix (cfa)</label>
                        <input type="number" class="form-control" name="price[]" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" name="categorie[]" required>
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="femmes">Femmes</option>
                            <option value="accessoires">Accessoires</option>
                            <option value="hommes">Hommes</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image[]" accept="image/*" required>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="button" class="btn btn-secondary mb-3" onclick="addArticle()">Ajouter un autre article</button><br>
                <button type="submit" class="btn btn-primary w-50">Ajouter les articles</button>
            </div>
        </form>

        </div>
        <script>
            function addArticle() {
                const container = document.getElementById('articlesContainer');
                const firstItem = document.querySelector('.article-item');
                const newItem = firstItem.cloneNode(true);

                // Réinitialiser les champs
                newItem.querySelectorAll('input, textarea, select').forEach(el => {
                    el.value = '';
                });

                container.appendChild(newItem);
            }
        </script>

    </section>

    <div class="container mt-3">
        <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            
            // Connexion à la base de données
            $host = 'sql304.infinityfree.com';
            $user = 'if0_38858947';
            $password = 'HQ5IIe6qUzg';
            $dbname = 'if0_38858947_dbsite_ventes';

            // Établir la connexion
            $conn = new mysqli($host, $user, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connexion échouée : " . $conn->connect_error);
            }

            // Ajouter un nouvel article
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $titles = $_POST['title'];
                $descriptions = $_POST['description'];
                $prices = $_POST['price'];
                $categories = $_POST['categorie'];
                $images = $_FILES['image'];

                $target_dir = "uploads/";

                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                for ($i = 0; $i < count($titles); $i++) {
                    $titre = $conn->real_escape_string($titles[$i]);
                    $description = $conn->real_escape_string($descriptions[$i]);
                    $prix = intval($prices[$i]);
                    $categorie = $conn->real_escape_string($categories[$i]);

                    $imageName = basename($images['name'][$i]);
                    $imageTmpName = $images['tmp_name'][$i];
                    $target_file = $target_dir . $imageName;

                    if (move_uploaded_file($imageTmpName, $target_file)) {
                        $sql = "INSERT INTO articles (titre, description, prix, image, categorie)
                                VALUES ('$titre', '$description', '$prix', '$imageName', '$categorie')";
                        if (!$conn->query($sql)) {
                            echo "<div class='alert alert-danger text-center'>Erreur lors de l'ajout de l'article $titre : " . $conn->error . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger text-center'>Échec du téléchargement de l'image pour l'article $titre.</div>";
                    }
                }

                echo '<div class="alert alert-success text-center" role="alert" id="alertMessage">Tous les articles ont été traités.</div>';
            }


            if (isset($_GET['suppression_reussie'])) {
                echo '<div class="alert alert-success text-center fade show" role="alert" id="alertMessage">L\'article a été supprimé avec succès.</div>';
            }

            if (isset($_GET['suppression_echec'])) {
                echo '<div class="alert alert-danger text-center fade show" role="alert" id="alertMessage">Erreur : Impossible de supprimer l\'article. Veuillez réessayer.</div>';
            }

            if (isset($_GET['id_invalide'])) {
                echo '<div class="alert alert-warning text-center fade show" role="alert" id="alertMessage">Erreur : ID d\'article invalide.</div>';
            }

            if (isset($_GET['erreur_sql'])) {
                echo '<div class="alert alert-danger text-center fade show" role="alert" id="alertMessage">Erreur SQL : Veuillez contacter l\'administrateur.</div>';
            }
        ?>
    </div>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Liste des Articles</h2>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Prix (cfa)</th>
                        <th>Image</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Récupérer les articles (la connexion est déjà établie ci-dessus)
                        $sql_select = "SELECT * FROM articles";
                        $result = $conn->query($sql_select);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['titre']}</td>";
                                echo "<td>" . number_format($row['prix'], 0, ',', ' ') . " cfa</td>";
                                echo "<td><img src='uploads/{$row['image']}' alt='{$row['titre']}' width='50'></td>";
                                echo "<td>{$row['categorie']}</td>";
                                echo "<td>
                                        <a href='delete_article.php?id={$row['id']}' class='btn btn-danger btn-sm'>Supprimer</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Aucun article trouvé.</td></tr>";
                        }

                        // Fermer la connexion à la fin du fichier
                        $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.classList.add('alert-fade-out');
                    setTimeout(function() {
                        alertMessage.remove();
                    }, 500); // Durée de la transition (0.5s)
                }, 3000); // Temps en millisecondes avant la disparition (3 secondes)
            }
        });
    </script>
</body>
</html>