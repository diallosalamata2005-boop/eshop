<?php
require_once __DIR__.'/controllers/ProduitController.php';
require_once __DIR__.'/models/Panier.php';
$prod=new ProduitController();
    $prod->liste();

?>