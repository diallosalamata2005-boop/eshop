<?php
require __DIR__.'/controllers/CommandeController.php';
$controller=new CommandeController();
if(isset($_POST['submit'])){
    $controller->passer();
}else{
$controller->afficherFormulaire();
}
?>