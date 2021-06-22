<?php

namespace App;

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