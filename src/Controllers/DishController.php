<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Models\Dish;
use App\Router;

class DishController extends Controller {

  public function getDishes() {
    [
      'limit' => $limit,
      'offset' => $offset,
      'page' => $page,
      'nbPages' => $nbPages,
    ] = Router::paginate(Dish::class);

    $findParams = ['include' => ['categories'], 'limit' => $limit, 'offset' => $offset];

    $dishes = Dish::find($findParams);

    $content = [];

    foreach ($dishes as $dish) {
      $id = $dish->getId();
      $action = <<< EOL
							<a data-tooltip-left="cliquer pour modifier" class="ristorante-edit" href="/admin/plats/modifier/$id"></a>
							<a data-tooltip-left="cliquer pour supprimer" class="ristorante-trash" href="/admin/plats/supprimer/$id"></a>
			EOL;

      $content[] = [
        $dish->getId(),
        $dish->getName(),
        $dish->getSize(),
        $dish->getDescription(),
        $dish->getPrice(),
        $dish->getCategoryName(),
        $dish->getCreatedAt(),
        $dish->getUpdatedAt() ?? '-',
        $action,
      ];
    }

    $this->render('admin/readData.twig', [
      'title' => 'Plats',
      'headings' => ['Id', 'Nom', 'Taille', 'Description', "Prix", "Catégorie", 'Date de création', 'Date de modification'],
      'datas' => $content,
      'entity' => 'plats',
      'linkText' => 'Ajouter un plat',
      'nbPages' => $nbPages,
      'page' => $page,
    ]);
  }

  public function getAddDish() {
    $categories = Category::find();
    $this->render('admin/addDish.twig', [
      'title' => 'Ajouter un plat',
      'categories' => $categories,
    ]);
  }

  public function postAddDish() {
    $errors = Form::validate($_POST);

    $uploadFile = Form::uploadFile('/public/uploads/dishes/', $errors);

    if (empty($errors)) {
      $dish = new Dish();
      $dish->setName($_POST['name'])
        ->setSize($_POST['size'])
        ->setDescription($_POST['description'])
        ->setPrice($_POST['price'])
        ->setImageUrl($uploadFile)
        ->setCategoryId($_POST['categoryId'])
        ->save();

      Router::redirect('/admin/plats');
    }

    $this->render('admin/addDish.twig', [
      'title' => 'Ajouter un plat',
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function getEditDish(int $id) {
    $dish = Dish::findOne(['id' => $id]);
    $categories = Category::find();

    $data = [
      'name' => $dish->getName(),
      'size' => $dish->getSize(),
      'description' => $dish->getDescription(),
      'price' => $dish->getPrice(),
      'categoryId' => $dish->getCategoryId(),
    ];

    $this->render('admin/addDish.twig', [
      'title' => "Modifier un plat",
      'dish' => $dish,
      'editMode' => (bool) $dish,
      'data' => $data,
      'categories' => $categories,
    ]);
  }

public function postEditDish(int $id) {
    $errors = Form::validate($_POST);

    $uploadFile = Form::uploadFile('/public/uploads/dishes/', $errors);

    if (empty($errors)) {
      $dish = Dish::findOne(['id' => $id]);
      $dish->setName($_POST['name'])
        ->setSize($_POST['size'])
        ->setDescription($_POST['description'])
        ->setPrice($_POST['price'])
        ->setCategoryId($_POST['categoryId']);

      if ($uploadFile) {
        $dish->setImageUrl($uploadFile);
      }

      $dish->save();

      Router::redirect('/admin/plats');
    }

    $categories = Category::find();

    $this->render('admin/addDish.twig', [
      'title' => "Modifier un plat",
      'errors' => $errors,
      'data' => $_POST,
      'editMode' => true,
      'categories' => $categories,
    ]);
  }



  public function deleteDish(int $id) {
    Dish::deleteOne($id);
    Router::redirect('/admin/plats');
  }

  public function getDishDescriptionPage(int $id) {
    $dish = Dish::findOne(['id' => $id]);

    if (!$dish) {
      $this->render('404.twig', ['title' => 'Page introuvable']);
      return;
    }

    $this->render('dishPage.twig', [
      'title' => 'page ' . $dish->getName(),
      'dish' => $dish,
    ]);
  }
}
