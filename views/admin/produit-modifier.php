<?php require_once __DIR__.'/../../header.php'; ?>

<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier le produit</h1>

    <form action="admin-produit-modifier.php" method="POST" enctype="multipart/form-data" class="space-y-4">

        <input type="hidden" name="id" value="<?= $produit->getId() ?>">

        <div>
            <label for="nom" class="block mb-1 font-medium">Nom du produit</label>
            <input type="text" name="nom" id="nom" required
                   value="<?= htmlspecialchars($produit->getNom()) ?>"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="description" class="block mb-1 font-medium">Description</label>
            <textarea name="description" id="description" required
                      class="w-full border rounded px-3 py-2"><?= htmlspecialchars($produit->getDescription()) ?></textarea>
        </div>

        <div>
            <label for="prix" class="block mb-1 font-medium">Prix</label>
            <input type="number" name="prix" id="prix" step="0.01" min="0" required
                   value="<?= $produit->getPrix() ?>"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="stock" class="block mb-1 font-medium">Stock</label>
            <input type="number" name="stock" id="stock" min="0" required
                   value="<?= $produit->getStock() ?>"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="id_cat" class="block mb-1 font-medium">Catégorie</label>
            <select name="id_cat" id="id_cat" required class="w-full border rounded px-3 py-2">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->getIdCat() ?>"
                        <?= $cat->getIdcat() === $produit->getCategorie()->getIdcat() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat->getNomcat()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Image actuelle</label>
            <!-- on compare l'id de la categorie avec celui du produit et seul l'omtion qui correspond recoit selected-->
            <img src="assets/images/<?= htmlspecialchars($produit->getImage()) ?>" alt="" class="w-32 rounded mb-2">

            <label for="image" class="block mb-1 font-medium">Nouvelle image (facultatif)</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-[#9C2007] text-white px-4 py-2 rounded hover:opacity-90">
            Enregistrer les modifications
        </button>
    </form>
</div>
<?php require __DIR__.'/../../footer.php'; ?>
