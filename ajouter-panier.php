<?php
require_once __DIR__.'/models/SessionManager.php';
require_once __DIR__.'/models/Utilisateur.php';
require_once __DIR__.'/models/Produit.php';
SessionManager::Startsession();
$utilisateurConnecte=SessionManager::getUser();
if($utilisateurConnecte===null){
    header("location:connexion-utilisateur.php");
    exit();
}

require_once __DIR__.'/models/Panier.php';
$idProduit=(int) $_GET['id'];
$idcli = $utilisateurConnecte->getIdU();
$retour = $_GET['retour'] ?? 'index';

if (!Produit::estDisponible($idProduit)) {
    $_SESSION['erreur'] = "Ce produit n'est plus disponible.";
    header("Location: index.php");
    exit;
}
Panier::ajouterPanier($idcli,$idProduit);
if($retour === 'panier'){
header("location: panier.php" );
}else{
header("location: index.php" );
}
exit();
?>