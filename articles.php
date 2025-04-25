<!DOCTYPE html>
<html lang="en">
<head>
<title>Colo Shop Categories</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Colo Shop Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="styles/categories_styles.css">
<link rel="stylesheet" type="text/css" href="styles/categories_responsive.css">
</head>

<body>

<div class="super_container">

	<!-- Header -->

	<header class="header trans_300">

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="index.php">GRAMA<span>Business</span></a>
						</div>
						<nav class="navbar">
							<ul class="navbar_menu">
								<li><a href="index.php">Accueil</a></li>
								
							</ul>
							<ul class="navbar_user">
								<li><a href="https://www.facebook.com/grama.zoffa" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
							</ul>
							<div class="hamburger_container">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>

	</header>

	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item"><a href="#">Accueil</a></li>
				
			</ul>
		</div>
	</div>

	<div class="container product_section_container" id="articles">
		<div class="row">
			<div class="col product_section clearfix">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center">
					<ul>
						<li><a href="index.php">Home</a></li>
						<li class="active"><a href="articles.php"><i class="fa fa-angle-right" aria-hidden="true"></i>Articles</a></li>
					</ul>
				</div>

				<!-- Main Content -->

				<div class="main_content">

					<!-- Products -->
                    <div class="new_arrivals">
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <div class="section_title new_arrivals_title">
                                    <h2>Nos Articles</h2>
                                </div>
                            </div>
                        </div>

                        <?php
                        // Connexion à la base de données
                        $host = 'localhost';
						$user = 'rif0_38831282oot';
						$password = '1OY5B3bJzXjO';
						$dbname = 'if0_38831282_site_ventes';

                        $conn = new mysqli($host, $user, $password, $dbname);
                        if ($conn->connect_error) {
                            die('Erreur de connexion : ' . $conn->connect_error);
                        }

                        // Récupération de la catégorie sélectionnée
                        $selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';

                        // Requête pour récupérer les catégories distinctes
                        $categories = [];
                        $result_cat = $conn->query("SELECT DISTINCT categorie FROM articles");
                        if ($result_cat && $result_cat->num_rows > 0) {
                            while ($row = $result_cat->fetch_assoc()) {
                                $categories[] = $row['categorie'];
                            }
                        }
                        ?>

                        <!-- Affichage des articles -->
                        <div class="row">
                            <div class="col">
                                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
                                    <?php
                                    // Requête SQL selon la catégorie
                                    if (!empty($selectedCategory)) {
                                        $sql = "SELECT * FROM articles WHERE LOWER(categorie) = LOWER(?)";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param('s', $selectedCategory);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                    } else {
                                        $sql = "SELECT * FROM articles";
                                        $result = $conn->query($sql);
                                    }

                                    // Affichage des produits
                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $prix = number_format($row['prix'], 0, '', ' ');
                                            $ancien_prix = $row['ancien_prix'] ?? null;
                                            $has_discount = $ancien_prix && $ancien_prix > $row['prix'];
                                            $reduction = $has_discount ? '-' . round(($ancien_prix - $row['prix']) / $ancien_prix * 100) . '%' : '';

                                            echo '<div class="product-item">';
                                                echo '<div class="product discount product_filter">';
                                                    echo '<div class="product_image">';
                                                        echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="">';
                                                    echo '</div>';

                                                    echo '<div class="product_info">';
                                                        echo '<h6 class="product_name"><a href="#">' . htmlspecialchars($row['titre']) . '</a></h6>';
                                                        echo '<div class="product_price">';
                                                            echo $prix . ' CFA';
                                                            if ($has_discount) {
                                                                echo '<span>' . number_format($ancien_prix, 0, '', ' ') . ' CFA</span>';
                                                            }
                                                        echo '</div>';
                                                    echo '</div>';
                                                echo '</div>';

                                                // Bouton WhatsApp
                                                $numero_whatsapp = "22990839467";
                                                $message = "Bonjour, je suis intéressé par cet article : https://votresite.com/uploads/" . urlencode($row['image']);
                                                echo '<div class="red_button add_to_cart_button"><a href="https://wa.me/' . $numero_whatsapp . '?text=' . urlencode($message) . '" target="_blank">Commander</a></div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<p class="text-center">Aucun article trouvé.</p>';
                                    }

                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				</div>
			</div>
		</div>
	</div>

	<!-- Benefit -->

	<div class="benefit">
		<div class="container">
			<div class="row benefit_row">
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Livraison Gratuite</h6>
							<p>a subi une altération sous une forme ou une autre</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>CACH à la livraison</h6>
							<p>Peut dépendre quelques fois</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Ouvert toute la semaine</h6>
							<p>7j / 7</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Newsletter -->

	<div class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="newsletter_text d-flex flex-column justify-content-center align-items-lg-start align-items-md-center text-center">
						<h4>Newsletter</h4>
						<p>Subscribe to our newsletter and get 20% off your first purchase</p>
					</div>
				</div>
				<div class="col-lg-6">
					<form action="post">
						<div class="newsletter_form d-flex flex-md-row flex-column flex-xs-column align-items-center justify-content-lg-end justify-content-center">
							<input id="newsletter_email" type="email" placeholder="Your email" required="required" data-error="Valid email is required.">
							<button id="newsletter_submit" type="submit" class="newsletter_submit_btn trans_300" value="Submit">subscribe</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
						<ul class="footer_nav">
							<li><a href="index.php">Accueil</a></li>
							<li><a href="#contact">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
						<ul>
							<li><a href="https://www.facebook.com/grama.zoffa" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="footer_nav_container">
						<div class="cr">©2025 Tous droit réservé. </div>
					</div>
				</div>
			</div>
		</div>
	</footer>

</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="js/categories_custom.js"></script>
</body>

</html>
