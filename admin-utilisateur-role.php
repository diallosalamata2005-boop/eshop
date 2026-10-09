<?php
require __DIR__ . '/controllers/AdminController.php';

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->changerRoleUtilisateur();
} else {
    header("location:admin-utilisateur.php");
    exit();
}