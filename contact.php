<?php
$title = "Contact";
$css = "contact";
require_once './includes/header.php';?>

<form method="POST">
	<div><label for="firstName">Prénom</label><input id="firstName" name="firstName" type="text"
			placeholder="Votre prénom..."></div>
	<div><label for="lastName">Nom</label><input id="lastName" name="lastName" type="text" placeholder="Votre nom...">
	</div>
	<div><label for="email">Email</label><input id="email" name="email" type="email" placeholder="Votre email..."></div>
	<div><label for="message">Message</label><textarea id="message" name="message"
			placeholder="Votre message..."></textarea></div>
	<button>Envoyer</button>
</form>


<?php require_once './includes/footer.php';?>