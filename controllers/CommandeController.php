<?php
require_once __DIR__.'/../models/SessionManager.php';
require_once __DIR__.'/../models/Utilisateur.php';
require_once __DIR__.'/../models/Commande.php';
require_once __DIR__.'/PanierController.php';
class CommandeController{
public function afficherFormulaire(){
    SessionManager::Startsession();
    $utilisateur=SessionManager::getUser();
    if($utilisateur===null){
        header("location:connexion-utilisateur.php");
        exit();
    }
    $erreur = null;
    $succes = null;
    if (isset($_SESSION['erreur'])) {
        $erreur = $_SESSION['erreur'];
        unset($_SESSION['erreur']);
    }
    if (isset($_SESSION['succes'])) {
        $succes = $_SESSION['succes'];
        unset($_SESSION['succes']);
    }
    $totaux = self::calculerTotaux();
$lignesPanier = $totaux['lignesPanier'];
$sousTotal = $totaux['sousTotal'];
$fraisLivraison = $totaux['fraisLivraison'];
$total = $totaux['total'];
    require_once __DIR__.'/../views/commande/passer-commande.php';
}
public static function calculerTotaux():array{
$lignesPanier = PanierController::getLignesPanier();

$sousTotal = 0;
foreach ($lignesPanier as $ligne) {
    $sousTotal += $ligne['produit']->getPrix() * $ligne['quantite'];
}

$fraisLivraison = 2000;
$total = $sousTotal + $fraisLivraison;
return [
        'lignesPanier' => $lignesPanier,
        'sousTotal' => $sousTotal,
        'fraisLivraison' => $fraisLivraison,
        'total' => $total,
    ];
}

public function passer(){
 SessionManager::Startsession();
    $utilisateur=SessionManager::getUser();
    if($utilisateur===null){
        header("location:connexion-utilisateur.php");
        exit();
    }
    $ville=trim($_POST['ville']);
    $quartier=trim($_POST['quartier']);
    $rue=trim($_POST['rue']);
    $modePaiement=trim($_POST['mode_paiement']);
    if(empty($ville)||empty($quartier) || empty($rue) || empty($modePaiement)){
        $_SESSION['erreur']="Veuillez remplir les champs";
        header("location:validation-commande.php");
        exit();
    }else{
    $adresseComplete=$ville.', '.$quartier.', '.$rue;
    $totaux = self::calculerTotaux();
$lignesPanier = $totaux['lignesPanier'];
$sousTotal = $totaux['sousTotal'];
$fraisLivraison = $totaux['fraisLivraison'];
$total = $totaux['total'];
$commande = new Commande(
    $sousTotal,
    $adresseComplete,
    "en attente",
    $modePaiement,
    $fraisLivraison,
    $total,
    $utilisateur
);

$idCommande = $commande->passerCommande();

if ($idCommande !== null) {
    $_SESSION['succes'] = "Commande passée avec succès !";
    header("location:index.php");
    exit();
} else {
    $_SESSION['erreur'] = "Une erreur est survenue, veuillez réessayer.";
    header("location:validation-commande.php");
    exit();
}

}


}
}






?>