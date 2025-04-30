<!DOCTYPE html>
<html lang="en">
<head>
<title>Colo Shop</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Colo Shop Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">
<link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
<link rel="stylesheet" type="text/css" href="plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="styles/contact_styles.css">
<link rel="stylesheet" type="text/css" href="styles/contact_responsive.css">
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
								<li><a href="#articles">Articles</a></li>
								<li><a href="#promotion">Promotion</a></li>
								<li><a href="#propos">A propos</a></li>
								<li><a href="#contact">contact</a></li>
							</ul>
							<ul class="navbar_user">
								<li><a href="https://www.facebook.com/grama.zoffa" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="https://wa.me/22990839467" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
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
				<li class="menu_item"><a href="index.php">Accueil</a></li>
				<li class="menu_item"><a href="#articles">Articles</a></li>
				<li class="menu_item"><a href="#promotion">Promotion</a></li>
				<li class="menu_item"><a href="#propos">A propos</a></li>
				<li class="menu_item"><a href="#contact">contact</a></li>
			</ul>
		</div>
	</div>

	<!-- Slider -->

	<div class="main_slider" style="background-image:url(images/slider_1.jpg)">
		<div class="container fill_height">
			<div class="row align-items-center fill_height">
				<div class="col">
					<div class="main_slider_content">
						<h6>Bienvenue sur notre boutique en ligne !</h6>
						<h1>Découvrez une variété d'articles spécialement sélectionnés pour vous.</h1>
						<div class="red_button shop_now_button"><a href="articles.php">Acheter</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Banner -->

	<div class="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(images/banner_1.jpg)">
						<div class="banner_category">
							<a href="articles.php">Femmes</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(images/banner_2.jpg)">
						<div class="banner_category">
							<a href="articles.php">Accessories</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="banner_item align-items-center" style="background-image:url(images/banner_3.jpg)">
						<div class="banner_category">
							<a href="articles.php">Hommes</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- New Arrivals -->

	<div class="new_arrivals" id="articles">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>Nos Articles</h2>
                </div>
            </div>
        </div>

        <?php
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);

            // Connexion à la base de données
            $host = 'sql304.infinityfree.com';
            $user = 'if0_38858947';
            $password = 'HQ5IIe6qUzg';
            $dbname = 'if0_38858947_dbsite_ventes';

            $conn = new mysqli($host, $user, $password, $dbname);
            if ($conn->connect_error) {
                die('Erreur de connexion : ' . $conn->connect_error);
            }

            // Récupération de la catégorie sélectionnée
            $selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

            // Récupérer les catégories distinctes
            $categories = [];
            $result = $conn->query("SELECT DISTINCT categorie FROM articles");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row['categorie'];
                }
            }
        ?>

        <!-- Affichage des boutons de filtre -->
        <div class="row align-items-center mb-4">
            <div class="col text-center">
                <div class="new_arrivals_sorting">
                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center <?= ($selectedCategory == '') ? 'active is-checked' : '' ?>">
                            <a href="?category=" style="text-decoration: none; color: inherit;">Tous</a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center <?= ($selectedCategory == $cat) ? 'active is-checked' : '' ?>">
                                <a href="?category=<?= urlencode($cat) ?>" style="text-decoration: none; color: inherit;">
                                    <?= ucfirst($cat) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
                    <?php
                    // Requête SQL selon la catégorie choisie + LIMIT 6
                    if ($selectedCategory) {
                        $sql = "SELECT * FROM articles WHERE categorie = ? LIMIT 5";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $selectedCategory);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $sql = "SELECT * FROM articles LIMIT 5";
                        $result = $conn->query($sql);
                    }

                    // Affichage des articles
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

                                $numero_whatsapp = "22990839467";
                                $message = "Bonjour, je suis intéressé par cet article : https://gramabusiness.wuaze.com/articles.php\nTitre : " . urlencode($row['titre']);
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

        <!-- Bouton Voir Plus -->
        <div class="row mt-4">
            <div class="col text-center">
                <a href="articles.php" class="btn btn-danger">Voir tous les articles</a>
            </div>
        </div>
    </div>
