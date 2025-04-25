<?php
/**
 * @var Evento $evento
 * @var SitoInteresse[] $siti
 * @var string $path
 */

use App\Model\Evento;
use App\Model\SitoInteresse;

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
                        </tbody>
                    </table>
                </div>
            </div>

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
            <div class="card shadow mb-4 ms-5">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Prenotazione</h4>
                </div>
                <form action="<?=$path;?>action/add_cart" method="post" class="card-body text-center">
                    <h5 class="card-title mb-4">Prezzo per persona</h5>
                    <p class="display-6 mb-4"><?= number_format($evento->getPrezzo(), 2, ',', '.') ?> €</p>
                    <input type="hidden" name="id" value="<?= $evento->getId() ?>">
                    <button class="btn btn-primary btn-lg w-100">Prenota Ora</button>
                </form>
            </div>
        </div>
    </div>

<?php require 'App/View/component/footer.php'; ?>