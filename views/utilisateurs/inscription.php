<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inscription</title>
</head>
<body>
    
   

    



    <div class="min-h-screen bg-[url('../../assets/images/fond_inscription.jpeg')] bg-cover flex flex-col items-center justify-center ">
    <a href="../../index.php" class="text-2xl font-bold text-white mb-6">Eshop</a>
    <form action="" method="POST" class="bg-white/25 backdrop-blur-sm rounded-lg shadow-lg p-8 flex flex-col gap-4 w-lg justify-center">
       
    <?php
    if(!empty($erreur)){?>
    <p class="text-red-600 bg-white/70">
     <?= $erreur ?>
    </p>
    <?php } ?>
    <?php
    if($succes){?>
    <p class="text-green-600 bg-white/70">Inscription réussie!</p> 
    <?php } ?>

    <label for="prenom" class="block text-sm font-medium text-gray-900">
            <i class="fa-solid fa-user"></i>Prénom
        </label>
        <input type="text" name="prenom" id="prenom" placeholder="Entrer votre prenom"  class="w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-[#9C2007] p-2 mt-1">

        <label for="nom" class="block text-sm font-medium text-gray-900">
            <i class="fa-solid fa-user"></i>Nom
        </label>
        <input type="text" name="nom" id="nom"  placeholder="Entrer votre nom" class="w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-[#9C2007] p-2 mt-1">

        <label for="email" class="block text-sm font-medium text-gray-900">
            <i class="fa-solid fa-envelope"></i>Email
        </label>
        <input type="email" name="email" id="email"  placeholder="Entrer votre email" class="w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-[#9C2007] p-2 mt-1">
        
        <label for="mdp" class="block text-sm font-medium text-gray-900">
           <i class="fa-solid fa-lock"></i>Mot de passe
        </label>
        <input type="password" name="mdp" id="mdp"  placeholder="Entrer votre mot de passe" class="w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-[#9C2007] p-2 mt-1">
       
        <label for="verifmdp" class="block text-sm font-medium text-gray-900">
           <i class="fa-solid fa-lock"></i>Confirmez le mot de passe
        </label>
        <input type="password" name="verifmdp" id="verifmdp"  placeholder="Confirmez votre mot de pass" class="w-full border-b border-gray-400 bg-transparent focus:outline-none focus:border-[#9C2007] p-2 mt-1">
        <button type="submit" name="submit" class="bg-[#9C2007]  p-2 rounded-lg w-32 font-semibold rounded-md">S'inscrire</button>
        <p class="block text-sm font-medium text-gray-900">Vous avez dejà un compte <a href="../../connexion-utilisateur.php">Connexion</a></p>


    </form>
    </div>
</body>
</html>