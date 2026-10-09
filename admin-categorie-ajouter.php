<?php
require_once __DIR__ . '/controllers/AdminController.php';

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->ajouterCategorie();
} else {
    header("Location: admin-categorie.php");
    exit;
}