<?php
use App\Model\Guida;
use App\Model\TitoloStudio;
/**
 * @var string $path
 * @var array $guide
 * @var array $titoliStudio
 */?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Gestione Guide</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGuidaModal">
                        <i class="bi bi-plus-lg"></i> Nuova Guida
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabella Guide -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-body-tertiary">
                <h5 class="card-title mb-0">Guide Registrate</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Cognome</th>
                            <th scope="col">Luogo di Nascita</th>
                            <th scope="col">Data di Nascita</th>
                            <th scope="col">Titolo di Studio</th>
                            <th scope="col">Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (empty($guide)) {
                            echo '<tr><td colspan="7" class="text-center">Nessuna guida disponibile</td></tr>';
                        } else {
                            foreach ($guide as $guida) {
                                ?>
                                <tr>
                                    <th scope="row"><?= $guida->getId() ?></th>
                                    <td><?= htmlspecialchars($guida->getNome()) ?></td>
                                    <td><?= htmlspecialchars($guida->getCognome()) ?></td>
                                    <td><?= htmlspecialchars($guida->getLuogoNascita()) ?></td>
                                    <td><?= $guida->getDataNascita()->format('d/m/Y') ?></td>
                                    <td><?= htmlspecialchars($guida->getTitoloStudio()->getNome()) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary edit-guida-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editGuidaModal"
                                                    data-id="<?= $guida->getId() ?>"
                                                    data-nome="<?= htmlspecialchars($guida->getNome()) ?>"
                                                    data-cognome="<?= htmlspecialchars($guida->getCognome()) ?>"
                                                    data-luogo="<?= htmlspecialchars($guida->getLuogoNascita()) ?>"
                                                    data-data="<?= $guida->getDataNascita()->format('Y-m-d') ?>"
                                                    data-titolo="<?= $guida->getTitoloStudio()->getId() ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteGuidaModal"
                                                    data-id="<?= $guida->getId() ?>"
                                                    data-nome="<?= htmlspecialchars($guida->getNome()) ?> <?= htmlspecialchars($guida->getCognome()) ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Creazione Guida -->
    <div class="modal fade" id="createGuidaModal" tabindex="-1" aria-labelledby="createGuidaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createGuidaModalLabel">Nuova Guida</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= $path ?>admin/guida/create" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cognome" class="form-label">Cognome</label>
                                <input type="text" class="form-control" id="cognome" name="cognome" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="luogo_nascita" class="form-label">Luogo di Nascita</label>
                                <input type="text" class="form-control" id="luogo_nascita" name="luogo_nascita" required>
                            </div>
                            <div class="col-md-6">
                                <label for="data_nascita" class="form-label">Data di Nascita</label>
                                <input type="date" class="form-control" id="data_nascita" name="data_nascita" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="titolo_studio" class="form-label">Titolo di Studio</label>
                            <select class="form-select" id="titolo_studio" name="titolo_studio" required>
                                <option value="" selected disabled>Seleziona un titolo di studio</option>
                                <?php foreach ($titoliStudio as $titolo) { ?>
                                    <option value="<?= $titolo->getId() ?>"><?= htmlspecialchars($titolo->getNome()) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modifica Guida -->
    <div class="modal fade" id="editGuidaModal" tabindex="-1" aria-labelledby="editGuidaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editGuidaModalLabel">Modifica Guida</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editGuidaForm" action="<?= $path ?>admin/guida/update" method="post">
                    <input type="hidden" id="edit_guide_id" name="id" value="">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="edit_nome" name="nome" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_cognome" class="form-label">Cognome</label>
                                <input type="text" class="form-control" id="edit_cognome" name="cognome" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_luogo_nascita" class="form-label">Luogo di Nascita</label>
                                <input type="text" class="form-control" id="edit_luogo_nascita" name="luogo_nascita" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_data_nascita" class="form-label">Data di Nascita</label>
                                <input type="date" class="form-control" id="edit_data_nascita" name="data_nascita" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_titolo_studio" class="form-label">Titolo di Studio</label>
                            <select class="form-select" id="edit_titolo_studio" name="titolo_studio" required>
                                <option value="" disabled>Seleziona un titolo di studio</option>
                                <?php foreach ($titoliStudio as $titolo) { ?>
                                    <option value="<?= $titolo->getId() ?>"><?= htmlspecialchars($titolo->getNome()) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-primary">Aggiorna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminazione Guida -->
    <div class="modal fade" id="deleteGuidaModal" tabindex="-1" aria-labelledby="deleteGuidaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteGuidaModalLabel">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Sei sicuro di voler eliminare la guida <span id="delete_guida_nome" class="fw-bold"></span>?</p>
                    <p>Questa azione non può essere annullata.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form id="deleteGuidaForm" action="<?= $path ?>admin/guida/delete" method="post">
                        <input type="hidden" id="delete_visit_id" name="id" value="">
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurazione modal modifica guida
            const editGuidaModal = document.getElementById('editGuidaModal');
            editGuidaModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const guidaId = button.getAttribute('data-id');
                const nome = button.getAttribute('data-nome');
                const cognome = button.getAttribute('data-cognome');
                const luogo = button.getAttribute('data-luogo');
                const data = button.getAttribute('data-data');
                const titolo = button.getAttribute('data-titolo');

                // Precompila i campi del form
                document.getElementById('edit_nome').value = nome;
                document.getElementById('edit_cognome').value = cognome;
                document.getElementById('edit_luogo_nascita').value = luogo;
                document.getElementById('edit_data_nascita').value = data;
                document.getElementById('edit_titolo_studio').value = titolo;
                document.getElementById('edit_guide_id').value = guidaId;
            });

            // Configurazione modal eliminazione guida
            const deleteGuidaModal = document.getElementById('deleteGuidaModal');
            deleteGuidaModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const guidaId = button.getAttribute('data-id');
                const guidaNome = button.getAttribute('data-nome');

                // Imposta l'azione del form e il nome della guida
                document.getElementById('delete_guida_nome').textContent = guidaNome;
                document.getElementById('delete_visit_id').value = guidaId;
            });
        });
    </script>

<?php require 'App/View/component/footer.php'; ?>