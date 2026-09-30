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
    
    $produits = Produit::recupererTous();
    require __DIR__.'/../views/produits/liste.php';
}


public function detail(){
    $id=(int)$_GET['id'];
    $produit=Produit::recupererParId($id);
    require __DIR__.'/../views/produits/detail.php';

}
}
?>
