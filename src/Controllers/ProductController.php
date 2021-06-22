<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Models\Product;
use App\Router;

class ProductController extends Controller {
  public function getProducts() {
    $products = Product::find();

    $content = [];

    foreach ($products as $product) {
      $id = $product->getId();
      $action = <<< EOL
							<a data-tooltip="cliquer pour modifier" class="ristorante-edit" href="/admin/produits/modifier/$id"></a>
							<a data-tooltip="cliquer pour supprimer" class="ristorante-trash" href="/admin/produits/supprimer/$id"></a>
			EOL;

      $content[] = [
        $product->getId(),
        $product->getName(),
        $product->getQuantity(),
        $product->getPrice(),
        $product->getCategoryId(),
        $product->getCreatedAt(),
        $product->getUpdatedAt() ?? '-',
        $action,
      ];
    }

    $this->render('admin/readData.twig', [
      'title' => 'Produits',
      'headings' => ['Id', 'Nom', 'Quantité', "Prix", "Id de la catégorie", 'Date de création', 'Date de modification'],
      'datas' => $content,
      'entity' => 'produits',
      'linkText' => 'Ajouter un produit',
    ]);

  }

  public function getAddProduct() {
    $category = Category::find();

    $this->render('admin/addProduct.twig', [
      'title' => "Ajouter un produit",
      'categories' => $category,
    ]);
  }

  public function getEditProduct(int $id) {
    $product = Product::findOne(['id' => $id]);
    $categories = Category::find();

    $data = [
      'name' => $product->getName(),
      'quantity' => $product->getQuantity(),
      'price' => $product->getPrice(),
      'categoryId' => $product->getCategoryId(),
    ];

    $this->render('admin/addProduct.twig', [
      'title' => "Modifier un produit",
      'product' => $product,
      'editMode' => (bool) $product,
      'data' => $data,
      'categories' => $categories,
    ]);
  }

  public function postAddProduct() {
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      $product = new Product();
      $product->setName($_POST['name'])
        ->setQuantity($_POST['quantity'])
        ->setPrice($_POST['price'])
        ->setCategoryId($_POST['categoryId'])
        ->save();

      Router::redirect('/admin/produits');
    }

    $category = Category::find();

    $this->render('admin/addProduct.twig', [
      'title' => "Ajouter un produit",
      'errors' => $errors,
      'data' => $_POST,
      'categories' => $category,
    ]);
  }

  public function postEditProduct(int $id) {
    $errors = Form::validate($_POST);

    if (empty($errors)) {
      $product = new Product();
      $product->setId($id)
        ->setName($_POST['name'])
        ->setQuantity($_POST['quantity'])
        ->setPrice($_POST['price'])
        ->setCategoryId($_POST['categoryId'])
        ->save();

      Router::redirect('/admin/produits');
    }

    $categories = Category::find();

    $this->render('admin/addProduct.twig', [
      'title' => "Modifier un produit",
      'errors' => $errors,
      'data' => $_POST,
      'editMode' => true,
      'categories' => $categories,
    ]);
  }

  public function deleteProduct(int $id) {
    Product::deleteOne($id);
    Router::redirect('/admin/produits');
  }
}