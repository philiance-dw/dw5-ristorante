<?php

$uri = $_SERVER['SCRIPT_NAME'];

$page = explode('.php', $uri)[0];

?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="./assets/scss/main.css">

		<?php if (isset($css)): ?>
		<link rel="stylesheet" href="./assets/scss/<?=$css;?>/<?=$css;?>.css">
		<?php endif;?>

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link
			href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Dancing+Script:wght@600&family=Parisienne&family=Roboto&display=swap"
			rel="stylesheet">
		<title>Ristorante | <?=$title;?></title>
	</head>

	<body>

		<header class="main__header">
			<a href='/' class="ristorante-logo"></a>
			<nav>
				<ul>
					<li><a class="<?=str_contains($page, 'index') ? "active" : '';?>" href="/">Accueil</a>
					</li>
					<li><a class="<?=str_contains($page, "about") ? "active" : "";?>" href="about.php">A propos</a></li>
					<li><a class="<?=str_contains($page, "menu") ? "active" : '';?>" href="menu.php">Menu</a></li>
					<li><a class="<?=str_contains($page, "contact") ? "active" : '';?>" href="contact.php">Contact</a></li>
				</ul>
			</nav>
		</header>
		<main>