<?php

namespace Config;

class Codes
{
    public static array $errors = [
        '-1' => 'Errore generico',
        '0' => 'Impossibile connettersi al database',
        '1' => 'Errore nella richiesta',
        '2' => 'Password errata o account non esistente',
        '3' => 'Le password non corrispondono',
        '4' => 'Email già in uso',
        '5' => 'Non sei autenticato',
        '6' => 'Le password non coincidono',
    ];

    public static array $successes = [
        '-1' => 'Operazione completata con successo',
    ];
}