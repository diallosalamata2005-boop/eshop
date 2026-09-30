<?php
require __DIR__.'/../../header.php';

?>
<?php if ($succes !== null): ?>
  <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 text-center">
    <?= htmlspecialchars($succes) ?>
  </div>
<?php endif; ?>
<div class="grid grid-cols-3 gap-4">
<?php foreach ($produits as $key => $prod) { ?>
<div class="bg-white rounded-lg shadow-md p-4 flex flex-col gap-2 items-center text-center">
 <span class="text-xs uppercase text-gray-500"><?= $prod->getCategorie()->getNomcat() ?></span> 
 <div class="w-full h-85 bg-gray-50 rounded-md flex items-center justify-center">
 <img src="../../../assets/images/<?= $prod->getImage()?>" alt="<?= $prod->getNom()?>" class="max-w-full max-h-full object-contain">  
 </div>
<h3 class="font-semibold"><?= $prod->getNom()?></h3>
<p class="text-sm text-gray-600"><?= $prod->getDescription() ?></p>
<p class="text-[#9C2007] font-bold"><?= $prod->getPrix() ?> FCFA</p>
<div class="flex gap-2 w-full">
  <a class="w-1/2 bg-[#9C2007] hover:bg-[#b52a0a] rounded-md font-semibold text-white shadow-md text-sm px-4 py-2 text-center transition-colors duration-300 transform hover:scale-105" 
   href="produit-detail.php?id=<?= $prod->getId() ?>">
   Voir détail
</a>

  <a class="w-1/2 bg-[#9C2007] hover:bg-[#b52a0a] rounded-md font-semibold text-white shadow-md text-sm px-4 py-2 text-center transition duration-300 transform hover:scale-105"
     href="ajouter-panier.php?id=<?= $prod->getId() ?>&retour=index">
     Ajouter au panier
  </a>
</div>
</div>
 
<?php } ?>
</div>
<?php require __DIR__. '/../../footer.php';?>