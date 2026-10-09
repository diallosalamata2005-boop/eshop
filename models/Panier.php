<?php
class Panier{
public static function ajouterPanier(int $idcli, int $idProduit, int $qte = 1) {
    global $connexion;
    
    // Étape 1 : vérifier si la ligne existe déjà
    $sql = "SELECT * FROM panier WHERE idcli = ? AND idProduit = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idcli, $idProduit]);
    $ligne = $stmt->fetch();
    
    if ($ligne) {
        // Elle existe déjà : on AUGMENTE la quantité
        $nouvelleQte = $ligne['quantite'] + $qte;
        $sqlUpdate = "UPDATE panier SET quantite = ? WHERE idcli = ? AND idProduit = ?";
        $stmtUpdate = $connexion->prepare($sqlUpdate);
        $stmtUpdate->execute([$nouvelleQte, $idcli, $idProduit]);
    } else {
        // Elle n'existe pas : on l'INSÈRE
        $sqlInsert = "INSERT INTO panier(idcli, idProduit, quantite) VALUES (?, ?, ?)";
        $stmtInsert = $connexion->prepare($sqlInsert);
        $stmtInsert->execute([$idcli, $idProduit, $qte]);
    }
}
public static function getContenu(int $idcli): array {
    global $connexion;
    
    $sql = "SELECT * FROM panier WHERE idcli = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idcli]);
    $lignes = $stmt->fetchAll();
    
    $contenu = [];
    foreach ($lignes as $ligne) {
        $contenu[$ligne['idProduit']] = $ligne['quantite'];
    }
    return $contenu;
}
 public static function retirer(int $idcli, int $idProduit) {
    global $connexion;
    
    $sql = "DELETE FROM panier WHERE idcli = ? AND idProduit = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idcli, $idProduit]);
}
public static function getNombreArticle(int $idcli): int {
    $contenu = self::getContenu($idcli);
    return array_sum($contenu);
}
public static function vider(int $idcli) {
    global $connexion;
    
    $sql = "DELETE FROM panier WHERE idcli = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idcli]);
}
public static function diminuer(int $idcli, int $idProduit) {
    global $connexion;
    
    $sql = "SELECT * FROM panier WHERE idcli = ? AND idProduit = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([$idcli, $idProduit]);
    $ligne = $stmt->fetch();
    
    if ($ligne) {
        if ($ligne['quantite'] <= 1) {
            self::retirer($idcli, $idProduit);
        } else {
            $sqlUpdate = "UPDATE panier SET quantite = quantite - 1 WHERE idcli = ? AND idProduit = ?";
            $stmtUpdate = $connexion->prepare($sqlUpdate);
            $stmtUpdate->execute([$idcli, $idProduit]);
        }
    }
}






}
?>