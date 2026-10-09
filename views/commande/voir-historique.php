<?php require_once __DIR__.'/../../header.php'; ?>

<div class="container mx-auto p-8">
  <h2 class="text-2xl font-bold mb-6 text-gray-800">Mes commandes</h2>

  <?php if (empty($histo_com)): ?>
    <p class="text-center text-gray-500">Vous n'avez pas encore passé de commande.</p>
  <?php else: ?>

    <?php foreach ($histo_com as $commande): ?>
      <div class="bg-white shadow-md rounded-lg p-6 mb-6">

        <!-- En-tête de la commande -->
        <div class="flex justify-between items-center border-b pb-4 mb-4">
          <div>
            <p class="font-semibold text-gray-800">Commande n°<?= $commande->getIdcommande() ?></p>
            <p class="text-sm text-gray-500"><?= $commande->getDatecom() ?></p>
          </div>
          <div class="text-right">
            <p class="text-sm">
              <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                <?= htmlspecialchars($commande->getStatutCom()) ?>
              </span>
            </p>
            <p class="font-bold text-[#9C2007] mt-1">
              <?= number_format($commande->getTotal(), 0, ',', ' ') ?> FCFA
            </p>
          </div>
        </div>

        <!-- Détail des produits -->
        <?php $lignes = Commande::getLignes($commande->getIdcommande()); ?>
        <?php foreach ($lignes as $ligne): ?>
          <div class="flex justify-between items-center py-2 text-sm text-gray-700">
            <span>
              <?= htmlspecialchars($ligne['produit']->getNom()) ?> × <?= $ligne['quantite'] ?>
            </span>
            <span>
              <?= number_format($ligne['prix_unitaire'] * $ligne['quantite'], 0, ',', ' ') ?> FCFA
            </span>
          </div>
        <?php endforeach; ?>
        <div class="flex justify-between border-t mt-2 pt-2 text-sm text-gray-500">
  <span>Frais de livraison</span>
  <span><?= number_format($commande->getFraisLivraison(), 0, ',', ' ') ?> FCFA</span>
</div>

      </div>
    <?php endforeach; ?>

  <?php endif; ?>
</div>

<?php require_once __DIR__.'/../../footer.php'; ?>