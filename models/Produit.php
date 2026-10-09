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
INNER JOIN categorie c on c.idcat=p.id_cat WHERE p.actif=1;
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
public static function rechercher(string $q): array {
    global $connexion;
    
    $sql = "SELECT p.*, c.nomcat, c.idcat
            FROM produits p 
            JOIN categorie c ON p.id_cat = c.idcat
            WHERE ((p.nom LIKE ? OR c.nomcat LIKE ?) AND p.actif=1)";
    $stmt = $connexion->prepare($sql);
    $recherche = '%' . $q . '%';
    $stmt->execute([$recherche, $recherche]);
    $lignes = $stmt->fetchAll();
    
    $produits = [];
    foreach ($lignes as $ligne) {
      $categorie=new Categorie($ligne['idcat'],$ligne['nomcat']); 
    $prod= new Produit($ligne['id'],$ligne['nom'],$ligne['description'],$ligne['image'],$ligne['prix'],$ligne['stock'],$categorie);
    $produits []=$prod;

    }
    return $produits;
}
public static function supprimer(int $id): ?string {
    global $connexion;

    // 1. Le produit existe-t-il ? Récupérer le nom de son image
    $stmt = $connexion->prepare("SELECT image FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    $ligne = $stmt->fetch();
    if (!$ligne) {
        return null;
    }

    // 2. A-t-il déjà été commandé ?
    $stmt = $connexion->prepare("SELECT COUNT(*) FROM commande_produit WHERE idprod = ?");
    $stmt->execute([$id]);
    $dejaCommande = (int)$stmt->fetchColumn() > 0;

    // 3a. Déjà commandé : on le désactive, l'image reste
    if ($dejaCommande) {
        $stmt = $connexion->prepare("UPDATE produits SET actif = 0 WHERE id = ?");
        $stmt->execute([$id]);
        return 'desactive';
    }

    // 3b. Jamais commandé : suppression complète
    $stmt = $connexion->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);

    $chemin = __DIR__ . '/../assets/images/' . $ligne['image'];
    if (is_file($chemin)) {
        unlink($chemin);
    }
    return 'supprime';
}
public static function creer(string $nom, string $description, float $prix, int $stock, int $idCat, array $fichierImage): bool {
    // Extensions autorisées
    $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif'];

    // Récupérer l’extension du fichier
    $extension = strtolower(pathinfo($fichierImage['name'], PATHINFO_EXTENSION));

    // Vérifier si l’extension est valide
    if (!in_array($extension, $extensionsAutorisees)) {
        return false; // Refuse si extension non autorisée
    }

    // Générer un nom unique pour l’image
    $nomFichier = uniqid() . '.' . $extension;

    // Chemin de destination
    $destination = __DIR__ . '/../assets/images/' . $nomFichier;

    // Déplacer le fichier uploadé
    if (!move_uploaded_file($fichierImage['tmp_name'], $destination)) {
        return false; // Refuse si le déplacement échoue
    }

   
    global $connexion;

    
    $sql = "INSERT INTO produits(nom, description, image, prix, stock, id_cat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);

    
    $reussite = $stmt->execute([$nom, $description, $nomFichier, $prix, $stock, $idCat]);

    return $reussite;
}
public static function modifier(int $id, string $nom, string $description, float $prix, int $stock, int $idCat, array $fichierImage): bool {
    global $connexion;

    // Charger l'ancien produit (pour connaître son ancienne image)
    $ancien = self::recupererParId($id);
    if ($ancien === null) {
        return false;
    }

    $nouvelleImage = null;

    //  Une nouvelle image a-t-elle été choisie ?
    if ($fichierImage['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($fichierImage['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($fichierImage['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionsAutorisees)) {
            return false;
        }
        $nouvelleImage = uniqid() . '.' . $extension;
        $destination = __DIR__ . '/../assets/images/' . $nouvelleImage;
        if (!move_uploaded_file($fichierImage['tmp_name'], $destination)) {
            return false;
        }
    }

    //  Deux requêtes possibles selon qu'il y a une nouvelle image ou non
    if ($nouvelleImage !== null) {
        $sql = "UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ?, id_cat = ?, image = ? WHERE id = ?";
        $params = [$nom, $description, $prix, $stock, $idCat, $nouvelleImage, $id];
    } else {
        $sql = "UPDATE produits SET nom = ?, description = ?, prix = ?, stock = ?, id_cat = ? WHERE id = ?";
        $params = [$nom, $description, $prix, $stock, $idCat, $id];
    }
    $stmt = $connexion->prepare($sql);
    $reussite = $stmt->execute($params);

    //  Nettoyage des fichiers
    if ($nouvelleImage !== null) {
        if ($reussite) {
            $ancienChemin = __DIR__ . '/../assets/images/' . $ancien->getImage();
            if (is_file($ancienChemin)) {
                unlink($ancienChemin);
            }
        } else {
            unlink($destination);
        }
    }

    return $reussite;
}
public static function estDisponible(int $id): bool {
    global $connexion;
    $stmt = $connexion->prepare("SELECT COUNT(*) FROM produits WHERE id = ? AND actif = 1 AND stock > 0");
    $stmt->execute([$id]);
    return (int)$stmt->fetchColumn() > 0;
}

}