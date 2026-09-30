<?php
$host='localhost';// adresse du serveur 
$dbname='nom_de_ta_base';// nom de la base de donnée
$user='root';// l'utilisateur MySQL (root par défaut avec Laragon)
$password='';//mdp (vide avec laragon)
try{
$dsn=("mysql:host=$host;dbname=$dbname;charset=utf8mb4");// data source name(DSN) C'est l'adresse complète de ta base de données. Comme une adresse postale pour PHP.
//mysql: → on utilise MySQL
//host=$host → où se trouve le serveur
//dbname=$dbname → quelle base de données
//charset=utf8mb4 → on accepte tous les caractères (accents, emojis...)
$options=[
PDO::ATTR_ERRMODE    =>  PDO::ERRMODE_EXCEPTION ,// affiche les erreurs SQL
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// retourne les données en tableau associatif
]; 

$connexion=new PDO($dsn,$user,$password,$options);
// C'est ici que PHP se connecte vraiment à MySQL avec toutes les infos.
}catch(PDOException $e){
    die("erreur de connection" .$e->getMessage());
}
// le try catch C'est comme dire : "Essaie, et si ça rate, dis-moi pourquoi"
















?>