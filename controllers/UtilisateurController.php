<?php
require_once __DIR__.'/../models/Utilisateur.php';
require_once __DIR__.'/../models/SessionManager.php';
 class UtilisateurController{
public function inscription(){
    SessionManager::Startsession();
     $erreur=null;
     $succes=false;
if (isset($_POST['submit'])){
$prenom=trim($_POST['prenom']);
$nom=trim($_POST['nom']);
$email=trim($_POST['email']);
$mdp=trim($_POST['mdp']);
$verifmdp=trim($_POST['verifmdp']);
    if(empty($prenom)||empty($nom) || empty($email) || empty($mdp)||empty($verifmdp)){
        $erreur="Veuillez remplir les champs";
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $erreur="Adresse email invalide";
    } else if($mdp!==$verifmdp){
    $erreur=" les mots de passe ne correspondent pas";
}else{
$succes=Utilisateur::inscrire($prenom,$nom,$email,$mdp);
if(!$succes){
    $erreur="erreur lors de l'inscription";
}
}
if($erreur!==null){
    $_SESSION['erreur']=$erreur;
}else if($succes){
    $_SESSION['succes']="Inscription réussie !";
}
header("location:inscription-utilisateur.php");
exit();

}
$erreur=$_SESSION['erreur'] ?? null;
unset($_SESSION['erreur']);
$succes=$_SESSION['succes'] ?? null;
unset($_SESSION['succes']);
require __DIR__."/../views/utilisateurs/inscription.php";
}
public function connexion(){

SessionManager::Startsession();
     $erreur=null;
     $succes=false;
if (isset($_POST['submit'])){
$email=trim($_POST['email']);
$mdp=trim($_POST['mdp']);
    if(empty($email) || empty($mdp)){
        $erreur="Veuillez remplir les champs";
    }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $erreur="Adresse email invalide";
    }else{
$utilisateur=Utilisateur::connecter($email,$mdp);
if($utilisateur===null){
    $erreur="Email ou mot de passe incorrect";
}else{
SessionManager::setUser($utilisateur);
$succes=true;
}
if($erreur!==null){
    $_SESSION['erreur']=$erreur;
    header("location:connexion-utilisateur.php");
}else if($succes){
    $_SESSION['succes']="connexion réussie !";
header("location:index.php");

}
exit();
    }
}
$erreur=$_SESSION['erreur'] ?? null;
unset($_SESSION['erreur']);
$succes=$_SESSION['succes'] ?? null;
unset($_SESSION['succes']);
require __DIR__."/../views/utilisateurs/connection.php";



}

public function deconnection(){
    SessionManager::Startsession();
    SessionManager::sessionDestroy();
    header("location:index.php");
    exit();
}
 

}



 














?>