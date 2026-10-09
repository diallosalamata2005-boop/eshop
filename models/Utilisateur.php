<?php
require_once __DIR__.'/../Database/db_connect.php';
class Utilisateur{
private int $idU;
private string $prenom;
private string $nom;
private string $email;
private string $mdp;
private string $role;
public function __construct(int $idU,string $prenom, string $nom,string $email,string $mdp,string $role)
{
    $this->setIdU($idU);
    $this->setPrenom($prenom);
    $this->setNom($nom);
    $this->setEmail($email);
    $this->setMdp($mdp);
    $this->setRole($role);
    
}
public function setIdU(int $idU){
    $this->idU=$idU;
}
public function getIdU(){
    return $this->idU;
}
public function setPrenom(string $prenom){
    $this->prenom=$prenom;
}
public function getPrenom(){
    return $this->prenom;
}
public function setNom(string $nom){
    $this->nom=$nom;
}
public function getNom(){
    return $this->nom;
}
public function setEmail(string $email){
    $this->email=$email;
}
public function getEmail(){
    return $this->email;
}
public function setMdp(string $mdp){
    $this->mdp=$mdp;
    
}
public function getMdp(){
    return $this->mdp;
}
public function setRole(string $role){
    $this->role=$role;
}
public function getRole(){
    return $this->role;
}

public static function inscrire(string $prenom,string $nom,string $email,string $mdp):bool{
global $connexion;
// hash le mdp passer en parametre
$mdpHache=password_hash($mdp,PASSWORD_DEFAULT); 
$utilisateur=new Utilisateur(0,$prenom,$nom,$email,$mdpHache,'client');

$sql="INSERT INTO utilisateur(prenom,nom,email,mdp,role) VALUES(?,?,?,?,?)";
$stmt=$connexion->prepare($sql);
try{
return $stmt->execute(// remplit les ? un par un da,s l'ordre que je te les donne
[
$utilisateur->getPrenom(),
$utilisateur->getNom(),
$utilisateur->getEmail(),
$utilisateur->getMdp(),
$utilisateur->getRole(),
]
);
}catch(PDOException $e){
    return false;
}
}
public static function recupererParEmail(string $email):?Utilisateur{
global $connexion;
$sql="SELECT * FROM utilisateur u  WHERE u.email=?";
$stmt=$connexion->prepare($sql);
$stmt->execute([$email]);
$ligne=$stmt->fetch();
if($ligne){
    return new Utilisateur($ligne['idU'],$ligne['prenom'],$ligne['nom'],$ligne['email'],$ligne['mdp'],$ligne['role']);

}
return null;
}
public static function connecter(string $email,string $mdp):?Utilisateur{
$utilisateur=Utilisateur::recupererParEmail($email);
if($utilisateur===null){
    return null;
}
if (password_verify($mdp,$utilisateur->getMdp())){
    return $utilisateur;
}
return null;
 

}
public static function recupererParId(int $id):?Utilisateur{
global $connexion;
$sql="SELECT * FROM utilisateur u  WHERE u.idU=?";
$stmt=$connexion->prepare($sql);
$stmt->execute([$id]);
$ligne=$stmt->fetch();
if($ligne){
    return new Utilisateur($ligne['idU'],$ligne['prenom'],$ligne['nom'],$ligne['email'],$ligne['mdp'],$ligne['role']);

}
return null;
}

public static function recupererTous(): array {
    global $connexion;
    $utilisateurs = [];

    $stmt = $connexion->prepare("SELECT * FROM utilisateur ORDER BY idU");
    $stmt->execute();
    $lignes = $stmt->fetchAll();

    foreach ($lignes as $ligne) {
         $utilisateur= new Utilisateur($ligne['idU'],$ligne['prenom'],$ligne['nom'],$ligne['email'],$ligne['mdp'],$ligne['role']);

        $utilisateurs[] = $utilisateur;
    }

    return $utilisateurs;
}

public static function changerRole(int $idU, string $role): bool {
    global $connexion;

    $stmt = $connexion->prepare("UPDATE utilisateur SET role = ? WHERE idU = ?");
    return $stmt->execute([$role, $idU]);
}

}
?>