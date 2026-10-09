<?php
require_once __DIR__.'/models/SessionManager.php';
require_once __DIR__.'/models/Utilisateur.php';
SessionManager::Startsession();
$utilisateurConnecte = SessionManager::getUser();
if ($utilisateurConnecte === null) {
    header("location:connexion-utilisateur.php");
    exit();
}
require_once __DIR__.'/models/Panier.php';
$idProduit=(int) $_GET['id'];
$idcli=$utilisateurConnecte->getIdU();
Panier::diminuer($idcli,$idProduit);
header("location: panier.php" );
exit();
?>