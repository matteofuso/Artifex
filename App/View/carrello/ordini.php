<?php
/**
 * @var array $ordini
 * @var string $path
 */
?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fw-bold">I Tuoi Ordini</h1>
                    <a href="<?= $path ?>eventi" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-plus-lg me-2"></i>Nuova Prenotazione
                    </a>
                </div>

                <?php if (empty($ordini)): ?>
                    <div class="text-center py-5">
                        <div class="display-1 text-muted mb-4">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h3 class="fw-light">Non hai ancora effettuato ordini</h3>
                        <p class="text-muted mb-4">Esplora i nostri eventi e prenota la tua prossima esperienza!</p>
                        <a href="<?= $path ?>eventi" class="btn btn-outline-primary rounded-pill px-4 py-2">
                            Scopri gli eventi disponibili
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Ordini Cards -->
                    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
                        <?php foreach ($ordini as $ordine):
                            $evento = $ordine->getEvento();
                            $visita = $evento->getVisita();
                            $isPast = $evento->getInizio() < new DateTime();
                            $orderClass = $isPast ? 'past-event' : 'upcoming-event';
                            $quantita = $ordine->getQuantita() ?? 1; // Default to 1 if not set
                            $totalPrice = $evento->getPrezzo() * $quantita;
                            ?>
                            <div class="col filter-item <?= $orderClass ?>">
                                <div class="card h-100 border-0 shadow-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 pt-3 pb-0">
                                        <span class="text-muted small">Ordine #<?= str_pad($ordine->getId(), 5, '0', STR_PAD_LEFT) ?></span>
                                        <span class="badge rounded-pill <?= $isPast ? 'bg-secondary bg-opacity-10 text-secondary' : 'bg-success bg-opacity-10 text-success' ?>">
                                            <?= $isPast ? 'Completato' : 'In programma' ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($visita->getTitolo()) ?></h5>

                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-calendar-event me-2 text-primary"></i>
                                                <span><?= $evento->getInizio()->format('d/m/Y') ?></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-clock me-2 text-primary"></i>
                                                <span><?= $evento->getInizio()->format('H:i') ?> - Durata: <?= $visita->getDurataMedia() ?> min</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-tag me-2 text-primary"></i>
                                                <span>&euro;<?= number_format($evento->getPrezzo(), 2, ',', '.') ?> × <?= $quantita ?></span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-cash-stack me-2 text-primary"></i>
                                                <span><strong>Totale: &euro;<?= number_format($totalPrice, 2, ',', '.') ?></strong></span>
                                            </div>
                                        </div>

                                        <p class="card-text small text-muted mb-0">
                                            Ordine effettuato il <?= $ordine->getData()->format('d/m/Y') ?> alle <?= $ordine->getData()->format('H:i') ?>
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-end gap-2">
                                        <a href="<?= $path ?>evento/<?= $ordine->getIdEvento() ?>/dettagli" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i>Dettagli
                                        </a>
                                        <?php if (!$isPast): ?>
                                            <button class="btn btn-sm btn-primary rounded-pill px-3" onclick="alert('//todo')">
                                                <i class="bi bi-ticket-perforated me-1"></i>Bigliett<?= $quantita > 1 ? 'i' : 'o' ?>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- FAQ sugli ordini con stile alternativo -->
                    <div class="mt-5">
                        <h4 class="fw-bold mb-4">Domande frequenti</h4>

                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm p-2">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                                                <i class="bi bi-ticket text-primary"></i>
                                            </div>
                                            <h5 class="card-title mb-0">Visualizzare il biglietto</h5>
                                        </div>
                                        <p class="card-text">
                                            Puoi visualizzare il tuo biglietto cliccando sul pulsante "Biglietto" accanto all'ordine.
                                            Puoi stamparlo o mostrarlo direttamente dal tuo smartphone il giorno dell'evento.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm p-2">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                                                <i class="bi bi-arrow-return-left text-primary"></i>
                                            </div>
                                            <h5 class="card-title mb-0">Rimborsi</h5>
                                        </div>
                                        <p class="card-text">
                                            I rimborsi sono possibili fino a 48 ore prima dell'inizio dell'evento.
                                            Contatta il nostro servizio clienti per assistenza nella procedura di rimborso.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm p-2">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px">
                                                <i class="bi bi-people text-primary"></i>
                                            </div>
                                            <h5 class="card-title mb-0">Trasferire il biglietto</h5>
                                        </div>
                                        <p class="card-text">
                                            È possibile trasferire il biglietto a un'altra persona. Contatta il nostro servizio clienti
                                            con i dettagli della persona almeno 24 ore prima dell'evento.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require 'App/View/component/footer.php'; ?>