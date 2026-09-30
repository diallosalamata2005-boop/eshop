<?php
class SessionManager{
public static function Startsession(){
 if (session_status() === PHP_SESSION_NONE) {
        session_start();

    }
    
}
public static function setUser(Utilisateur $user){
$_SESSION['user']=$user;
}
public static function getUser(){
    return $_SESSION['user'] ?? null;
}
public static function sessionDestroy(){
    session_destroy();
}

}
?>