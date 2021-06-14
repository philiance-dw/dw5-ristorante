<?php
$title = "Menu";
$css = "menu";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . '/database/database.php';

$statement = $pdo->prepare("SELECT c.name, d.id, d.name, d.description, d.size, d.price, d.created_at, d.updated_at FROM categories as c JOIN dishes as d ON c.id=d.category_id");
$statement->execute();
$dishes = $statement->fetchAll(PDO::FETCH_GROUP);

require_once './includes/header.php';?>

<div class="container">
	<ul>
		<?php foreach ($dishes as $category => $value): ?>
		<li>
			<h2><?=$category;?></h2>
			<ul>
				<?php foreach ($value as $dish): ?>
				<li><a href="#"><?=$dish['name'];?></a></li>
				<?php endforeach;?>
			</ul>
		</li>
		<?php endforeach;?>
	</ul>
</div>

<?php require_once './includes/footer.php';?>