<?php
require_once __DIR__.'/Utilisateur.php';
class Commande{
public const STATUTS = ['en attente', 'payée', 'expédiée', 'livrée', 'annulée'];
private int $idcommande;
private float $montant;
private string $adresse_livraison;
private string $statut_com;
private string $mode_paiement;
private float $frais_livraison;
private float $total;
private Utilisateur $utilisateur;
private string $date_com;
public function __construct(float $montant,
                    string $adresse_livraison,
                    string $statut_com,string $mode_paiement,float $frais_livraison,
                    float $total,Utilisateur $utilisateur,int $idcommande=0,string $date_com=""){
    $this->setIdcommande($idcommande);
    $this->setMontant($montant);
    $this->setAdresseLivraison($adresse_livraison);
    $this->setStatutCom($statut_com);
    $this->setModepaiement($mode_paiement);
    $this->setFraisLivraison($frais_livraison);
    $this->setTotal($total);
    $this->setUtilisateur($utilisateur);
    $this->setDatecom($date_com);
    
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
public function setDatecom(string $date_com){
    $this->date_com=$date_com;
    
}
public function getDatecom(){
    return $this->date_com;
}



public function passerCommande(){
    global $connexion;
    $lignes = PanierController::getLignesPanier();
    if (empty($lignes)) {
        $_SESSION['erreur'] = "Votre panier est vide.";
        header('Location: panier.php');
        exit;
    }
    try {
        $connexion->beginTransaction();

        $sql = "INSERT INTO commande(montant_com,adresse_livraison,statut_com,mode_paiement,frais_livraison,total,idcli) VALUES (?,?,?,?,?,?,?)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            $this->getMontant(),
            $this->getAdresseLivraison(),
            $this->getStatutCom(),
            $this->getModePaiement(),
            $this->getFraisLivraison(),
            $this->getTotal(),
            $this->getUtilisateur()->getIdU()
        ]);
        $idcommande = $connexion->lastInsertId();

        $sqlDetail = "INSERT INTO commande_produit(quantite, prix_unitaire, idcom, idprod) VALUES (?, ?, ?, ?)";
        $stmtDetail = $connexion->prepare($sqlDetail);

        // NOUVEAU : diminue le stock seulement s'il est suffisant
        $sqlStock = "UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ? AND actif=1";
        $stmtStock = $connexion->prepare($sqlStock);

        foreach (Panier::getContenu($this->getUtilisateur()->getIdU()) as $idProduit => $quantite) {
            $produit = Produit::recupererParId($idProduit);
            if ($produit === null) {
                continue;
            }

            // NOUVEAU
            $stmtStock->execute([$quantite, $idProduit, $quantite]);
            if ($stmtStock->rowCount() === 0) {
                throw new Exception(throw new Exception("« " . $produit->getNom() . " » n'est plus disponible ou son stock est insuffisant."));
            }

            $stmtDetail->execute([
                $quantite,
                $produit->getPrix(),
                $idcommande,
                $idProduit
            ]);
        }

        $connexion->commit();
        Panier::vider($this->getUtilisateur()->getIdU());
        return (int)$idcommande;

    } catch (PDOException $e) {
        $connexion->rollBack();
        return null;
    } catch (Exception $e) {   // NOUVEAU : stock insuffisant
        $connexion->rollBack();
        $_SESSION['erreur'] = $e->getMessage();
        return null;
    }
}
public static function recupererParUtilisateur(int $idUtilisateur): array {
    global $connexion;
    
    $sql = "SELECT * FROM commande WHERE idcli = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idUtilisateur]);
    $lignes = $stmt->fetchAll();
    $commandes=[];
    foreach($lignes as $ligne){
        $utilisateur=Utilisateur::recupererParId($ligne['idcli']);
        $commande=new Commande($ligne['montant_com'],$ligne['adresse_livraison'],$ligne['statut_com'],$ligne['mode_paiement'],$ligne['frais_livraison'],$ligne['total'],$utilisateur,$ligne['idCom'],$ligne['date_com']);
        $commandes []=$commande;
    }
    return $commandes;
    
}
public static function getLignes(int $idCom): array {
    global $connexion;
    
    $sql = "SELECT * FROM commande_produit WHERE idcom = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idCom]);
    $lignes = $stmt->fetchAll();
    
    $lignesDetaillees = [];
    foreach ($lignes as $ligne) {
        $produit = Produit::recupererParId($ligne['idprod']);
        if ($produit === null) {
            continue;
        }
        
        $lignesDetaillees[] = [
            'produit' => $produit,
            'quantite' => $ligne['quantite'],
            'prix_unitaire' => $ligne['prix_unitaire'],
        ];
    }
    return $lignesDetaillees;
}

public static function recupererTous():array{
global $connexion;
$commandes=[];
$lignes=$connexion->query("SELECT * FROM commande ORDER BY date_com DESC")->fetchAll(); 
foreach ($lignes as  $ligne) {
    $utilisateur=Utilisateur::recupererParId($ligne['idcli']);
    if($utilisateur==null){
        continue;
    }
        $commande=new Commande($ligne['montant_com'],$ligne['adresse_livraison'],$ligne['statut_com'],$ligne['mode_paiement'],$ligne['frais_livraison'],$ligne['total'],$utilisateur,$ligne['idCom'],$ligne['date_com']);
    $commandes[]=$commande;
}
return $commandes;

}
public static function changerStatut(int $idCom, string $statut): bool {
    global $connexion;

    try {
        $connexion->beginTransaction();

        // 1. Lire le statut actuel et verrouiller la ligne
        $stmt = $connexion->prepare("SELECT statut_com FROM commande WHERE idCom = ? FOR UPDATE");
        $stmt->execute([$idCom]);
        $ligne = $stmt->fetch();

        // 2. Commande introuvable ou déjà annulée : on refuse
        if (!$ligne || $ligne['statut_com'] === 'annulée') {
            $connexion->rollBack();
            return false;
        }

        // 3. Changer le statut
        $stmt = $connexion->prepare("UPDATE commande SET statut_com = ? WHERE idCom = ?");
        $stmt->execute([$statut, $idCom]);

        // 4. Si c'est une annulation, remettre le stock
        if ($statut === 'annulée') {
            $stmt = $connexion->prepare("SELECT idprod, quantite FROM commande_produit WHERE idcom = ?");
            $stmt->execute([$idCom]);
            $lignes = $stmt->fetchAll();

            $stmtStock = $connexion->prepare("UPDATE produits SET stock = stock + ? WHERE id = ?");
            foreach ($lignes as $l) {
                $stmtStock->execute([$l['quantite'], $l['idprod']]);
            }
        }

        $connexion->commit();
        return true;

    } catch (PDOException $e) {
        if ($connexion->inTransaction()) {
            $connexion->rollBack();
        }
        return false;
    }
}







}
?>