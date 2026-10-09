<?php
require_once __DIR__.'/models/Utilisateur.php';
require_once __DIR__.'/models/Panier.php';
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
    <div class="flex p-5 justify-between bg-neutral-900 text-white items-center">
        <h1 class="font-bold text-xl">Eshop</h1>
        <ul class="flex  gap-20 ">
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="index.php">Accueil</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="a-propos.php">A propos</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="index.php">Nos produits</a></li>
            <li><a class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" href="contact.php">Contact</a></li>
        </ul>
        <div class="flex gap-5">
            <div class="relative">
  <button onclick="document.getElementById('loupe').classList.toggle('hidden')">
    <i class="fa-solid fa-magnifying-glass text-lg"></i>
  </button>
  <form id="loupe" action="index.php" method="GET" 
        class="hidden absolute right-0 mt-2 bg-white p-2 rounded shadow">
    <input type="text" name="q" placeholder="Rechercher..." 
           class="border rounded-md p-2 text-black" required>
    <button type="submit" class="ml-2 text-[#9C2007]">
      <i class="fa-solid fa-arrow-right"></i>
    </button>
  </form>
</div>
           <?php if($utilisateurConnecte===null){?>
         <a href="connexion-utilisateur.php"><i class="fa-solid fa-user text-lg"></i></a>
         <?php }else{?>
         <?php if ($utilisateurConnecte->getRole() === 'admin'): ?>
            <div class="relative group">
                <a href="admin-produit.php" class="hover:text-[#9C2007]">Administration</a>
                <div class="absolute right-0 top-full hidden group-hover:block bg-neutral-900 rounded shadow-lg min-w-[10rem] z-50">
                <a href="admin-produit.php" class="block px-4 py-2 hover:bg-neutral-800">Produits</a>
                <a href="admin-categorie.php" class="block px-4 py-2 hover:bg-neutral-800">Catégories</a>
                <a href="admin-utilisateur.php" class="block px-4 py-2 hover:bg-neutral-800">Utilisateurs</a>
                <a href="admin-commande.php" class="block px-4 py-2 hover:bg-neutral-800">Commandes</a>
                </div>
            </div>
            <?php endif; ?>
         <a href="panier.php" class="relative hover:text-[#9C2007]" aria-label="Panier">
            <i class="fa-solid fa-cart-shopping text-xl"></i>
            <?php
            $idcli = $utilisateurConnecte->getIdU();
            $nb = Panier::getNombreArticle($idcli);
            ?>
            <?php if ($nb > 0): ?>
            <span class="absolute -top-2 -right-2 bg-[#9C2007] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                <?= $nb ?>
            </span>
            <?php endif; ?>
        </a>
         <span class="text-sm">Bienvenue <?= $utilisateurConnecte->getPrenom() ?></span>
         <a href="historique-commande.php" class="relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-0 after:h-0.5 after:bg-[#9C2007] after:transition-all after:duration-300 hover:after:w-full transition hover:text-lg" >Mes commandes</a>
         <a href="deconnexion-utilisateur.php" class="border-2 border-[#9C2007] font-semibold" >Déconnexion</a>
            <?php }?>
        </div>
    </div>
