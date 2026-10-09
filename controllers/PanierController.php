<?php
require_once __DIR__.'/../models/Panier.php';
require_once __DIR__.'/../models/Produit.php';
require_once __DIR__.'/../models/SessionManager.php';
require_once __DIR__.'/../models/Utilisateur.php';
class PanierController{
    public static function getLignesPanier():array {
        SessionManager::Startsession();
         $utilisateur=SessionManager::getUser();
    if($utilisateur===null){
        header("location:connexion-utilisateur.php");
        exit();
    }
    $id=$utilisateur->getIdU();
    $contenuPanier=Panier::getContenu($id);// ne contient que la clé=>id et la valeur=>qte
    $lignesPanier=[];// permet de stocker les information enrichie supp (le nom , prix,etc...)
    foreach ($contenuPanier as $idProduit => $quantite) {
        $produit=Produit::recupererParId($idProduit);
     if ($produit!==null){
        $lignesPanier[]=[
            'produit'=>$produit,
            'quantite'=>$quantite,

        ];
   
     }
 }
 return $lignesPanier;



    }
public function afficher(){
    $lignesPanier = self::getLignesPanier();

    $succes = $_SESSION['succes'] ?? null;
    $erreur = $_SESSION['erreur'] ?? null;
    unset($_SESSION['succes'], $_SESSION['erreur']);

    require_once __DIR__.'/../views/paniers/afficher.php';
}
}
?>