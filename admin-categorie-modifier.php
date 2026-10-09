<?php
require_once __DIR__ . '/controllers/AdminController.php';

$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->modifierCategorie();
} else {
    $controller->afficherFormulaireModificationCategorie();
}