<?php

namespace App;

use Ramsey\Uuid\Uuid;

class Form {
  private $fields = [];

  /**
   *
   * Cette méthode permet de valider le formulaire en vérifiant si des champs sont vides, que l'email est bien un email, etc...
   *
   * @param array $post tableau contenant les données du formulaire
   * @param bool $isLoggingIn paramètre permettant de savoir s'il s'agit d'un formulaire de connexion
   *
   * @return array Un tableau contenant les potentielles erreurs du formulaire
   *
   */
  public static function validate(array $post, bool $isLoggingIn = false): array{
// ce tableau servira a stocker nos potentielles erreurs
    $errors = [];

    if (!$isLoggingIn) {
      $password = $post['password'] ?? null;
      $confirmPassword = $post['confirmPassword'] ?? null;

      if ($password !== $confirmPassword) {
        $errors['passwordMatch'] = "Les mots de passe ne concordent pas";
      }
    }

    // on boucle sur le tableau pour vérifier toutes les entrées
    foreach ($post as $key => $value) {
      // si pas de valeur on crée une entrée dans le tableau $errors qui aura pour clé, la valeur courante de $key
      if (!$value) {
        $errors[$key] = 'Ce champs ne peut pas être vide.';
      } else {
        // si l'utilisateur n'est pas sur un formulaire de connexion
        if (!$isLoggingIn) {
          // on vérifie que l'email et le mot de passe correspondent à certains critères
          // s'ils ne correspondent pas on viendra créer dans le tableau $errors une nouvelle clé avec une valeur associée en indiquant le problème
          if ($key === 'email') {
            // preg_match permet de vérifier la cooncordance entre une regexp et une valeur
            if (!preg_match("/^\S+@\S+\.\S+/", $value)) {
              $errors['email'] = "Cet email n'est pas un email valide.";
            }

          } elseif ($key === 'password') {
            if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-\/+_]).{8,}$/", $value)) {
              $errors['password'] = "Votre mot de passe est trop faible.";
            }

          } elseif ($key === 'postalCode') {
            if (!preg_match('/^[0-9]{5}$/', $value)) {
              $errors['postalCode'] = 'Ce code postal n\'est pas valide.';
            }

          }
        }
      }
    }

    return $errors;
  }

/**
 *
 * Cette méthode permet d'envoyer un fichier au serveur et de le stocker
 *
 * @param string $uploadDir Le chemin absolu du dossier de destination du fichier en partant de la racine du serveur
 * @param array &$errors Le tableau d'erreur à modifier en cas d'erreur fichier
 * @param array $options Un tableau d'options avec la clé allowedTypes contenant un tableau correspondant aux fichiers acceptés
 *
 * @return string Le chemin d'ajout du fichier à stocker en base de donnée
 *
 */
  public static function uploadFile(string $uploadDir, array &$errors = [], array $options = []) {
    $allowedTypes = $options['allowedTypes'] ?? null;

    $image = $_FILES['image'] ?? null;

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
      ['extension' ?? null => $extension, 'filename' ?? null => $filename] = pathinfo($image['name']);

      if ($allowedTypes && !in_array($extension, $allowedTypes)) {
        $errors['fileError'] = "Type de fichier non accepté.";
      }

      if (empty($errors) && $filename) {
        $filename = Uuid::uuid4();
        $filename .= ".$extension";

        $uploadFile = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], dirname(__DIR__) . $uploadFile)) {
          $errors['fileError'] = "Problème durant l'ajout du fichier.";
        }
      }
    }

    return $uploadFile ?? null;
  }

  public function addField($params) {
    $field = <<<EOL
		<input />
		EOL;
    // code pour ajouter un champ...

    $this->fields[] = $field;
    return $this;
  }
}

// $form = new Form();

// $form->addField('...')->addField('...');
