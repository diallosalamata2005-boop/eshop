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



}