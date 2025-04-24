<?php /**
 * @var string $path
 * @var array $user
 * @var array $lingue
 */?>
<?php require 'App/View/component/header.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Il Tuo Account</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="accountTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#info" type="button" role="tab" aria-controls="info"
                                        aria-selected="true">
                                    <i class="bi bi-info-circle me-1"></i>Informazioni
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit"
                                        type="button" role="tab" aria-controls="edit" aria-selected="false">
                                    <i class="bi bi-pencil-square me-1"></i>Modifica
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content p-3 border border-top-0 rounded-bottom" id="accountTabsContent">
                            <!-- Tab Visualizzazione Informazioni -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-hover">
                                            <tr>
                                                <th width="30%"><i class="bi bi-person me-2"></i>Nome:</th>
                                                <td><?= $user->getNome() ?? '' ?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="bi bi-person me-2"></i>Cognome:</th>
                                                <td><?= $user->getCognome() ?? '' ?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="bi bi-envelope me-2"></i>Email:</th>
                                                <td><?= $user->getEmail() ?? '' ?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="bi bi-telephone me-2"></i>Telefono:</th>
                                                <td><?= $user->getTelefono() ?? '' ?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="bi bi-translate me-2"></i>Lingua:</th>
                                                <td><?= $user->getLingua()->getLingua() ?? '' ?></td>
                                            </tr>
                                            <tr>
                                                <th><i class="bi bi-briefcase me-2"></i>Ruolo:</th>
                                                <td><?= $user->getTipologia()->getTipologia() ?? '' ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="p-3 border rounded">
                                            <i class="bi bi-person-circle text-primary" style="font-size: 6rem;"></i>
                                            <h4 class="mt-2"><?= $user->getNome() ?? '' . ' ' . $user->getCognome() ?? '' ?></h4>
                                            <p class="badge bg-info"><?= $user->getTipologia()->getTipologia() ?? '' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Modifica Informazioni -->
                            <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                <form method="POST" action="<?= $path ?>action/update_account">
                                    <input type="hidden" name="id" value="<?= $user->getId() ?? '' ?>">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="nome" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                   value="<?= $user->getNome() ?? '' ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cognome" class="form-label">Cognome</label>
                                            <input type="text" class="form-control" id="cognome" name="cognome"
                                                   value="<?= $user->getCognome() ?? '' ?>" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="<?= $user->getEmail() ?? '' ?>" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="telefono" class="form-label">Telefono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                   value="<?= $user->getTelefono() ?? '' ?>" placeholder="+39 333 333 3333">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lingua" class="form-label">Lingua preferita</label>
                                            <select class="form-select" id="lingua" name="lingua">
                                                <option value="">Seleziona una lingua</option>
                                                <?php
                                                foreach ($lingue as $l) {
                                                    $selected = $user->getLingua()->getId() == $l->getId() ? 'selected' : '';
                                                    ?>
                                                    <option value="<?= $l->getId() ?>" <?= $selected ?>><?= $l->getLingua() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ruolo" class="form-label">Ruolo</label>
                                        <input type="text" class="form-control" id="ruolo"
                                               value="<?= $user->getTipologia()->getTipologia() ?? '' ?>"
                                               readonly>
                                        <small class="form-text text-muted">Il ruolo può essere modificato solo
                                            dall'amministratore.</small>
                                    </div>

                                    <hr>
                                    <h5><i class="bi bi-key me-2"></i>Modifica Password</h5>
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Attuale</label>
                                        <input type="password" class="form-control" id="current_password"
                                               name="current_password">
                                        <small class="form-text text-muted">Lascia vuoto se non vuoi cambiare la
                                            password.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nuova Password</label>
                                        <input type="password" class="form-control" id="new_password"
                                               name="new_password">
                                        <small class="form-text text-muted">La password deve contenere almeno 8
                                            caratteri, di cui almeno un numero, una lettera maiuscola, una minuscola e
                                            un carattere speciale.</small>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Conferma Nuova Password</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                               name="confirm_password">
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i>Salva Modifiche
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require 'App/View/component/footer.php'; ?>