</div>


	<!-- Deal of the week -->

	<div class="deal_ofthe_week"id="propos">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="deal_ofthe_week_img">
						<img src="images/banner_1.jpg" alt="">
					</div>
				</div>
				<section id="a-propos" class="py-5 bg-light">
					<div class="container">
						<div class="row justify-content-center align-items-center">
							<div class="col-lg-10 text-center">
								<div class="p-4 shadow rounded bg-white" data-aos="zoom-in" data-aos-delay="100">
									<h2 class="mb-4" style="font-weight: 700;">À propos de <span style="color: rgb(238, 57, 57);">GRAMA BUSINESS</span></h2>
									<p class="lead">
										Bienvenue sur <strong>GRAMA BUSINESS</strong>, votre boutique en ligne dédiée à la mode et aux tendances pour hommes et femmes.
									</p>
									<p>
										Nous vous proposons une large sélection d'articles de qualité : vêtements, chaussures, accessoires et bien plus encore, à des prix imbattables.
										En plus, profitez de <strong>réductions exclusives</strong> et d’un service <strong>rapide, fiable et sécurisé</strong>.
									</p>
									<p>
										En plus de la vente, nous offrons une opportunité unique d'affiliation . Vous souhaitez gagner de l'argent en collaborant avec nous ? 
									</p>
									<p>
										Devenez affilié et recommandez nos produits à votre entourage. À chaque vente réalisée grâce à votre lien, vous recevez une commission. 
										C'est une façon simple et efficace de monétiser votre audience tout en partageant des produits de qualité.
									</p>
									<div class="my-4 d-flex justify-content-center gap-4 flex-wrap">
										<div class="d-flex flex-column align-items-center">
											<i class="fa fa-truck fa-2x mb-2 text-primary"></i>
											<span>Livraison rapide</span>
										</div>
										<p>----</p>
										<div class="d-flex flex-column align-items-center">
											<i class="fa fa-users fa-2x mb-2 text-success"></i>
											<span>Service client réactif</span>
										</div>
										<p>----</p>
										<div class="d-flex flex-column align-items-center">
											<i class="fa fa-credit-card fa-2x mb-2 text-danger"></i>
											<span>Paiements sécurisés</span>
										</div>
									</div>
									<a href="#contact" class="btn btn-danger text-white px-4 py-2 mt-3 rounded-pill shadow">Nous rejoindre</a>
								</div>
							</div>
						</div>
					</div>
				</section>

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
							<h6>CACH avant la livraison</h6>
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

	<div class="container contact_container" id="promotion">
		<!-- Map Container -->

		<div class="row">
		<div class="col">
			<div id="google_map">
			<div class="container">
				<video controls autoplay muted loop style="width: 100%; border-radius: 10px;">
					<source src="images/Grama_business_vid.mp4" type="video/mp4">
					Votre navigateur ne supporte pas la lecture de vidéos.
				</video>
			</div>
		</div>
	</div>
	</div>

		<!-- Contact Us -->

		<div class="row" id="contact">

			<div class="col-lg-6 contact_col"><br><br><br>
				<div class="contact_contents">
					<h1>Contactez-nous</h1>
					<p> Il existe de nombreuses façons de nous contacter. 
						Vous pouvez nous écrire un mot, nous appeler ou envoyer un e-mail, choisissez ce qui vous convient le mieux.</p>
					<div>
						<p>Téléphone : +229 01 90 83 94 67</p>
						<p>Email : emmazoblikpo@gmail.com</p>
					</div>
					<div>
						<p>Adresse : Cotonou, Bénin</p>
					</div>
					<div>
						<p>Heures d’ouverture : 24h/24h du lundi au Dimanche</p>
					</div>
				</div>

				<!-- Follow Us -->

				<div class="follow_us_contents">
					<h1>Follow Us</h1>
					<ul class="social d-flex flex-row">
						<li><a href="https://www.facebook.com/grama.zoffa" style="background-color: #3a61c9" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="https://wa.me/22990839467" style="background-color: #41a1f6"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
					</ul>
				</div>

			</div>

			<div class="col-lg-6 get_in_touch_col">
				<div class="get_in_touch_contents"><br><br><br>
					<h1></h1>
					<p>Remplissez le formulaire ci-dessous pour recevoir une lettre gratuite et confidentielle.</p>
					<form action="post">
						<div>
							<input id="input_name" class="form_input input_name input_ph" type="text" name="name" placeholder="Name" required="required" data-error="Name is required.">
							<input id="input_email" class="form_input input_email input_ph" type="email" name="email" placeholder="Email" required="required" data-error="Valid email is required.">
							<input id="input_website" class="form_input input_website input_ph" type="url" name="name" placeholder="Website" required="required" data-error="Name is required.">
							<textarea id="input_message" class="input_ph input_message" name="message"  placeholder="Message" rows="3" required data-error="Please, write us a message."></textarea>
						</div>
						<div>
							<button id="review_submit" type="submit" class="red_button message_submit_btn trans_300" value="Submit">send message</button>
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
							<li><a href="https://wa.me/22990839467"target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>
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
<script src="js/custom.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
<script src="plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="js/contact_custom.js"></script>
</body>

</html>
