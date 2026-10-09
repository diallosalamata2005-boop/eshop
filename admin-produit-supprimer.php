<?php
require __DIR__ . '/controllers/AdminController.php';

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->supprimerProduit();
} else {
    header("location:admin-produit.php");
    exit();
}