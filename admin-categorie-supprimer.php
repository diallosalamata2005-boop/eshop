<?php
require __DIR__ . '/controllers/AdminController.php';

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->supprimerCategorie();
} else {
    header("location:admin-categorie.php");
    exit();
}