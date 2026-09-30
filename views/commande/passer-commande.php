<?php
require_once __DIR__. '/../../header.php';
?>
<?php if ($succes !== null): ?>
  <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 text-center">
    <?= htmlspecialchars($succes) ?>
  </div>
<?php endif; ?>

<?php if ($erreur !== null): ?>
  <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4 text-center">
    <?= htmlspecialchars($erreur) ?>
  </div>
<?php endif; ?>
<form action="validation-commande.php" method="POST">
<div class="container mx-auto p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
  
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Commande</h2>
    

    <!-- Adresse livraison -->
    <h3 class="text-lg font-semibold mb-2">Adresse de livraison</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
      <input type="text" class="border rounded-md p-2" placeholder="Ville" name="ville" required>
      <input type="text" class="border rounded-md p-2" placeholder="Quartier" name="quartier" required>
      <input type="text" class="border rounded-md p-2" placeholder="Rue" name="rue" required>
    </div>

    <!-- Mode de paiement -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700">Mode de paiement</label>
      <select class="mt-1 w-full border rounded-md p-2" name="mode_paiement">
        <option value="CarteBancaire">Carte bancaire</option>
        <option value="OrangeMoney">Orange Money</option>
        <option value="Wave">Wave</option>
        <option value="EspecesLivraison">Espèces à la livraison</option>
      </select>
    </div>


    <button class="w-full bg-[#9C2007] text-white py-2 rounded-md hover:bg-red-700 transition" name="submit">
      Valider la commande
    </button>
  </div>
 

  <!--  Résumé du panier -->
  <div class="bg-gray-50 shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Résumé du panier</h2>
    
    <?php foreach ($lignesPanier as $ligne): ?>
  <div class="flex items-center justify-between mb-4">
    <div>
      <p class="font-semibold"><?= htmlspecialchars($ligne['produit']->getNom()) ?></p>
      <p class="text-sm text-gray-600">Quantité : <?= $ligne['quantite'] ?></p>
    </div>
    <p class="font-medium"><?= number_format($ligne['produit']->getPrix() * $ligne['quantite'], 0, ',', ' ') ?> FCFA</p>
  </div>
  <?php endforeach; ?>
    <div class="border-t pt-4">
  <p class="flex justify-between">
    <span>Sous-total</span>
    <span><?= number_format($sousTotal, 0, ',', ' ') ?> FCFA</span>
  </p>
  <p class="flex justify-between">
    <span>Livraison</span>
    <span><?= number_format($fraisLivraison, 0, ',', ' ') ?> FCFA</span>
  </p>
  <p class="flex justify-between font-bold text-red-600">
    <span>Total</span>
    <span><?= number_format($total, 0, ',', ' ') ?> FCFA</span>
  </p>
</div>

</div>
 </form>
