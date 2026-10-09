<?php require __DIR__.'/../../header.php';
$totalPanier=0;
?>
<div class="container mx-auto p-6">
  <h2 class="text-2xl font-bold mb-4"><i class="fa-solid fa-shopping-cart text-xl text-[#9C2007]"></i> Mon Panier</h2>

  <div class="grid grid-cols-3 gap-6">
    <!-- Liste des produits -->
    <div class="col-span-2 space-y-4">
                    <?php if(empty($lignesPanier)){?>
                    <div class="text-center py-9 ">
                    <p class="text-gray-500 font-bold">Votre panier est vide</p>
                    </div>

        <?php }else { ?>
      <?php foreach ($lignesPanier as $ligne) { ?>
        <?php $totalPanier+=$ligne['quantite'] * $ligne['produit']->getPrix();
        ?>
        <div class="flex items-center bg-white shadow-md rounded-lg p-4">
    <img src="../../../assets/images/<?= $ligne['produit']->getImage() ?>" 
         alt="<?= $ligne['produit']->getNom() ?>" 
         class="w-24 h-24 object-contain rounded-md border">
    
    <div class="ml-4 flex-1">
        <h3 class="font-semibold"><?= $ligne['produit']->getNom() ?></h3>
        <p class="text-sm text-gray-600"><?= $ligne['produit']->getDescription() ?></p>
        <p class="text-[#9C2007] font-bold"><?= $ligne['produit']->getPrix() ?> FCFA</p>
        <p>Quantité : <?= $ligne['quantite'] ?></p>
        <p>Total : <?= $ligne['quantite'] * $ligne['produit']->getPrix() ?> FCFA</p>
    </div>

   
    <div class="flex flex-col items-center gap-2 ml-4">
        <a href="retirer-panier.php?id=<?= $ligne['produit']->getId() ?>" 
           class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition text-sm">
           Retirer
        </a>

        <div class="flex items-center gap-2">
            <a href="diminuer-panier.php?id=<?= $ligne['produit']->getId() ?>&retour=panier" 
               class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                <i class="fa-solid fa-minus text-sm"></i>
            </a>
            <span class="px-2 font-semibold"><?= $ligne['quantite'] ?></span>
            <a href="ajouter-panier.php?id=<?= $ligne['produit']->getId() ?>&retour=panier" 
               class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                <i class="fa-solid fa-plus text-sm"></i>
            </a>
        </div>
    </div>
</div>
      <?php } ?>
      <?php } ?>
    </div>

    <!-- Résumé de commande -->
     <?php if(!empty($lignesPanier)){?>
    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
      <h3 class="text-lg font-bold mb-4">Résumé de commande</h3>
      <p>Total articles : <?= Panier::getNombreArticle(SessionManager::getUser()->getIdU()) ?></p>
      <p>Total panier : 
        <span class="text-[#9C2007] font-bold">
          <?= $totalPanier ?> FCFA
        </span>
      </p>
      <a href="validation-commande.php" 
         class="mt-4 block bg-[#9C2007] text-white text-center py-2 rounded-md hover:bg-[#b52a0a] transition">
         Procéder au paiement
      </a>
    </div>
    <?php }?>
  </div>
</div>

<?php require __DIR__.'/../../footer.php'; ?>
