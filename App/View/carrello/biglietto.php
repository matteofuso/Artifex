<?php
/**
 * @var Ordine $ordine
 * @var User $user
 */
require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
require_once 'App/Model/Ordine.php';
require_once 'App/Model/User.php';

use App\Model\Ordine;
use App\Model\User;

// Crea un singolo PDF con più pagine per tutti i biglietti dell'ordine
try {
    // Verifica che le variabili necessarie siano definite
    if (!isset($ordine) || !isset($user)) {
        throw new Exception('Ordine o utente non definiti');
    }

    // Ottieni le informazioni necessarie
    $quantita = $ordine->getQuantita();
    $evento = $ordine->getEvento();
    $data_ordine = $ordine->getData()->format('d/m/Y H:i');
    $id_ordine = $ordine->getId();

    // Informazioni evento
    $titolo_visita = $evento->getVisita()->getTitolo();
    $descrizione_visita = $evento->getVisita()->getDescrizione();
    $durata_media = $evento->getVisita()->getDurataMedia();
    $data_evento = $evento->getInizio()->format('d/m/Y H:i');
    $prezzo = $evento->getPrezzo();

    // Informazioni cliente
    $nome_cliente = $user->getNome() . ' ' . $user->getCognome();
    $email_cliente = $user->getEmail();
    $telefono_cliente = $user->getTelefono();

    // Inizializza PDF con orientamento verticale, millimetri come unità e formato A4
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Imposta informazioni del documento
    $pdf->SetCreator('Artifex');
    $pdf->SetAuthor('Artifex');
    $pdf->SetTitle('Biglietti Ordine #' . $id_ordine);
    $pdf->SetSubject('Biglietti per ' . $titolo_visita);

    // Rimuovi header e footer di default
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Imposta margini e disabilita l'interruzione di pagina automatica
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(false);

    // Crea un biglietto per ogni quantità
    for ($i = 1; $i <= $quantita; $i++) {
        // Aggiungi una nuova pagina per ogni biglietto
        $pdf->AddPage();

        // Imposta colore di sfondo
        $pdf->SetFillColor(248, 248, 248);
        $pdf->Rect(0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'F', array(), array());

        // Header con logo e bordo decorativo
        $pdf->SetFillColor(36, 64, 98);
        $pdf->Rect(0, 0, $pdf->getPageWidth(), 25, 'F', array(), array());

        // Dati azienda in bianco sul rettangolo blu
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 22);
        $pdf->SetY(8);
        $pdf->Cell(0, 10, 'ARTIFEX', 0, 1, 'C');

        // Sottotitolo in bianco
        $pdf->SetFont('helvetica', 'I', 12);
        $pdf->SetY(16);
        $pdf->Cell(0, 6, 'Servizi turistici e visite guidate di eccellenza', 0, 1, 'C');

        // Reset colore testo
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(30);

        // Box decorativo per titolo biglietto
        $pdf->SetFillColor(244, 176, 66);
        $pdf->RoundedRect(15, 30, 180, 14, 3, '1111', 'F', array(), array());

        // Titolo biglietto
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetY(34);
        $pdf->Cell(0, 6, 'BIGLIETTO ELETTRONICO', 0, 1, 'C');

        // Reset colore testo
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetY(50);

        // Box principale con bordo e sfondo chiaro
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->RoundedRect(15, 50, 180, 120, 2, '1111', 'FD', array(), array());

        // Informazioni evento
        $pdf->SetY(55);
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(170, 10, $titolo_visita, 0, 1, 'C');

        // Descrizione evento
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->SetY(70);
        $pdf->SetX(20);
        $pdf->MultiCell(170, 6, $descrizione_visita, 0, 'L');

        // Linea divisoria
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->Line(25, $pdf->GetY() + 5, 185, $pdf->GetY() + 5);

        // Informazioni dettagliate evento
        $pdf->SetY($pdf->GetY() + 10);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->SetX(20);
        $pdf->Cell(35, 6, 'Data e ora:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $data_evento, 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Durata:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $durata_media . ' minuti', 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Prezzo:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, number_format($prezzo, 2, ',', '.') . ' €', 0, 1, 'L');

        // Linea divisoria
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->Line(25, $pdf->GetY() + 5, 185, $pdf->GetY() + 5);

        // Informazioni acquirente
        $pdf->SetY($pdf->GetY() + 10);
        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Acquirente:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $nome_cliente, 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Email:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $email_cliente, 0, 1, 'L');

        if (!empty($telefono_cliente)) {
            $pdf->SetX(20);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->SetTextColor(36, 64, 98);
            $pdf->Cell(35, 6, 'Telefono:', 0, 0, 'L');
            $pdf->SetFont('helvetica', '', 12);
            $pdf->SetTextColor(80, 80, 80);
            $pdf->Cell(0, 6, $telefono_cliente, 0, 1, 'L');
        }

        // Box per codice QR e dettagli biglietto
        $pdf->SetY(175);
        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetDrawColor(220, 220, 220);
        $pdf->RoundedRect(15, 175, 180, 75, 2, '1111', 'FD', array(), array());

        // Info biglietto a sinistra
        $pdf->SetY(180);
        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(0, 8, 'DETTAGLI BIGLIETTO', 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'N° Ordine:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $id_ordine, 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Biglietto:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $i . ' di ' . $quantita, 0, 1, 'L');

        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetTextColor(36, 64, 98);
        $pdf->Cell(35, 6, 'Acquistato:', 0, 0, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetTextColor(80, 80, 80);
        $pdf->Cell(0, 6, $data_ordine, 0, 1, 'L');

        // Crea i dati per il QR code
        $qr_data = json_encode([
            'id_ordine' => $id_ordine,
            'numero_biglietto' => $i,
            'id_evento' => $evento->getId(),
            'titolo' => $titolo_visita,
            'data_evento' => $data_evento,
            'id_utente' => $user->getId(),
            'nome_utente' => $nome_cliente,
        ]);

        // Crea QR code a destra
        $pdf->write2DBarcode($qr_data, 'QRCODE,H', 120, 185, 60, 60);

        // Footer con termini e condizioni
        $pdf->SetY(255);
        $pdf->SetFillColor(36, 64, 98);
        $pdf->Rect(0, 255, $pdf->getPageWidth(), 42, 'F', array(), array());

        $pdf->SetY(260);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, 'TERMINI E CONDIZIONI', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 8);
        $pdf->SetX(20);
        $pdf->MultiCell(170, 4,
            'Questo biglietto è valido solo per la data e l\'orario indicati. ' .
            'Si prega di presentarsi almeno 15 minuti prima dell\'inizio della visita. ' .
            'In caso di maltempo o cause di forza maggiore, l\'evento potrebbe essere riprogrammato. ' .
            'Per assistenza contattare info@artifex.it o chiamare il numero +39 0123456789.',
            0, 'C');

        $pdf->SetY(280);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, 'ARTIFEX • Via delle Guide, 123 • 00100 Roma • Tel. +39 0123456789 • www.artifex.it', 0, 1, 'C');
    }

    $pdf->Output('biglietti.pdf', 'I');
    exit;
} catch (Exception $e) {
    // Gestione errori
    echo '<div class="alert alert-danger">Errore nella generazione dei biglietti: ' . $e->getMessage() . '</div>';
}