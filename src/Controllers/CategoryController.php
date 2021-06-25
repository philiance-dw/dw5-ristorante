<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Router;

class CategoryController extends Controller {
  public function getCategories() {
    [
      'limit' => $limit,
      'offset' => $offset,
      'page' => $page,
      'nbPages' => $nbPages,
    ] = Router::paginate(Category::class);

    $categories = Category::find(['limit' => $limit, 'offset' => $offset]);

    $content = [];

    foreach ($categories as $category) {
      $id = $category->getId();
      $action = <<< EOL
							<a data-tooltip-left="cliquer pour modifier" class="ristorante-edit" href="/admin/categories/modifier/$id"></a>
							<a data-tooltip-left="cliquer pour supprimer" class="ristorante-trash" href="/admin/categories/supprimer/$id"></a>
			EOL;

      $content[] = [
        $category->getId(),
        $category->getName(),
        $category->getCreatedAt(),
        $category->getUpdatedAt() ?? '-',
        $action,
      ];
    }

    $this->render('admin/readData.twig', [
      'title' => 'Catégories',
      'headings' => ['Id', 'Nom', 'Date de création', 'Date de modification'],
      'datas' => $content,
      'entity' => 'categories',
      'linkText' => 'Ajouter une catégorie',
      'nbPages' => $nbPages,
      'page' => $page,
    ]);

  }

  public function getAddCategory() {
    $this->render('admin/addCategory.twig', ['title' => "Ajouter une categorie"]);
  }

  public function getEditCategory(int $id) {

    $category = Category::findOne(['id' => $id]);

    $this->render('admin/addCategory.twig', [
      'title' => "Modifier une categorie",
      'category' => $category,
      'editMode' => (bool) $category,
      'data' => ['name' => $category->getName()],
    ]);
  }

  public function postAddCategory() {
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      $category = new Category();
      $category->setName($_POST['name'])
        ->save();

      Router::redirect('/admin/categories');
    }

    $this->render('admin/addCategory.twig', [
      'title' => "Ajouter une categorie",
      'errors' => $errors,
      'data' => $_POST,
    ]);
  }

  public function postEditCategory(int $id) {
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      $category = new Category();
      $category->setId($id)
        ->setName($_POST['name'])
        ->save();

      Router::redirect('/admin/categories');
    }

    $this->render('admin/addCategory.twig', [
      'title' => "Modifier une categorie",
      'errors' => $errors,
      'data' => $_POST,
      'editMode' => true,
    ]);
  }

  public function deleteCategory(int $id) {
    Category::deleteOne($id);
    Router::redirect('/admin/categories');
  }
}