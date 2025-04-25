<?php
/**
 * @var array $cart
 * @var string $path
 */
?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Checkout</h1>

                <?php if (empty($cart)): ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Il tuo carrello è vuoto. <a href="<?= $path ?>eventi" class="alert-link">Scopri gli eventi disponibili</a> prima di procedere al checkout.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <!-- Colonna sinistra: Riepilogo dell'ordine -->
                        <div class="col-lg-7 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary bg-opacity-10">
                                    <h5 class="mb-0">Riepilogo dell'ordine</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $totalPrice = 0;
                                    foreach ($cart as $item):
                                        $evento = $item->getEvento();
                                        $visita = $evento->getVisita();
                                        $totalPrice += $evento->getPrezzo();
                                        ?>
                                        <div class="d-flex mb-3 pb-3 border-bottom">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= htmlspecialchars($visita->getTitolo()) ?></h6>
                                                <div class="text-muted small mb-2">
                                                    <i class="bi bi-calendar-event me-1"></i> <?= $evento->getInizio()->format('d/m/Y H:i') ?>
                                                    <i class="bi bi-clock ms-3 me-1"></i> <?= $visita->getDurataMedia() ?> min
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    <?= htmlspecialchars(substr($visita->getDescrizione(), 0, 100)) . (strlen($visita->getDescrizione()) > 100 ? '...' : '') ?>
                                                </p>
                                            </div>
                                            <div class="text-end" style="min-width: 80px">
                                                <span class="fw-bold">&euro;<?= number_format($evento->getPrezzo(), 2, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                                        <h5>Totale</h5>
                                        <h5>&euro;<?= number_format($totalPrice, 2, ',', '.') ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colonna destra: Form di pagamento -->
                        <div class="col-lg-5">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary bg-opacity-10">
                                    <h5 class="mb-0">Dati per il pagamento</h5>
                                </div>
                                <div class="card-body">
                                    <form action="<?= $path ?>action/process-payment" method="post">
                                        <!-- Dati carta di credito -->
                                        <h6 class="mb-3">Metodo di pagamento</h6>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                   id="credit_card" value="credit_card" checked>
                                            <label class="form-check-label" for="credit_card">
                                                <i class="bi bi-credit-card me-2"></i>Carta di credito
                                            </label>
                                        </div>

                                        <div id="credit_card_details">
                                            <div class="mb-3">
                                                <label for="card_name" class="form-label">Nome sulla carta</label>
                                                <input type="text" class="form-control" id="card_name" name="card_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="card_number" class="form-label">Numero carta</label>
                                                <input type="text" class="form-control" id="card_number" name="card_number"
                                                       placeholder="XXXX XXXX XXXX XXXX" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="expiry" class="form-label">Data di scadenza</label>
                                                    <input type="text" class="form-control" id="expiry" name="expiry"
                                                           placeholder="MM/AA" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="cvv" class="form-label">CVV</label>
                                                    <input type="text" class="form-control" id="cvv" name="cvv"
                                                           placeholder="123" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pulsanti -->
                                        <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="bi bi-lock-fill me-2"></i>Completa l'acquisto
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Informazioni sulla sicurezza -->
                            <div class="card mt-3 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-shield-lock text-success me-2 fs-4"></i>
                                        <h6 class="mb-0">Pagamento sicuro</h6>
                                    </div>
                                    <p class="small text-muted mb-0">
                                        Le tue informazioni di pagamento sono protette con la crittografia SSL.
                                        Non salviamo i dettagli della tua carta di credito.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require 'App/View/component/footer.php'; ?>