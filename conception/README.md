# Ristorante

Site de restaurant qui liste les plats du restaurant et permet la commande en ligne.

## Stack (technos)

- HTML
- CSS/SCSS
- JavaScript (ajax / jQuery..?)
- PHP
- MySQL

---

## Besoins du site

- espace connexion
- espace utilisateur
- panier (gestion)
- historique de commandes
- possibilité de laisser des commentaires
- section admin
- liste de favoris
- moyen de paiement
- moyen(s) de contact
- stockage produits en bdd

---

## User Stories

| en tant que | je veux                                           | afin de                                   |
| ----------- | ------------------------------------------------- | ----------------------------------------- |
| visiteur    | pouvoir acceder à la page d'accueil               | visiter le site                           |
| visiteur    | pouvoir voir la liste des produits                | savoir si je veux commander               |
| visiteur    | pouvoir m'inscrire                                | avoir accès à plus de fonctionnalités     |
| visiteur    | pouvoir avoir accès à la page de connexion        | me connecter                              |
| visiteur    | pouvoir avoir un panier                           | passer commande                           |
| visiteur    | pouvoir choisir mon moyen de paiement             | choisir le moyen qui me correspond        |
| visiteur    | pouvoir contacter le restaurant                   | obtenir des infos                         |
| visiteur    | pouvoir voir les commentaires                     | afin de me faire une idée                 |
| visiteur    | pouvoir partager le menu                          | promouvoir le site (pub)                  |
| visiteur    | pouvoir avoir accès à la liste des partenaires    | me rassurer                               |
| visiteur    | pouvoir être géolocaliser                         | trouver le restaurant le plus proche      |
| visiteur    | pouvoir géolocaliser un restaurant en particulier | pour avoir plus d'infos sur ce restaurant |
| visiteur    | pouvoir visiter le restaurant en 3d               | voir l'interieur                          |

---

| en tant que | je veux                                          | afin de                                  |
| ----------- | ------------------------------------------------ | ---------------------------------------- |
| client      | pouvoir laisser des commentaires                 | donner mon avis                          |
| client      | pouvoir laisser une note globale                 | noter les prestations                    |
| client      | pouvoir reserver une table                       | d'avoir de la place quand je le veux     |
| client      | pouvoir annuler une commande                     |                                          |
| client      | pouvoir lister l'historique de mes commandes     | de voir les commandes passées            |
| client      | pouvoir voir si le restaurant propose des postes | de postuler pour y travailler            |
| client      | pouvoir signer numériquement                     |                                          |
| client      | pouvoir avoir accès à un espace personnel        | gerer mon compte (editer, supprimer ...) |

---

| en tant que | je veux                         | afin de                     |
| ----------- | ------------------------------- | --------------------------- |
| admin       | avoir un espace perso           | afin d'administrer le site  |
| admin       | voir les commandes passées      | gerer les commandes         |
| admin       | voir les commandes du jour      | administrer                 |
| admin       | voir les plats proposés         | pouvoir ajouter des plats   |
| admin       | voir les plats proposés         | pouvoir supprimer des plats |
| admin       | voir les plats proposés         | pouvoir modifier des plats  |
| admin       | voir les produits du restaurant | pouvoir gerer les stocks    |
| admin       | voir les commentaires           | pouvoir modérer             |
| admin       | proposer des promotions         | fidéliser le client         |
| admin       | avoir des produits dérivés      | faire de la moula           |

## Minimum Viable Product

- inscription / suppression de compte / connexion / déconnexion
- passage de commandes (panier + paiement)
- espace perso / gestion produits/panier/commandes

## BDD

### Entités

- users
- products
- dishes
- categories
- orders
- payments
- reviews
- (jobs)
- (bookings)
- (discounts / codes promo)
- (goodies)

### MCD

payments: amount
have, 0N users, 11 payments
leave, 0N users, 11 reviews
reviews: content, note

