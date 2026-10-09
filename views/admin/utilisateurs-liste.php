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

<?php $moi = SessionManager::getUser(); ?>

<div class="container mx-auto p-8 max-w-4xl">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestion des utilisateurs</h2>

  <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-neutral-900 text-white">
      <tr>
        <th class="p-3 text-left">Prénom</th>
        <th class="p-3 text-left">Nom</th>
        <th class="p-3 text-left">Email</th>
        <th class="p-3 text-left">Rôle</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($utilisateurs as $u): ?>
        <tr class="border-b">
          <td class="p-3"><?= htmlspecialchars($u->getPrenom()) ?></td>
          <td class="p-3"><?= htmlspecialchars($u->getNom()) ?></td>
          <td class="p-3"><?= htmlspecialchars($u->getEmail()) ?></td>
          <td class="p-3">
            <?php if ((int)$u->getIdU() === (int)$moi->getIdU()): ?>
              <span class="text-gray-500"><?= htmlspecialchars($u->getRole()) ?> (vous)</span>
            <?php else: ?>
              <form action="admin-utilisateur-role.php" method="POST" class="flex gap-2">
                <input type="hidden" name="idU" value="<?= $u->getIdU() ?>">
                <select name="role" class="border rounded px-2 py-1">
                  <option value="client" <?= $u->getRole() === 'client' ? 'selected' : '' ?>>client</option>
                  <option value="admin" <?= $u->getRole() === 'admin' ? 'selected' : '' ?>>admin</option>
                </select>
                <button type="submit" class="text-blue-600 hover:underline">Enregistrer</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__.'/../../footer.php'; ?>