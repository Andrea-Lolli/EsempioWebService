<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Simula Database statico
$libri = [
    ["id" => 1, "titolo" => "Il Conte di Montecristo", "autore" => "Alexandre Dumas", "anno" => 1844],
    ["id" => 2, "titolo" => "1984", "autore" => "George Orwell", "anno" => 1949],
    ["id" => 3, "titolo" => "Il problema dei tre corpi", "autore" => "Cixin Liu", "anno" => 2008],
    ["id" => 4, "titolo" => "Project Hail Mary", "autore" => "Andy Weir", "anno" => 2021]
];

// Leggiamo la parte finale dell'URL (es: /api.php/tutti -> /tutti)
// Se l'URL è solo api.php, impostiamo di default '/tutti'
$percorso = $_SERVER['PATH_INFO'] ?? '/tutti';

switch($percorso) {
    case '/tutti':
        // Metodo: Ritorna tutto il catalogo
        echo json_encode($libri);
        break;

    case '/recenti':
        // Metodo: Filtra i libri pubblicati dal 2000 in poi
        $filtrati = array_values(array_filter($libri, function($l) {
            return $l['anno'] >= 2000;
        }));
        echo json_encode($filtrati);
        break;

    default:
        http_response_code(404);
        echo json_encode(["errore" => "Rotta non trovata"]);
        break;
}

// comando da terminale per eseguire il BE:
// php -S localhost:8000

// Nuovi URL per vedere le risposte del BE basati sul routing:
// http://localhost:8000/api.php/tutti
// http://localhost:8000/api.php/recenti
?>