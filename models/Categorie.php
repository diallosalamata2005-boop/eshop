<?php
class Categorie{
private int $id_cat;
private string $nomcat;

public function __construct(int $id_cat,string $nomcat)
{
    $this->setIdcat($id_cat);
    $this->setNomcat($nomcat);
}


public function setIdcat(int $id_cat){
    $this->id_cat=$id_cat;
}
public function getIdcat(){
    return $this->id_cat;
}
public function setNomcat(string $nomcat){
    $this->nomcat=$nomcat;
}
public function getNomcat(){
    return $this->nomcat;
}
public static function recupererToutes():array{
    $categories=[];
    global $connexion;
    $sql="SELECT * FROM categorie";
    $stmt=$connexion->prepare($sql);
    $stmt->execute();
    $lignes=$stmt->fetchAll();
    foreach ($lignes as  $ligne) {
        $cat=new Categorie($ligne['idcat'],$ligne['nomcat']);
        $categories []=$cat;
    }
    return $categories;
     

}
public static function creer(string $nomcat): bool {
    global $connexion;

    
    $sql = "INSERT INTO categorie(nomcat) VALUES (?)";
    $stmt = $connexion->prepare($sql);
    $reussite = $stmt->execute([$nomcat]);

    return $reussite;
}
public static function recupererParId(int $idcat):?Categorie{
global $connexion;
$sql="SELECT * FROM categorie c  WHERE c.idcat=?";
$stmt=$connexion->prepare($sql);
$stmt->execute([$idcat]);
$ligne=$stmt->fetch();
if($ligne){
return new Categorie($ligne['idcat'],$ligne['nomcat']); 

}
return null;
}
public static function supprimer(int $idcat): bool {
    global $connexion;

    // Supprimer la categorie en base
    $stmt = $connexion->prepare("DELETE FROM categorie WHERE idcat = ?");
    $reussite = $stmt->execute([$idcat]);

    return $reussite;
}
public static function modifier(int $idcat, string $nomcat): bool {
    global $connexion;
        $sql = "UPDATE categorie SET nomcat = ? WHERE idcat = ?";
        $params = [$nomcat,$idcat];
    $stmt = $connexion->prepare($sql);
    $reussite = $stmt->execute($params);

    
    

    return $reussite;
}
}