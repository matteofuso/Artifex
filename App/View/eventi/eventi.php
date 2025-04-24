<?php /**
 * @var $eventi
 * @var $path
 */ ?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-3">Le nostre visite guidate</h1>
                <p class="lead text-muted">Scopri le meraviglie culturali d'Italia con le nostre guide esperte</p>
                <hr class="my-4 mx-auto" style="width: 50px; height: 3px; background-color: #0d6efd;">
            </div>
        </div>

        <?php if (empty($eventi)) : ?>
            <div class="alert alert-info text-center py-4" role="alert">
                <i class="fas fa-info-circle me-2"></i>Nessun evento disponibile al momento. Riprova più tardi.
            </div>
        <?php else : ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($eventi as $evento) : ?>
                    <div class="col">
                        <div class="card h-100 shadow hover-shadow">
                            <!-- Immagine di sfondo simulata con gradiente -->
                            <div class="bg-image"
                                 style="height: 160px; background: linear-gradient(to right, #0d6efd, #0dcaf0); position: relative;">
                                <div class="mask"
                                     style="background-color: rgba(0, 0, 0, 0.4); position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                    <div class="d-flex justify-content-end align-items-start h-100 p-3">
                                        <span class="badge bg-light text-primary fs-5 rounded-pill shadow-sm px-3 py-2">
                                            € <?= number_format($evento->getPrezzo(), 2, ',', '.') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <h4 class="card-title text-primary mb-3"><?= htmlspecialchars($evento->getVisita()->getTitolo()) ?></h4>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-center me-3 bg-body-tertiary rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 45px; height: 45px;">
                                        <i class="bi bi-calendar-date"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Data e ora</small>
                                        <strong><?= $evento->getInizio()->format('d/m/Y - H:i') ?></strong>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-center me-3 bg-body-tertiary rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 45px; height: 45px;">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Durata media</small>
                                        <strong><?= $evento->getVisita()->getDurataMedia() ?> minuti</strong>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-center me-3 bg-body-tertiary rounded-circle d-flex justify-content-center align-items-center"
                                         style="width: 45px; height: 45px;">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Partecipanti</small>
                                        <strong><?= $evento->getMinimoPartecipanti() ?>
                                            - <?= $evento->getMassimoPartecipanti() ?> persone</strong>
                                    </div>
                                </div>

                                <p class="card-text text-muted">
                                    <?= $evento->getVisita()->getDescrizione(); ?>
                                </p>
                            </div>
                            <a href="<?= $path ?>evento/<?= $evento->getId() ?>/dettagli">
                                <div class="card-footer bg-body-tertiary border-top-0 text-center p-3">
                                    <span class="btn btn-outline-primary rounded-pill px-4">Scopri di più</span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
    </style>

<?php require 'App/View/component/footer.php'; ?>