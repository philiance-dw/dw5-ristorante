# Implémenter le CRUD sur Dish

R: read

- créer un lien dans le menu qui mène à la page en question (layout/admin.twig)
- créer le template (.twig) de la page en question (admin/dishes.twig)
- créer la route qui y mène (route(index.php) + controller(src/Controllers/DishController) + méthode(getDishes))

C: create

- dans le template, le bouton ajouter un plat doit envoyer vers une route pour ajouter un plat
- le template doit contenir des input pour renseigner les valeurs à inserer en BDD
- créer 2 routes
  - une en GET pour afficher la page d'ajout
  - une en POST pour traiter le formulaire

D: delete

- dans le template faire pointer le lien vers la route appropriée
- créer une route qui permet de supprimer un plat (dish)

U: update

- créer une route dynamique qui attend un paramètre 'id'
- renvoyer la même vue que pour l'ajout mais en pré-remplissant les champs avec les données d'un plat en particulier
