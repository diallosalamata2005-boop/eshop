<?php
require __DIR__.'/../../header.php';?>
<?php if($produit===null) {?>
    <p>ce produit n'existe pas </p>

<?php }else { ?>

<div class="bg-white rounded-lg shadow-md p-4 flex flex-col gap-2 items-center text-center">
 <span class="text-xs uppercase text-gray-500"><?= $produit->getCategorie()->getNomcat() ?></span> 
 <div class="w-full h-85 bg-gray-50 rounded-md flex items-center justify-center">
 <img src="../../../assets/images/<?= $produit->getImage()?>" alt="<?= $produit->getNom()?>" class="max-w-full max-h-full object-contain">  
 </div>
<h3 class="font-semibold"><?= $produit->getNom()?></h3>
<p class="text-sm text-gray-600"><?= $produit->getDescription() ?></p>
<p class="text-[#9C2007] font-bold"><?= $produit->getPrix() ?> FCFA</p>
</div>
<?php }?>
<?php require __DIR__.'/../../footer.php';?>