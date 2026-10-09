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

<div class="container mx-auto p-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestion des commandes</h2>

  <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-neutral-900 text-white">
      <tr>
        <th class="p-3 text-left">N°</th>
        <th class="p-3 text-left">Date</th>
        <th class="p-3 text-left">Client</th>
        <th class="p-3 text-left">Total</th>
        <th class="p-3 text-left">Paiement</th>
        <th class="p-3 text-left">Statut</th>
      </tr>
    </thead>
    <tbody>
     <?php foreach ($commandes as $c): ?>
        <tr class="border-b">
          <td class="p-3"><?= $c->getIdcommande() ?></td>
          <td class="p-3"><?= htmlspecialchars($c->getDatecom()) ?></td>
          <td class="p-3">
            <?= htmlspecialchars($c->getUtilisateur()->getPrenom() . ' ' . $c->getUtilisateur()->getNom()) ?>
          </td>
          <td class="p-3"><?= number_format($c->getTotal(), 0, ',', ' ') ?> FCFA</td>
          <td class="p-3"><?= htmlspecialchars($c->getModePaiement()) ?></td>
          <td class="p-3">
            <?php if ($c->getStatutCom() === 'annulée'): ?>
              <span class="text-gray-500">annulée</span>
            <?php else: ?>
              <form action="admin-commande-statut.php" method="POST" class="flex gap-2"
                    onsubmit="return this.statut.value !== 'annulée' || confirm('Annuler cette commande ? Le stock sera remis et le statut ne pourra plus changer.');">
                <input type="hidden" name="idCom" value="<?= $c->getIdcommande() ?>">
                <select name="statut" class="border rounded px-2 py-1">
                  <?php foreach (Commande::STATUTS as $s): ?>
                    <option value="<?= $s ?>" <?= $c->getStatutCom() === $s ? 'selected' : '' ?>>
                      <?= $s ?>
                    </option>
                  <?php endforeach; ?>
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