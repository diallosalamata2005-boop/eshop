<?php
require_once __DIR__.'/models/Utilisateur.php';
require_once __DIR__.'/models/SessionManager.php';
SessionManager::Startsession();
$utilisateurConnecte=SessionManager::getUser();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eshop</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="flex p-5 gap-60 bg-neutral-900 text-white items-center">
        <h1 class="font-bold text-xl">Eshop</h1>
        <ul class="flex  gap-20 ">
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="">Accueil</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="">A propos</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="">Nos produits</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="">Contact</a></li>
        </ul>
        <div class="flex gap-5">
           <a href=""> <i class="fa-solid fa-magnifying-glass text-lg"></i></a>
           <?php if($utilisateurConnecte===null){?>
         <a href="connexion-utilisateur.php"><i class="fa-solid fa-user text-lg"></i></a>
         <?php }else{?>
         <span class="text-sm">Bonjour <?= $utilisateurConnecte->getPrenom() ?></span>
           <a href="deconnexion-utilisateur.php" class="border-2 border-[#9C2007] font-semibold" >Déconnexion</a>
            <?php }?>
        </div>
    </div>
</body>

</html>