<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Simula un database statico più ampio (25 libri) per testare la paginazione da 10 elementi
$libri = [];
for ($i = 1; $i <= 25; $i++) {
    $libri[] = [
        "id" => $i,
        "titolo" => "Volume di Test numero " . $i,
        "autore" => "Autore Interno " . ($i % 3 + 1),
        "anno" => 1990 + $i
    ];
}

// Gestione routing nativo
$percorso = $_SERVER['PATH_INFO'] ?? '/tutti';

switch($percorso) {
    case '/tutti':
        // Parametri di paginazione con valori di default
        $pagina_corrente = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $limite = 10; // 10 libri per volta
        
        // Calcolo dell'indice di partenza (offset)
        $offset = ($pagina_corrente - 1) * $limite;
        $totale_libri = count($libri);
        $totale_pagine = ceil($totale_libri / $limite);

        // Estrazione della porzione di dati interessata
        $libri_paginati = array_slice($libri, $offset, $limite);

        // Risposta strutturata con metadati di paginazione
        // Se c'è un database questa va fatta in una query
        echo json_encode([
            "metadati" => [
                "pagina_corrente" => $pagina_corrente,
                "totale_pagine" => $totale_pagine,
                "totale_elementi" => $totale_libri,
                "limite" => $limite
            ],
            "data" => $libri_paginati
        ]);
        exit;

    case '/recenti':
        $filtrati = array_values(array_filter($libri, function($l) {
            return $l['anno'] >= 2000;
        }));
        echo json_encode($filtrati);
        exit;

    default:
        http_response_code(404);
        echo json_encode(["errore" => "Rotta non trovata"]);
        exit;
}

// Comando da terminale per avviare l'infrastruttura (BE + FE):
// php -S localhost:8000

// Link per aprire l'interfaccia utente (Frontend SPA):
// http://localhost:8000/index.html

// URL per vedere il Catalogo Paginato (Esempi con Query String):
// http://localhost:8000/api.php/tutti?pagina=1
// http://localhost:8000/api.php/tutti?pagina=2
// http://localhost:8000/api.php/tutti?pagina=3

// URL per la rotta semplice (Senza paginazione):
// http://localhost:8000/api.php/recenti
?>