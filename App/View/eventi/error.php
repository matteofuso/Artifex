<?php /**
 * @var string $path
 */?>
<?php require 'App/View/component/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-exclamation-circle-fill text-danger" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="card-title mb-3">Visita non trovata</h2>
                    <p class="card-text lead mb-4">
                        Ci dispiace, la visita o l'evento che stai cercando non è disponibile o potrebbe essere stato rimosso.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="<?= $path ?>eventi" class="btn btn-primary">
                            <i class="bi bi-calendar-event me-2"></i>Esplora altri eventi
                        </a>
                        <a href="<?= $path ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i>Torna alla home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'App/View/component/footer.php'; ?>