<?php
class Panier{
public static function initialiser(){
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier']=[];
    }

}
public static function ajouterPanier(int $idProduit ,int $quantite=1){
self::initialiser();
if(isset($_SESSION['panier'][$idProduit])){
    $_SESSION['panier'][$idProduit]+=$quantite;
}else{
    $_SESSION['panier'][$idProduit]=$quantite;
}

}
public static function getContenu():array{
    self::initialiser();
    return $_SESSION['panier'];
}
public static function retirer(int $idProduit){
    self::initialiser();
    unset($_SESSION['panier'][$idProduit]);
}
public static function getNombreArticle():int{
self::initialiser();
return array_sum($_SESSION['panier']);

}
public static function vider(){
    self::initialiser();
    $_SESSION['panier']=[];
}
public static function diminuer(int $idProduit){
    self::initialiser();
    if(isset($_SESSION['panier'][$idProduit])){
        if($_SESSION['panier'][$idProduit]>1){
         $_SESSION['panier'][$idProduit]-=1;
        }else{
        self::retirer($idProduit);
    }
}
}







}
?>