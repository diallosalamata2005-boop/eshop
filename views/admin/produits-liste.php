<?php require_once __DIR__.'/../../header.php'; ?>
<?php if ($succes !== null): ?>
  <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 text-center">
    <?= htmlspecialchars($succes) ?>
  </div>
<?php endif; ?>
 
<div class="container mx-auto p-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Gestion des produits</h2>
    <a href="admin-produit-ajouter.php" class="bg-[#9C2007] hover:bg-[#b52a0a] text-white px-4 py-2 rounded-md font-semibold">
      + Ajouter un produit
    </a>
  </div>

  <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-neutral-900 text-white">
      <tr>
        <th class="p-3 text-left">Image</th>
        <th class="p-3 text-left">Nom</th>
        <th class="p-3 text-left">Prix</th>
        <th class="p-3 text-left">Stock</th>
        <th class="p-3 text-left">Catégorie</th>
        <th class="p-3 text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($produits as $prod): ?>
        <tr class="border-b">
            <td class="p-3">
      <img src="assets/images/<?= $prod->getImage() ?>" alt="<?= $prod->getNom() ?>" class="w-16 h-16 object-contain">
            </td>
            <td class="p-3"><?= htmlspecialchars($prod->getNom()) ?></td>
            <td class="p-3"><?= number_format($prod->getPrix(), 0, ',', ' ') ?> FCFA</td>
            <td class="p-3"><?= $prod->getStock() ?></td>
            <td class="p-3"><?= htmlspecialchars($prod->getCategorie()->getNomcat()) ?></td>
            <td class="p-3">
      <a href="admin-produit-modifier.php?id=<?= $prod->getId() ?>" class="text-blue-600 hover:underline mr-3">Modifier</a>
      <form action="admin-produit-supprimer.php" method="POST" class="inline"
      onsubmit="return confirm('Supprimer ce produit ?');">
    <input type="hidden" name="id" value="<?= $prod->getId() ?>">
    <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
</form>
    </td>
  </tr>
        <?php endforeach; ?>
    
    </tbody>
  </table>
</div>

<?php require_once __DIR__.'/../../footer.php'; ?>