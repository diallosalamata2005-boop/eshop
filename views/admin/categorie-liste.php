<?php require_once __DIR__.'/../../header.php'; ?>

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

<div class="container mx-auto p-8 max-w-2xl">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestion des catégories</h2>

  <form action="admin-categorie-ajouter.php" method="POST" class="flex gap-2 mb-6">
    <input type="text" name="nomcat" required placeholder="Nom de la nouvelle catégorie"
           class="flex-1 border rounded px-3 py-2">
    <button type="submit" class="bg-[#9C2007] text-white px-4 py-2 rounded hover:opacity-90">
      + Ajouter
    </button>
  </form>

  <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-neutral-900 text-white">
      <tr>
        <th class="p-3 text-left">Nom</th>
        <th class="p-3 text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $cat): ?>
        <tr class="border-b">
          <td class="p-3"><?= htmlspecialchars($cat->getNomcat()) ?></td>
          <td class="p-3 flex gap-4">
            <a href="admin-categorie-modifier.php?idcat=<?= $cat->getIdcat() ?>"
               class="text-blue-600 hover:underline">Modifier</a>

            <form action="admin-categorie-supprimer.php" method="POST"
                  onsubmit="return confirm('Supprimer cette catégorie ?');">
              <input type="hidden" name="idcat" value="<?= $cat->getIdcat() ?>">
              <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__.'/../../footer.php'; ?>