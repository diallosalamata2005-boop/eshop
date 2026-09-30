<?php
require_once __DIR__.'/../models/Panier.php';
require_once __DIR__.'/../models/Produit.php';
require_once __DIR__.'/../models/SessionManager.php';
require_once __DIR__.'/../models/Utilisateur.php';
class PanierController{
    public static function getLignesPanier():array {
        SessionManager::Startsession();
    $contenuPanier=Panier::getContenu();// ne contient que la clé=>id et la valeur=>qte
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
    $lignesPanier=self::getLignesPanier();
    
    require_once __DIR__.'/../views/paniers/afficher.php';
}
}
?>