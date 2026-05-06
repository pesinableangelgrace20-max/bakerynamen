<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="card">
    <h3>Inventory Tracking</h3>
    <table>
        <thead><tr><th>Bread Name</th><th>Available Stock</th></tr></thead>
        <tbody>
            <?php foreach ($products ?? [] as $p): ?>
                <tr>
                    <td style="font-weight: 500;"><?= esc($p['name'] ?? '') ?></td>
                    <td>
                        <strong style="color: <?= ($p['stock'] < 10) ? '#ef4444' : '#10b981' ?>;">
                            <?= esc($p['stock'] ?? 0) ?> units
                        </strong>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
