<?php /**
* @var string $path
 */?>
<?php $main_classes = ''; require 'App/View/component/header.php'; ?>

<!-- Hero Section -->
<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="display-4 fw-bold">Artifex</h1>
                <p class="lead">Servizi turistici e visite guidate di eccellenza</p>
            </div>
        </div>
    </div>
</div>
<div class="container my-4">
    <!-- Servizi Section -->
    <div class="container mb-5">
        <h2 class="text-center mb-4">I Nostri Servizi</h2>

        <div class="row g-4">
            <!-- Servizio 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-monument fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Visite Guidate Storiche</h3>
                        <p class="card-text">Organizziamo visite guidate professionali ai più importanti siti storico-culturali italiani, con guide esperte che illustrano ogni dettaglio dei percorsi proposti.</p>
                    </div>
                </div>
            </div>

            <!-- Servizio 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-language fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Guide Multilingue</h3>
                        <p class="card-text">Il nostro team di guide qualificate offre visite in diverse lingue, con livelli di competenza che vanno dal normale al madrelingua, per soddisfare le esigenze di ogni visitatore.</p>
                    </div>
                </div>
            </div>

            <!-- Servizio 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Gruppi Organizzati</h3>
                        <p class="card-text">Organizziamo visite per gruppi con un numero minimo e massimo di partecipanti predefinito, garantendo un'esperienza ottimale per tutti i visitatori.</p>
                    </div>
                </div>
            </div>

            <!-- Servizio 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-calendar-alt fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Eventi Programmati</h3>
                        <p class="card-text">Offriamo un calendario di eventi programmati con orari di inizio specifici. Consulta il nostro programma per trovare l'evento più adatto alle tue esigenze.</p>
                    </div>
                </div>
            </div>

            <!-- Servizio 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Prenotazione Online</h3>
                        <p class="card-text">Sistema di prenotazione semplice e intuitivo con funzionalità carrello che permette di prenotare più eventi e completare il pagamento in un'unica soluzione.</p>
                    </div>
                </div>
            </div>

            <!-- Servizio 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-ticket-alt fa-3x text-primary"></i>
                        </div>
                        <h3 class="card-title">Pacchetti Personalizzati</h3>
                        <p class="card-text">Possibilità di creare pacchetti turistici personalizzati in base alle preferenze dei visitatori. Contattaci per maggiori informazioni.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-body-tertiary py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2>Pronto a Scoprire la Nostra Offerta?</h2>
                    <p class="lead mb-4">Registrati sul nostro sito per visualizzare tutte le visite disponibili e prenotare il tuo prossimo evento culturale.</p>
                    <a href="<?= $path ?>account/register" class="btn btn-primary me-2">Registrati</a>
                    <a href="<?= $path ?>eventi" class="btn btn-outline-primary">Esplora il Catalogo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'App/View/component/footer.php'; ?>
