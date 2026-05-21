<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");

// Recuperiamo la rotta dall'URL
$percorso = $_SERVER['PATH_INFO'] ?? '';
if (empty($percorso)) {
    $percorso = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
}
$percorso = explode('?', $percorso)[0];

// 1. GESTIONE ROUTING
switch ($percorso) {
    case '/login':
        // La rotta di login è PUBBLICA (non richiede token)
        require 'api_utenti.php';
        break;

    case '/libri':
        // La rotta dei libri è PROTETTA (richiede token valido)
        $headers = getallheaders();
        $auth_header = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        // Il token valido che il microservizio utenti genera è "Bearer token-segreto-5A"
        if ($auth_header !== "Bearer token-segreto-5A") {
            http_response_code(401); // Unauthorized
            echo json_encode(["errore" => "Accesso negato dal Gateway. Token non valido o utente non autenticato."]);
            exit;
        }

        // Se il token è corretto, includiamo il servizio libri
        require 'api_libri.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(["errore" => "Rotta sconosciuta all'API Gateway."]);
        break;
}
?>

// Comando da terminale per avviare l'infrastruttura (BE + FE):
// php -S localhost:8000

// Link per aprire l'interfaccia utente (Frontend SPA):
// http://localhost:8000/index.html

// URL PUBBLICO (Gateway -> Microservizio Utenti):
// Richiesta di tipo POST per inviare le credenziali JSON ed ottenere il token
// http://localhost:8000/gateway.php/login

// URL PROTETTI (Gateway -> Microservizio Libri):
// Richieste di tipo GET che richiedono l'header "Authorization: Bearer token-segreto-5A"
// http://localhost:8000/gateway.php/libri