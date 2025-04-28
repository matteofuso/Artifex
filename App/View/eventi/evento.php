<?php
/**
 * @var Evento $evento
 * @var SitoInteresse[] $siti
 * @var Illustrazione $illustrazione
 * @var string $path
 */

use App\Model\Evento;
use App\Model\SitoInteresse;
use App\Model\Illustrazione;

?>
<?php require 'App/View/component/header.php'; ?>

    <!-- Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4"><?= htmlspecialchars($evento->getVisita()->getTitolo()) ?? '' ?></h1>
            <hr>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - Event Details -->
        <div class="col-md-8">
            <div class="mb-5">
                <h3 class="mb-4">Descrizione</h3>
                <p class="lead"><?= htmlspecialchars($evento->getVisita()->getDescrizione()) ?></p>
            </div>

            <!-- Event Information Table -->
            <div class="mb-5">
                <h3 class="mb-4">Informazioni</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th scope="row" width="30%">Data e Ora</th>
                            <td><?= $evento->getInizio()->format('d/m/Y H:i') ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Durata Media</th>
                            <td><?= $evento->getVisita()->getDurataMedia() ?> minuti</td>
                        </tr>
                        <tr>
                            <th scope="row">Prezzo</th>
                            <td><?= number_format($evento->getPrezzo(), 2, ',', '.') ?> €</td>
                        </tr>
                        <tr>
                            <th scope="row">Partecipanti</th>
                            <td>Min: <?= $evento->getMinimoPartecipanti() ?> /
                                Max: <?= $evento->getMassimoPartecipanti() ?></td>
                        </tr>
                        <?php if ($illustrazione && $illustrazione->getGuida()): ?>
                            <tr>
                                <th scope="row">Guida</th>
                                <td>
                                    <?= htmlspecialchars($illustrazione->getGuida()->getNome() . ' ' . $illustrazione->getGuida()->getCognome()) ?>
                                    <?php if ($illustrazione->getGuida()->getTitoloStudio()): ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary ms-2">
                                    <?= htmlspecialchars($illustrazione->getGuida()->getTitoloStudio()->getNome()) ?>
                                </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($illustrazione && $illustrazione->getLingua()): ?>
                            <tr>
                                <th scope="row">Lingua</th>
                                <td>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <?= htmlspecialchars($illustrazione->getLingua()->getLingua()) ?>
                                </span>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Guide Information Section -->
            <?php if ($illustrazione && $illustrazione->getGuida()): ?>
                <div class="mb-5">
                    <h3 class="mb-4">La tua guida</h3>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px">
                                    <i class="bi bi-person-badge fs-3 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">
                                        <?= htmlspecialchars($illustrazione->getGuida()->getNome() . ' ' . $illustrazione->getGuida()->getCognome()) ?>
                                    </h5>
                                    <?php if ($illustrazione->getGuida()->getTitoloStudio()): ?>
                                        <p class="text-muted mb-0">
                                            <?= htmlspecialchars($illustrazione->getGuida()->getTitoloStudio()->getNome()) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="bi bi-geo-alt text-primary me-2"></i> Nato a <?= htmlspecialchars($illustrazione->getGuida()->getLuogoNascita()) ?></p>
                                    <?php if ($illustrazione->getGuida()->getDataNascita()): ?>
                                        <p class="mb-0"><i class="bi bi-calendar text-primary me-2"></i>
                                            <?= $illustrazione->getGuida()->getDataNascita()->format('d/m/Y') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="bi bi-translate text-primary me-2"></i> Parla
                                        <span class="fw-bold"><?= htmlspecialchars($illustrazione->getLingua()->getLingua()) ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sites of Interest Section -->
            <?php if (!empty($siti)): ?>
                <div class="mb-5">
                    <h3 class="mb-4">Punti di interesse</h3>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <?php foreach ($siti as $sito): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($sito->getNome()) ?></h5>
                                        <p class="card-text text-muted"><i
                                                    class="bi bi-geo-alt"></i> <?= htmlspecialchars($sito->getLuogo()) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column - Booking and Action Buttons -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Prenotazione</h4>
                </div>
                <form action="<?=$path;?>action/add_cart" method="post" class="card-body text-center">
                    <h5 class="card-title mb-4">Prezzo per persona</h5>
                    <p class="display-6 mb-4"><?= number_format($evento->getPrezzo(), 2, ',', '.') ?> €</p>

                    <!-- Quantity selector -->
                    <div class="mb-4">
                        <label for="quantita" class="form-label">Quantità</label>
                        <div class="input-group mb-3" style="max-width: 150px; margin: 0 auto;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" class="form-control text-center" id="quantita" name="quantita" value="1" min="1" max="<?= $evento->getMassimoPartecipanti() ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= $evento->getId() ?>">
                    <button class="btn btn-primary btn-lg w-100">Prenota Ora</button>
                </form>
            </div>

            <?php if ($illustrazione && $illustrazione->getLingua()): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px">
                                <i class="bi bi-translate fs-4 text-info"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Lingua dell'evento</h5>
                                <p class="mb-0">Questo tour è disponibile in <strong><?= htmlspecialchars($illustrazione->getLingua()->getLingua()) ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function incrementQuantity() {
            const input = document.getElementById('quantita');
            const max = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantita');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>

<?php require 'App/View/component/footer.php'; ?>