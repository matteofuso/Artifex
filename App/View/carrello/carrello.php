<?php /**
 * @var array $cart
 * @var string $path
 */?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Il Tuo Carrello</h1>

                <?php if (empty($cart)): ?>
                    <div class="alert alert-info">
                        Il tuo carrello è vuoto. <a href="eventi" class="alert-link">Scopri gli eventi disponibili</a> da aggiungere al carrello.
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Data e Ora</th>
                                        <th>Durata</th>
                                        <th>Prezzo</th>
                                        <th>Azioni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $totalPrice = 0;
                                    foreach ($cart as $item):
                                        $evento = $item->getEvento();
                                        $visita = $evento->getVisita();
                                        $totalPrice += $evento->getPrezzo();
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($visita->getTitolo()) ?></strong>
                                                <p class="text-muted small mb-0"><?= htmlspecialchars(substr($visita->getDescrizione(), 0, 100)) . (strlen($visita->getDescrizione()) > 100 ? '...' : '') ?></p>
                                            </td>
                                            <td><?= $evento->getInizio()->format('d/m/Y H:i') ?></td>
                                            <td><?= $visita->getDurataMedia() ?> min</td>
                                            <td>&euro;<?= number_format($evento->getPrezzo(), 2, ',', '.') ?></td>
                                            <td>
                                                <a href="<?= $path ?>rimuovi-dal-carrello?id=<?= $item->getId() ?>" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Rimuovi
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Totale:</strong></td>
                                        <td><strong>&euro;<?= number_format($totalPrice, 2, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="<?= $path ?>eventi" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Continua a esplorare
                        </a>
                        <a href="<?= $path ?>checkout" class="btn btn-success">
                            Procedi all'acquisto <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require 'App/View/component/footer.php'; ?>