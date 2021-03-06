<html class=layout lang='de'>

<head>

	<meta charset='UTF-8' />
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="assets/css/layout.css">
	<!-- <?php //if(isset($css) && is_array($css)) : 
			?>
			<?php //foreach($css as $file) : 
			?>
			<link rel='stylesheet' type='text/css' href="assets/css/login.css">
			<?php //endforeach; 
			?>
		<?php //endif; 
		?> -->
</head>

<body>
	<div class='content-wrap'>
		<section>
			<header>
				<nav>
					<div class="stripe"><a href='index.php?c=pages&a=startseite'><img class="logo" src='assets/pictures/logo.png'></a></div>
					<input id="nav-toggle" type="checkbox">


					<ul class="left">
						<label for="nav-toggle" class="icon-burger">
							<div class="line"></div>
							<div class="line"></div>
							<div class="line"></div>
						</label>

						<div class="dropdown"><a href='index.php?c=pages&a=Snacks&t=Snacks'>Snacks</a>
							<div class="dropdown-content">
								<li><a href='index.php?c=pages&a=Snackssalty&t=Snackssalty'>Herzhaftes</a></li>
								<li><a href='index.php?c=pages&a=Snackssweet&t=Snackssweet'>Süßes</a></li>
							</div>
						</div>

						</li>
						<li><a href='index.php?c=pages&a=Getränke&t=Getränke'>Getränke</a></li>
						<li><a href='index.php?c=pages&a=Angebote&t=Angebote'>Angebote</a></li>



					</ul>

					<ul class="right">
						<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
							<li class=rightNav><a href='index.php?c=pages&a=profil'>Profil</a></li>
							<li class=rightNav><a href='index.php?c=pages&a=logout'>Abmelden</a></li>
						<?php else : ?>
							<li class=rightNav><a href='index.php?c=pages&a=login'>Login</a></li>
							<li class=rightNav><a href='index.php?c=pages&a=register'>Registrieren</a></li>
						<?php endif; ?>
						<li class=rightNav><a href='index.php?a=shoppingCart'>Warenkorb<?= (isset($_SESSION['shoppingCartCount']) && $_SESSION['shoppingCartCount'] > 0) ? ' (' . $_SESSION['shoppingCartCount'] . ')' : '' ?></a></li>

					</ul>


				</nav>
			</header>
		</section>
		<main>

			<?php
			//echo $body;
			$controller->render();
			?>
		</main>
	</div>


	<?php if (isset($js) && is_array($js)) : ?>
		<?php foreach ($js as $file) : ?>
			<script src='assets/js/<?= $file ?>.js'></script>
		<?php endforeach; ?>
	<?php endif; ?>
</body>
<footer>
	<br>
	<a href='index.php?a=agb'>AGB</a>
	<a href='index.php?a=impressum'>Impressum</a>
	<a href='index.php?a=datenschutzerklärung'>Datenschutzerklärung</a><br>
	<br>
	&copy; SnackIt (2020-2021)
</footer>

</html>