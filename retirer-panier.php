<?php
require_once __DIR__.'/models/SessionManager.php';
SessionManager::Startsession();
require_once __DIR__.'/models/Panier.php';
$idProduit=(int) $_GET['id'];
Panier::retirer($idProduit);
header("location: panier.php" );
exit();
?>