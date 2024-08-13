<?php

// Définition de la classe CartController pour gérer le panier d'achats
class CartController
{
    // Constructeur de la classe
    public function __construct()
    {
        // Initialisation du panier dans la session si ce n'est pas déjà fait
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Méthode pour ajouter un produit au panier
    public function addToCart($productId, $productName, $productPrice, $quantity = 1)
    {
        $found = false; // Variable pour vérifier si le produit existe déjà dans le panier
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $productId) {
                $item['quantity'] += $quantity; // Incrémente la quantité si le produit existe déjà
                $found = true;
                break;
            }
        }
        if (!$found) {
            // Ajoute un nouveau produit au panier si ce n'est pas déjà présent
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $quantity
            ];
        }
    }

    // Méthode pour retirer un produit du panier
    public function removeFromCart($productId)
    {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] === $productId) {
                unset($_SESSION['cart'][$index]); // Supprime le produit du panier
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Réindexe le tableau après suppression
                break;
            }
        }
    }

    // Méthode pour vider le panier
    public function emptyCart()
    {
        $_SESSION['cart'] = []; // Réinitialise le panier
    }

    // Méthode pour obtenir les articles du panier
    public function getCartItems()
    {
        return $_SESSION['cart']; // Retourne les articles du panier
    }

    // Méthode pour calculer le total du panier
    public function getCartTotal()
    {
        $total = 0; // Initialisation du total à 0
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity']; // Calcule le total en multipliant le prix par la quantité de chaque article
        }
        return $total; // Retourne le total du panier
    }
}
