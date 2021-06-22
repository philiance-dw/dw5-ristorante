<?php

namespace App\Controllers;

use App\Form;
use App\Models\Category;
use App\Models\Product;
use App\Router;

class ProductController extends Controller {
  public function getProducts() {
    $products = Product::find();

    $this->render('admin/products.twig', [
      'title' => 'Products',
      'products' => $products,
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

    dd($_POST, $_FILES);

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