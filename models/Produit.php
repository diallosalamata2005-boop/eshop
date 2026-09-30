<?php
require_once __DIR__.'/../Database/db_connect.php';
require_once 'Categorie.php';
class Produit{
private int $id;
private string $nom;
private string $description;
private string $image;
private float $prix;
private int $stock;
private Categorie $categorie;
public function __construct(int $id,string $nom, string $description,string $image, float $prix,int $stock,Categorie $categorie)
{
    $this->setId($id);
    $this->setNom($nom);
    $this->setDescription($description);
    $this->setImage($image);
    $this->setPrix($prix);
    $this->setStock($stock);
    $this->setCategorie($categorie);
  
}
public function setNom(string $nom){
    $this->nom=$nom;
}
public function getNom(){
    return $this->nom;
}
public function setDescription(string $description){
    $this->description=$description;
}
public function getDescription(){
    return $this->description;
}
public function setImage(string $image){
    $this->image=$image;
}
public function getImage(){
    return $this->image;
}
public function setPrix(float $prix){
    $this->prix=$prix;
}
public function getPrix(){
    return $this->prix;
}
public function setStock(int $stock){
    $this->stock=$stock;
}
public function getStock(){
    return $this->stock;
}
public function setId(int $id){
    $this->id=$id;
}
public function getId(){
    return $this->id;
}

public function setCategorie(Categorie $categorie){
    $this->categorie=$categorie;
}
public function getCategorie(){
    return $this->categorie;
}

public static function recupererTous(){
global $connexion;
$produits=[];
$lignes=$connexion->query("SELECT * FROM produits p 
INNER JOIN categorie c on c.idcat=p.id_cat;
")->fetchAll(); 
foreach ($lignes as  $ligne) {
    $categorie=new Categorie($ligne['idcat'],$ligne['nomcat']); 
    $produit=new Produit($ligne['id'],$ligne['nom'],$ligne['description'],$ligne['image'],$ligne['prix'],$ligne['stock'],$categorie);
    $produits[]=$produit;
}
return $produits;

}
public static function recupererParId(int $id):?Produit{
global $connexion;
$sql="SELECT * FROM produits p INNER JOIN categorie c on c.idcat=p.id_cat WHERE p.id=?";
$stmt=$connexion->prepare($sql);
$stmt->execute([$id]);
$ligne=$stmt->fetch();
if($ligne){
$categorie=new Categorie($ligne['idcat'],$ligne['nomcat']); 
    return new Produit($ligne['id'],$ligne['nom'],$ligne['description'],$ligne['image'],$ligne['prix'],$ligne['stock'],$categorie);

}
return null;
}
}