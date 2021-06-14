<?php
$title = "Menu";
$css = "menu";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . '/database/database.php';

$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll();

$dishesWithCategory = [];

foreach ($categories as $category) {
  $statement = $pdo->prepare("SELECT * FROM dishes WHERE category_id=:id");
  $statement->bindValue(':id', $category['id']);
  $statement->execute();
  $dishes = $statement->fetchAll();

  $dishesWithCategory[$category['name']] = $dishes;
}

require_once './includes/header.php';?>

<div class="container">
	<ul>
		<?php foreach ($dishesWithCategory as $category => $value): ?>
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