
<?php //Erstmal grob aus der PC4U für uns angepasst, die Einträge sind nur Vorschläge?>

<html lang='de'>
	<head>
		<title><?=isset($title)? $title : 'SnackIt'?></title>
		<meta charset='UTF-8'/>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='shortcut icon' type='image/x-icon' href='assets/pictures/favicon/favicon.ico'>
		<link rel='stylesheet' type='text/css' href='assets/css/layout.css'>
		<?php if(isset($css) && is_array($css)) : ?>
			<?php foreach($css as $file) : ?>
			<link rel='stylesheet' type='text/css' href="assets/css/<?=$file?>.css">
			<?php endforeach; ?>
		<?php endif; ?>
	</head>
	<body>
		<div class='content-wrap'>
			<section class=top>
				<header>
					<nav>
						<ul>
							<li><a href='index.php?c=pages&a=index'>zurück zur Startseite</a></li>
							<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
							<li class=rightNav><a href='index.php?c=accounts&a=profile'>Profil</a></li>
							<li class=rightNav><a href='index.php?c=accounts&a=logout'>Abmelden</a></li>
							<?php else : ?>
							<li class=rightNav><a href='index.php?c=accounts&a=login'>Login</a></li>
							<li class=rightNav><a href='index.php?c=accounts&a=register'>Registrieren</a></li>
							<?php endif; ?>
							<li class=rightNav><a href='index.php?a=shoppingCart'>Warenkorb<?=(isset($_SESSION['shoppingCartCount']) && $_SESSION['shoppingCartCount'] > 0)? ' ('.$_SESSION['shoppingCartCount'].')' : ''?></a></li>
						</ul>
					</nav>
				</header>
				<nav class=topnav>
					<div class=menu-container>
						<a class=icon id=icon-btn>&#9776;</a>
						<ul class=menu>
							
							<li><a href='index.php?c=products&a=list&t=getraenke'>Getränke</a></li>
							<li><a href='index.php?c=products&a=list&t=studentenfutter'>Studentenfutter</a></li>
							<li><a href='index.php?c=products&a=list&t=backware'>Backware</a></li>
                            <li><a href='index.php?c=products&a=list&t=knabberzeug'>Knabberzeug</a></li>
							<li><span class=link>Zubehör<i class="arrow down"></i></span>
								<ul class=submenu>
									<li><a href='index.php?c=products&a=list&t=soßen'>Soßen</a></li>
									<li><a href='index.php?c=products&a=list&t=deko'>Deko</a></li>
									<li><a href='index.php?c=products&a=list&t=more'>Weiteres Zubehör</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</section>
			<main>
				<?php echo $body ?>
			</main>
		</div>
		<footer>
			<a href='index.php?a=documentation'>Dokumentation</a>
			<a href='index.php?a=agb'>AGB</a>
			<a href='index.php?a=impressum'>Impressum</a>
			<a href='index.php?a=privacyPolicy'>Datenschutzerklärung</a>
			&copy; SnackIt (2020-2021)
		</footer>

		<?php if(isset($js) && is_array($js)) : ?>
			<?php foreach($js as $file) : ?>
			<script src='assets/js/<?=$file?>.js'></script>
			<?php endforeach; ?>
		<?php endif; ?>
	</body>
</html>
