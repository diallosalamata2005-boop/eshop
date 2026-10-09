<?php
require_once __DIR__.'/../models/SessionManager.php';
require_once __DIR__.'/../models/Utilisateur.php';
require_once __DIR__.'/../models/Produit.php';
require_once __DIR__.'/../models/Categorie.php';
require_once __DIR__.'/../models/Commande.php';

class AdminController {

    private static function verifierAdmin() {
        SessionManager::Startsession();
        $utilisateur = SessionManager::getUser();
        
        if ($utilisateur === null) {
            header("location:connexion-utilisateur.php");
            exit();
        }
        
        if ($utilisateur->getRole() !== "admin") {
            header("location:index.php");
            exit();
        }
    }
    public function listeProduits(){
    self::verifierAdmin();
    $produits = Produit::recupererTous();
    $succes = $_SESSION['succes'] ?? null;
$erreur = $_SESSION['erreur'] ?? null;
unset($_SESSION['succes'], $_SESSION['erreur']);
    require_once __DIR__.'/../views/admin/produits-liste.php';
}
public function afficherFormulaireAjout() {
    self::verifierAdmin();
    $categories = Categorie::recupererToutes();
    require __DIR__ . '/../views/admin/produit-ajouter.php';
}
public function ajouterProduit() {
    self::verifierAdmin();

    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';
    $prix = $_POST['prix'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $idCat = $_POST['id_cat'] ?? 0;
    $image = $_FILES['image'] ?? null;

    if (empty($nom) || empty($description) || $prix==='' || $stock===''|| empty($idCat) || empty($image)) {
        $_SESSION['erreur'] = "Tous les champs sont obligatoires.";
        header("Location: admin-produit-ajouter.php");
        exit;
    }

    $reussite = Produit::creer($nom, $description, (float)$prix, (int)$stock, (int)$idCat, $image);

    if ($reussite) {
        $_SESSION['succes'] = "Produit ajouté avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de l'ajout du produit.";
    }

    header("Location: admin-produit.php");
    exit;
}
public function supprimerProduit() {
    self::verifierAdmin();

    $id = (int)($_POST['id'] ?? 0);

    if ($id<=0) {
        $_SESSION['erreur'] = "Indentifiant de produit invalide.";
        header("Location: admin-produit.php");
        exit;
    }
    try{
    $reussite = Produit::supprimer($id);
    }catch(PDOException $e){
   $_SESSION['erreur'] = "Impossible de supprimé ce produit : il fait partie des commande existantes";
    header("Location: admin-produit.php");
        exit;
    
   }
    if ($reussite) {
        $_SESSION['succes'] = "Produit supprimé avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de la suppression du produit.";
    }
    header("Location: admin-produit.php");
    exit();
}
public function afficherFormulaireModification() {
    self::verifierAdmin();

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        $_SESSION['erreur'] = "Identifiant de produit invalide.";
        header("Location: admin-produit.php");
        exit;
    }

    $produit = Produit::recupererParId($id);

    if ($produit === null) {
        $_SESSION['erreur'] = "Produit introuvable.";
        header("Location: admin-produit.php");
        exit;
    }

    $categories = Categorie::recupererToutes();
    require __DIR__ . '/../views/admin/produit-modifier.php';
}
public function modifierProduit() {
    self::verifierAdmin();

    $id          = (int)($_POST['id'] ?? 0);
    $nom         = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix        = $_POST['prix'] ?? '';
    $stock       = $_POST['stock'] ?? '';
    $idCat       = (int)($_POST['id_cat'] ?? 0);
    $image       = $_FILES['image'] ?? ['error' => UPLOAD_ERR_NO_FILE];

    if ($id <= 0) {
        $_SESSION['erreur'] = "Identifiant de produit invalide.";
        header("Location: admin-produit.php");
        exit;
    }

    if ($nom === '' || $description === '' || $prix === '' || $stock === '' || $idCat <= 0) {
        $_SESSION['erreur'] = "Tous les champs sont obligatoires.";
        header("Location: admin-produit.php");
        exit;
    }

    $reussite = Produit::modifier($id, $nom, $description, (float)$prix, (int)$stock, $idCat, $image);

    if ($reussite) {
        $_SESSION['succes'] = "Produit modifié avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de la modification du produit.";
    }

    header("Location: admin-produit.php");
    exit;
}
public function ajouterCategorie() {
    self::verifierAdmin();

    $nomcat = trim($_POST['nomcat'] ?? '');

    if ($nomcat === '') {
        $_SESSION['erreur'] = "Le nom de la catégorie est obligatoire.";
        header("Location: admin-categorie.php");
        exit;
    }

    try {
        $reussite = Categorie::creer($nomcat);
    } catch (PDOException $e) {
        if ((int)$e->errorInfo[1] === 1062) {
            $_SESSION['erreur'] = "Cette catégorie existe déjà.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'ajout de la catégorie.";
        }
        header("Location: admin-categorie.php");
        exit;
    }

    if ($reussite) {
        $_SESSION['succes'] = "Catégorie ajoutée avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de l'ajout de la catégorie.";
    }

    header("Location: admin-categorie.php");
    exit;
}

public function modifierCategorie() {
    self::verifierAdmin();

    $idcat  = (int)($_POST['idcat'] ?? 0);
    $nomcat = trim($_POST['nomcat'] ?? '');

    if ($idcat <= 0 || $nomcat === '') {
        $_SESSION['erreur'] = "Données invalides.";
        header("Location: admin-categorie.php");
        exit;
    }

    try {
        $reussite = Categorie::modifier($idcat, $nomcat);
    } catch (PDOException $e) {
        if ((int)$e->errorInfo[1] === 1062) {
            $_SESSION['erreur'] = "Une catégorie porte déjà ce nom.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de la modification de la catégorie.";
        }
        header("Location: admin-categorie.php");
        exit;
    }

    if ($reussite) {
        $_SESSION['succes'] = "Catégorie modifiée avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de la modification de la catégorie.";
    }

    header("Location: admin-categorie.php");
    exit;
}

public function supprimerCategorie() {
    self::verifierAdmin();

    $idcat = (int)($_POST['idcat'] ?? 0);

    if ($idcat <= 0) {
        $_SESSION['erreur'] = "Identifiant de catégorie invalide.";
        header("Location: admin-categorie.php");
        exit;
    }

    try {
        $reussite = Categorie::supprimer($idcat);
    } catch (PDOException $e) {
        if ((int)$e->errorInfo[1] === 1451) {
            $_SESSION['erreur'] = "Impossible de supprimer cette catégorie : elle contient des produits.";
        } else {
            $_SESSION['erreur'] = "Erreur lors de la suppression de la catégorie.";
        }
        header("Location: admin-categorie.php");
        exit;
    }

    if ($reussite) {
        $_SESSION['succes'] = "Catégorie supprimée avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de la suppression de la catégorie.";
    }

    header("Location: admin-categorie.php");
    exit;
}
public function listeCategorie(){
    self::verifierAdmin();
    $categories = Categorie::recupererToutes();
    $succes = $_SESSION['succes'] ?? null;
$erreur = $_SESSION['erreur'] ?? null;
unset($_SESSION['succes'], $_SESSION['erreur']);
    require_once __DIR__.'/../views/admin/categorie-liste.php';
}
public  function afficherFormulaireModificationCategorie(){
self::verifierAdmin();

    $idcat = (int)($_GET['idcat'] ?? 0);

    if ($idcat <= 0) {
        $_SESSION['erreur'] = "Identifiant de la categorie invalide.";
        header("Location: admin-categorie.php");
        exit;
    }

    $categorie = categorie::recupererParId($idcat);

    if ($categorie === null) {
        $_SESSION['erreur'] = "Categorie introuvable.";
        header("Location: admin-categorie.php");
        exit;
    }
    require __DIR__ . '/../views/admin/categorie-modifier.php';
}
public function listeUtilisateurs() {
    self::verifierAdmin();

    $utilisateurs = Utilisateur::recupererTous();

    $succes = $_SESSION['succes'] ?? null;
    $erreur = $_SESSION['erreur'] ?? null;
    unset($_SESSION['succes'], $_SESSION['erreur']);

    require __DIR__ . '/../views/admin/utilisateurs-liste.php';
}

public function changerRoleUtilisateur() {
    self::verifierAdmin();

    $idCible = (int)($_POST['idU'] ?? 0);
    $role    = $_POST['role'] ?? '';

    if ($idCible <= 0) {
        $_SESSION['erreur'] = "Identifiant d'utilisateur invalide.";
        header("Location: admin-utilisateur.php");
        exit;
    }

    $moi = SessionManager::getUser();
    if ($moi->getIdU() === $idCible) {
        $_SESSION['erreur'] = "Vous ne pouvez pas modifier votre propre rôle.";
        header("Location: admin-utilisateur.php");
        exit;
    }

    $rolesAutorises = ['client', 'admin'];
    if (!in_array($role, $rolesAutorises, true)) {
        $_SESSION['erreur'] = "Rôle invalide.";
        header("Location: admin-utilisateur.php");
        exit;
    }

    $reussite = Utilisateur::changerRole($idCible, $role);

    if ($reussite) {
        $_SESSION['succes'] = "Rôle modifié avec succès.";
    } else {
        $_SESSION['erreur'] = "Erreur lors de la modification du rôle.";
    }

    header("Location: admin-utilisateur.php");
    exit;
}
public function listeCommande() {
    self::verifierAdmin();

    $commandes = Commande::recupererTous();

    $succes = $_SESSION['succes'] ?? null;
    $erreur = $_SESSION['erreur'] ?? null;
    unset($_SESSION['succes'], $_SESSION['erreur']);

    require __DIR__ . '/../views/admin/commande-liste.php';
}
public function changerStatutCommande() {
    self::verifierAdmin();

    $idCom  = (int)($_POST['idCom'] ?? 0);
    $statut = $_POST['statut'] ?? '';

    if ($idCom <= 0) {
        $_SESSION['erreur'] = "Identifiant de commande invalide.";
        header("Location: admin-commande.php");
        exit;
    }

    if (!in_array($statut, Commande::STATUTS, true)) {
        $_SESSION['erreur'] = "Statut invalide.";
        header("Location: admin-commande.php");
        exit;
    }

    try {
        $reussite = Commande::changerStatut($idCom, $statut);
    } catch (PDOException $e) {
        $reussite = false;
    }

    if ($reussite) {
        $_SESSION['succes'] = "Statut de la commande mis à jour.";
    } else {
        $_SESSION['erreur'] = "Impossible de modifier cette commande(introuvable ou a déjà été annulée).";
    }

    header("Location: admin-commande.php");
    exit;
}
}
 


