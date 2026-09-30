<?php
require_once __DIR__.'/models/SessionManager.php';
SessionManager::Startsession();
$utilisateurConnecte=SessionManager::getUser();
if($utilisateurConnecte===null){
    header("location:inscription-utilisateur.php");
    exit();
}
require_once __DIR__.'/models/Panier.php';
$idProduit=(int) $_GET['id'];
Panier::ajouterPanier($idProduit);
$retour = $_GET['retour'] ?? 'index';
if($retour === 'panier'){
header("location: panier.php" );
}else{
header("location: index.php" );
}
exit();
?>