<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Router;

class CategoryController extends Controller {
  public function getCategories() {
    $categories = Category::find();

    $this->render('admin/categories.twig', [
      'title' => 'Categories',
      'categories' => $categories,
    ]);

  }

  public function getAddCategory() {
    $this->render('admin/addCategory.twig', ['title' => "Ajouter une categorie"]);
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
}