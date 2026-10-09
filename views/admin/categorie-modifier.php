<?php require_once __DIR__.'/../../header.php'; ?>

<div class="container mx-auto p-8 max-w-xl">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Modifier la catégorie</h2>

  <form action="admin-categorie-modifier.php" method="POST" class="space-y-4">
    <input type="hidden" name="idcat" value="<?= $categorie->getIdcat() ?>">

    <div>
      <label for="nomcat" class="block mb-1 font-medium">Nom de la catégorie</label>
      <input type="text" name="nomcat" id="nomcat" required
             value="<?= htmlspecialchars($categorie->getNomcat()) ?>"
             class="w-full border rounded px-3 py-2">
    </div>

    <div class="flex gap-4 items-center">
      <button type="submit" class="bg-[#9C2007] text-white px-4 py-2 rounded hover:opacity-90">
        Enregistrer
      </button>
      <a href="admin-categorie.php" class="text-gray-600 hover:underline">Annuler</a>
    </div>
  </form>
</div>
<?php require_once __DIR__.'/../../footer.php'; ?>