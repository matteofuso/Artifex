<?php
use App\Model\Visita;
use App\Model\Evento;
/**
 * @var string $path
 * @var array $eventi
 * @var array $visite
 */?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Gestione Eventi</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
                        <i class="bi bi-plus-lg"></i> Nuovo Evento
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabella Eventi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-body-tertiary">
                <h5 class="card-title mb-0">Eventi Programmati</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Data e Ora</th>
                            <th scope="col">Visita</th>
                            <th scope="col">Partecipanti Min-Max</th>
                            <th scope="col">Prezzo</th>
                            <th scope="col">Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (empty($eventi)) {
                            echo '<tr><td colspan="6" class="text-center">Nessun evento disponibile</td></tr>';
                        } else {
                            foreach ($eventi as $evento) {
                                ?>
                                <tr>
                                    <th scope="row"><?= $evento->getId() ?></th>
                                    <td><?= $evento->getInizio()->format('d/m/Y H:i') ?></td>
                                    <td><?= htmlspecialchars($evento->getVisita()->getTitolo()) ?></td>
                                    <td><?= $evento->getMinimoPartecipanti() ?> - <?= $evento->getMassimoPartecipanti() ?></td>
                                    <td><?= number_format($evento->getPrezzo(), 2, ',', '.') ?> €</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= $path ?>/evento/<?= $evento->getId() ?>/dettagli" class="btn btn-outline-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-primary edit-event-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editEventModal"
                                                    data-id="<?= $evento->getId() ?>"
                                                    data-inizio="<?= $evento->getInizio()->format('Y-m-d\TH:i') ?>"
                                                    data-visita="<?= $evento->getVisita()->getId() ?>"
                                                    data-min="<?= $evento->getMinimoPartecipanti() ?>"
                                                    data-max="<?= $evento->getMassimoPartecipanti() ?>"
                                                    data-prezzo="<?= $evento->getPrezzo() ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteEventModal"
                                                    data-id="<?= $evento->getId() ?>">
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

        <!-- Sezione Visite -->
        <div class="row mt-5 mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Gestione Visite</h2>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createVisitModal">
                        <i class="bi bi-plus-lg"></i> Nuova Visita
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            if (empty($visite)) {
                echo '<div class="col-12"><div class="alert alert-info">Nessuna visita disponibile</div></div>';
            } else {
                foreach ($visite as $visita) {
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($visita->getTitolo()) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Durata: <?= $visita->getDurataMedia() ?> minuti</h6>
                                <p class="card-text"><?= htmlspecialchars($visita->getDescrizione()) ?></p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary edit-visit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editVisitModal"
                                            data-id="<?= $visita->getId() ?>"
                                            data-titolo="<?= htmlspecialchars($visita->getTitolo()) ?>"
                                            data-descrizione="<?= htmlspecialchars($visita->getDescrizione()) ?>"
                                            data-durata="<?= $visita->getDurataMedia() ?>">
                                        <i class="bi bi-pencil"></i> Modifica
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteVisitModal"
                                            data-id="<?= $visita->getId() ?>">
                                        <i class="bi bi-trash"></i> Elimina
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Modal Creazione Evento -->
    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createEventModalLabel">Nuovo Evento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= $path ?>admin/evento/create" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="inizio" class="form-label">Data e Ora</label>
                                <input type="datetime-local" class="form-control" id="inizio" name="inizio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_visita" class="form-label">Visita</label>
                                <select class="form-select" id="id_visita" name="id_visita" required>
                                    <option value="" selected disabled>Seleziona una visita</option>
                                    <?php foreach ($visite as $visita) { ?>
                                        <option value="<?= $visita->getId() ?>"><?= htmlspecialchars($visita->getTitolo()) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="minimo_partecipanti" class="form-label">Minimo Partecipanti</label>
                                <input type="number" class="form-control" id="minimo_partecipanti" name="minimo_partecipanti" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="massimo_partecipanti" class="form-label">Massimo Partecipanti</label>
                                <input type="number" class="form-control" id="massimo_partecipanti" name="massimo_partecipanti" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="prezzo" class="form-label">Prezzo (€)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="prezzo" name="prezzo" min="0" step="0.01" required>
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
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

    <!-- Modal Modifica Evento -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">Modifica Evento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEventForm" action="<?= $path ?>admin/evento/update" method="post">
                    <!-- Hidden input for event ID -->
                    <input type="hidden" id="edit_event_id" name="id" value="">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_inizio" class="form-label">Data e Ora</label>
                                <input type="datetime-local" class="form-control" id="edit_inizio" name="inizio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_id_visita" class="form-label">Visita</label>
                                <select class="form-select" id="edit_id_visita" name="id_visita" required>
                                    <option value="" disabled>Seleziona una visita</option>
                                    <?php foreach ($visite as $visita) { ?>
                                        <option value="<?= $visita->getId() ?>"><?= htmlspecialchars($visita->getTitolo()) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="edit_minimo_partecipanti" class="form-label">Minimo Partecipanti</label>
                                <input type="number" class="form-control" id="edit_minimo_partecipanti" name="minimo_partecipanti" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="edit_massimo_partecipanti" class="form-label">Massimo Partecipanti</label>
                                <input type="number" class="form-control" id="edit_massimo_partecipanti" name="massimo_partecipanti" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="edit_prezzo" class="form-label">Prezzo (€)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="edit_prezzo" name="prezzo" min="0" step="0.01" required>
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
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

    <!-- Modal Creazione Visita -->
    <div class="modal fade" id="createVisitModal" tabindex="-1" aria-labelledby="createVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="createVisitModalLabel">Nuova Visita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= $path ?>admin/visita/create" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titolo" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="titolo" name="titolo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descrizione" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="descrizione" name="descrizione" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="durata_media" class="form-label">Durata Media (minuti)</label>
                            <input type="number" class="form-control" id="durata_media" name="durata_media" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-success">Salva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modifica Visita -->
    <div class="modal fade" id="editVisitModal" tabindex="-1" aria-labelledby="editVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editVisitModalLabel">Modifica Visita</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editVisitForm" action="<?= $path ?>admin/visita/update" method="post">
                    <!-- Hidden input for visit ID -->
                    <input type="hidden" id="edit_visit_id" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_titolo" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="edit_titolo" name="titolo" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_descrizione" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="edit_descrizione" name="descrizione" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_durata_media" class="form-label">Durata Media (minuti)</label>
                            <input type="number" class="form-control" id="edit_durata_media" name="durata_media" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-success">Aggiorna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Eliminazione Evento -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteEventModalLabel">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Sei sicuro di voler eliminare questo evento? Questa azione non può essere annullata.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form id="deleteEventForm" action="<?= $path ?>admin/evento/delete" method="post">
                        <!-- Hidden input for event ID -->
                        <input type="hidden" id="delete_event_id" name="id" value="">
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminazione Visita -->
    <div class="modal fade" id="deleteVisitModal" tabindex="-1" aria-labelledby="deleteVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteVisitModalLabel">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Sei sicuro di voler eliminare questa visita? Questa azione non può essere annullata.</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i> Attenzione: eliminare una visita comporterà l'eliminazione di tutti gli eventi associati ad essa.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form id="deleteVisitForm" action="<?= $path ?>admin/visita/delete" method="post">
                        <!-- Hidden input for visit ID -->
                        <input type="hidden" id="delete_visit_id" name="id" value="">
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configurazione modal eliminazione evento
            const deleteEventModal = document.getElementById('deleteEventModal');
            deleteEventModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const eventId = button.getAttribute('data-id');
                // Imposta l'ID dell'evento nel campo nascosto
                document.getElementById('delete_event_id').value = eventId;
            });

            // Configurazione modal eliminazione visita
            const deleteVisitModal = document.getElementById('deleteVisitModal');
            deleteVisitModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const visitId = button.getAttribute('data-id');
                // Imposta l'ID della visita nel campo nascosto
                document.getElementById('delete_visit_id').value = visitId;
            });

            // Configurazione modal modifica evento
            const editEventModal = document.getElementById('editEventModal');
            editEventModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const eventId = button.getAttribute('data-id');
                const inizio = button.getAttribute('data-inizio');
                const visitaId = button.getAttribute('data-visita');
                const minPart = button.getAttribute('data-min');
                const maxPart = button.getAttribute('data-max');
                const prezzo = button.getAttribute('data-prezzo');

                // Imposta l'ID dell'evento nel campo nascosto
                document.getElementById('edit_event_id').value = eventId;

                // Precompila i campi del form
                document.getElementById('edit_inizio').value = inizio;
                document.getElementById('edit_id_visita').value = visitaId;
                document.getElementById('edit_minimo_partecipanti').value = minPart;
                document.getElementById('edit_massimo_partecipanti').value = maxPart;
                document.getElementById('edit_prezzo').value = prezzo;
            });

            // Configurazione modal modifica visita
            const editVisitModal = document.getElementById('editVisitModal');
            editVisitModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const visitId = button.getAttribute('data-id');
                const titolo = button.getAttribute('data-titolo');
                const descrizione = button.getAttribute('data-descrizione');
                const durata = button.getAttribute('data-durata');

                // Imposta l'ID della visita nel campo nascosto
                document.getElementById('edit_visit_id').value = visitId;
                // Precompila i campi del form
                document.getElementById('edit_titolo').value = titolo;
                document.getElementById('edit_descrizione').value = descrizione;
                document.getElementById('edit_durata_media').value = durata;
            });
        });
    </script>

<?php require 'App/View/component/footer.php'; ?>