categories: name
own, 0N users, 11 orders
users: first_name, last_name, phone, address, city, country, postal_code, email, password, is_admin
cart, 0N users, 0N dishes

like, 0N dishes, 11 reviews
categorize, 11 products, 0N categories
orders: status, method
order_details, 0N dishes, 1N orders

dishes: name, size, description, price
ingredients, 1N products, 1N dishes
products: name, quantity, price
belongs_to, 11 dishes, 0N categories

> Relations

- un `users` peut laisser au minimum 0 et au maximum N `reviews` - un `reviews` peut appartenir au minimum à 1 et au maximum à 1 `users`

  - 0N `users` <-> 11 `reviews`

- un `users` peut avoir au minimum 0 et au maximum N `payments` - un `payments` peut appartenir au minimum à 1 et au maximum à 1 `users`

  - 0N `users` <-> 11 `payments`

- un `users` peut avoir au minimum 0 et au maximum N `orders` - un `orders` peut appartenir au minimum 1 et au maximum 1 `users`

  - 0N `users` <-> 11 `orders`

- un `users` peut avoir au minimum 0 et au maximum N `dishes` - un `dishes` peut appartenir au minimum à 0 et au maximum N `users`

  - 0N `users` <-> 0N `dishes`

- un `products` peut avoir au minimum 1 et au maximum 1 `categories` - un `categories` peut avoir au minimum 0 et au maximum N `products`

  - 11 `products` - 0N `categories`

- un `products` peut avoir au minimum 1 et au maximum N `dishes` - un `dishes` peut avoir au minimum 1 et au maximum N `products`

  - 1N `products` - 1N `dishes`

- un `dishes` peut être présent dans au minimum 0 et au maximum N `orders` - un `orders` peut avoir au minimum 1 et au maximum N `dishes`

  - 0N `dishes` <-> 1N `orders`

- un `dishes` peut avoir au minimum 0 et au maximum N `reviews` - un `reviews` peut avoir au minimum 1 et au maximum 1 `dishes`

  - 0N `dishes` <-> 11 `reviews`

- un `dishes` peut avoir au minimum 1 et au maximum 1 `categories` - un `categories` peut avoir au minimum 0 et au maximum N `dishes`
  - 11 `dishes` <-> 0N `categories`

### MLD

users: id(pk), first_name, last_name, phone, address, city, country, postal_code, email, password, is_admin, created_at, updated_at

products: id(pk), name, quantity, price, category_id(fk), created_at, updated_at

dishes: id(pk), name, size, description, price, created_at, updated_at

categories: id(pk), name, created_at, updated_at

orders: id(pk), status, method, user_id(fk), created_at, updated_at

payments: id(pk), amount, user_id(fk), created_at, updated_at

reviews: id(pk), content, note, user_id(fk), dish_id(fk), created_at, updated_at

cart: user_id(pk), dish_id(pk), created_at, updated_at

ingredients: product_id(pk), dish_id(pk), created_at, updated_at

order_details: dish_id(pk), order_id(pk), created_at, updated_at

---

> mocodo

have, 0N users, 11 payments
users: id, first_name, last_name, phone, address, city, country, postal_code, email, password, is_admin, created_at, updated_at
own, 0N users, 11 orders
orders: id, status, method, user_id, created_at, updated_at

payments: id, amount, user_id, created_at, updated_at
leave, 0N users, 11 reviews
cart, 0N users, 0N dishes: user_id, dish_id, created_at, updated_at
order_details, 0N dishes, 1N orders: dish_id, order_id, created_at, updated_at

belongs_to, 11 dishes, 0N categories
reviews: id, content, note, user_id, dish_id, created_at, updated_at
like, 0N dishes, 11 reviews
dishes: id, name, size, description, price, category_id, created_at, updated_at

categories: id, name, created_at, updated_at
categorize, 11 products, 0N categories
products: id, name, quantity, price, category_id, created_at, updated_at
ingredients, 1N products, 1N dishes: product_id, dish_id, created_at, updated_at
