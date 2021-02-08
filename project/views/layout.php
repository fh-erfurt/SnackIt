
<html class=layout lang='de'>
	<head>
		
		<meta charset='UTF-8'/>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="assets/css/layout.css">
		<!-- <?php //if(isset($css) && is_array($css)) : ?>
			<?php //foreach($css as $file) : ?>
			<link rel='stylesheet' type='text/css' href="assets/css/login.css">
			<?php //endforeach; ?>
		<?php //endif; ?> -->
	</head>
	<body>
		<div class='content-wrap'>
			<section class=top>
				<header>
					<nav class=navbarTop>
						<ul>
							<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
							<li class=rightNav><a href='index.php?c=pages&a=profile'>Profil</a></li>
							<li class=rightNav><a href='index.php?c=pages&a=logout'>Abmelden</a></li>
							<?php else : ?>
							<li class=rightNav><a href='index.php?c=pages&a=login'>Login</a></li>
							<li class=rightNav><a href='index.php?c=pages&a=register'>Registrieren</a></li>
							<?php endif; ?>
							<li class=rightNav><a href='index.php?a=shoppingCart'>Warenkorb<?=(isset($_SESSION['shoppingCartCount']) && $_SESSION['shoppingCartCount'] > 0)? ' ('.$_SESSION['shoppingCartCount'].')' : ''?></a></li>
						</ul>
					</nav>
				</header>
				<nav class=navbarMain>
					<div class=menu-container>
						<ul class=menu>
							<li><a href='index.php?c=pages&a=startseite' style="margin-left: 16px; margin-right: 0px; margin-top: -48px;" ><img src="assets\pictures\logomenu.png" class="logomenu" ></a><li>
							<li><a href='index.php?c=pages&a=Snacks&t=Snacks'>Snacks</a></li>
							<li><a href='index.php?c=pages&a=list&t=studentenfutter' >Getränke</a></li>
							<li><a href='index.php?c=pages&a=list&t=backware'>Angebote</a></li>
							<li><a href='index.php?c=pages&a=list&t=knabberzeug'>Knabberzeug</a></li>
								<!-- <ul class=submenu>
									<li><a href='index.php?c=products&a=list&t=soßen'>Soßen</a></li>
									<li><a href='index.php?c=products&a=list&t=deko'>Deko</a></li>
									<li><a href='index.php?c=products&a=list&t=more'>Weiteres Zubehör</a></li>
								</ul> -->
						</ul>
					</div>
				</nav>
			</section>
			<main>
				
				<?php 
				//echo $body;
				$controller->render();
				?>
			</main>
		</div>
		<footer>
			<a href='index.php?a=documentation'>Dokumentation</a>
			<a href='index.php?a=agb'>AGB</a>
			<a href='index.php?a=impressum'>Impressum</a>
			<a href='index.php?a=privacyPolicy'>Datenschutzerklärung</a><br>
			&copy; SnackIt (2020-2021)
		</footer>

		<?php if(isset($js) && is_array($js)) : ?>
			<?php foreach($js as $file) : ?>
			<script src='assets/js/<?=$file?>.js'></script>
			<?php endforeach; ?>
		<?php endif; ?>
	</body>
</html>
