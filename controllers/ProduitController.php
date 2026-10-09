<?php
require_once __DIR__.'/../models/Utilisateur.php';
require_once __DIR__.'/../models/Produit.php';
require_once __DIR__.'/../models/SessionManager.php';
class ProduitController {
    public function liste(){
    SessionManager::Startsession();
    $succes = null;
    if (isset($_SESSION['succes'])) {
        $succes = $_SESSION['succes'];
        unset($_SESSION['succes']);
    }

    $erreur = null;
    if (isset($_SESSION['erreur'])) {
        $erreur = $_SESSION['erreur'];
        unset($_SESSION['erreur']);
    }

    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $produits = Produit::rechercher($_GET['q']);
    } else {
        $produits = Produit::recupererTous();
    }
    require __DIR__.'/../views/produits/liste.php';
}


public function detail(){
    $id=(int)$_GET['id'];
    $produit=Produit::recupererParId($id);
    require __DIR__.'/../views/produits/detail.php';

}
}
?>
