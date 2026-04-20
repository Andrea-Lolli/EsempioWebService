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

// Leggiamo il parametro 'azione' dall'URL (es: api.php?azione=tutti)
$azione = $_GET['azione'] ?? 'tutti';

switch($azione) {
    case 'tutti':
        // Metodo: Ritorna tutto il catalogo
        echo json_encode($libri);
        break;

    case 'recenti':
        // Metodo: Filtra i libri pubblicati dal 2000 in poi
        $filtrati = array_values(array_filter($libri, function($l) {
            return $l['anno'] >= 2000;
        }));
        echo json_encode($filtrati);
        break;

    default:
        http_response_code(404);
        echo json_encode(["errore" => "Metodo non trovato"]);
        break;
}

// comando da terminale per eseguire il BE
// prima istallate php sul computer e aggiungerlo alle variabili di ambiente se non l'avete fatto
// php -S localhost:8000

// url per vedere le risposte del BE
// http://localhost:8000/api.php
// http://localhost:8000/api.php?azione=tutti
// http://localhost:8000/api.php?azione=recenti
?>

