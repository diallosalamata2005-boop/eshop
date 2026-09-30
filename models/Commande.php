<?php
require_once __DIR__.'/Utilisateur.php';
class Commande{
    private int $idcommande;
private float $montant;
private string $adresse_livraison;
private string $statut_com;
private string $mode_paiement;
private float $frais_livraison;
private float $total;
private Utilisateur $utilisateur;
public function __construct(float $montant,
                    string $adresse_livraison,
                    string $statut_com,string $mode_paiement,float $frais_livraison,
                    float $total,Utilisateur $utilisateur,int $idcommande=0){
    $this->setIdcommande($idcommande);
    $this->setMontant($montant);
    $this->setAdresseLivraison($adresse_livraison);
    $this->setStatutCom($statut_com);
    $this->setModepaiement($mode_paiement);
    $this->setFraisLivraison($frais_livraison);
    $this->setTotal($total);
    $this->setUtilisateur($utilisateur);
    
}
public function setIdcommande(int $idcommande){
    $this->idcommande=$idcommande;
}
public function getIdcommande(){
    return $this->idcommande;
}
public function setMontant(float $montant){
    $this->montant=$montant;
}
public function getMontant(){
    return $this->montant;
}
public function setAdresseLivraison(string $adresse_livraison){
    $this->adresse_livraison=$adresse_livraison;
}
public function getAdresseLivraison(){
    return $this->adresse_livraison;
}
public function setStatutCom(string $statut_com){
    $this->statut_com=$statut_com;
}
public function getStatutCom(){
    return $this->statut_com;
}
public function setModepaiement(string $mode_paiement){
    $this->mode_paiement=$mode_paiement;
    
}
public function getModePaiement(){
    return $this->mode_paiement;
}
public function setFraisLivraison(float $frais_livraison){
    $this->frais_livraison=$frais_livraison;
}
public function getFraisLivraison(){
    return $this->frais_livraison;
}
public function setTotal(float $total){
    $this->total=$total;
}
public function getTotal(){
    return $this->total;
}
public function setUtilisateur(Utilisateur $utilisateur){
    $this->utilisateur=$utilisateur;
}
public function getUtilisateur(){
    return $this->utilisateur;
}


public  function passerCommande(){
global $connexion;
try{
$connexion->beginTransaction();

$sql="INSERT INTO commande(montant_com,adresse_livraison,statut_com,mode_paiement,frais_livraison,total,idcli) VALUES (?,?,?,?,?,?,?)";
$stmt=$connexion->prepare($sql);

 $stmt->execute(
[
$this->getMontant(),
$this->getAdresseLivraison(),
$this->getStatutCom(),
$this->getModePaiement(),
$this->getFraisLivraison(),
$this->getTotal(),
$this->getUtilisateur()->getIdU()

]
);
$idcommande=$connexion->lastInsertId();
$sqlDetail = "INSERT INTO commande_produit(quantite, prix_unitaire, idcom, idprod) VALUES (?, ?, ?, ?)";
$stmtDetail = $connexion->prepare($sqlDetail);

foreach (Panier::getContenu() as $idProduit => $quantite) {
    $produit = Produit::recupererParId($idProduit);
    
    if ($produit === null) {
        continue;
    }
    
    $stmtDetail->execute([
        $quantite,
        $produit->getPrix(),
        $idcommande,
        $idProduit
    ]);
}
$connexion->commit();
Panier::vider();
return (int)$idcommande;
}catch(PDOException $e){
    $connexion->rollBack();
    return null;

}



}






}
?>