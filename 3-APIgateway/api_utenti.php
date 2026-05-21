<?php
// Gestiamo solo le richieste di tipo POST per il login (scambio sicuro di credenziali)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Leggiamo i dati inviati dal frontend in formato JSON
    $dati_ricevuti = json_decode(file_get_contents("php://input"), true);
    
    $username = $dati_ricevuti['username'] ?? '';
    $password = $dati_ricevuti['password'] ?? '';

    // Credenziali hardcoded per il test
    if ($username === "admin" && $password === "password123") {
        http_response_code(200);
        echo json_encode([
            "messaggio" => "Login effettuato con successo!",
            "token" => "token-segreto-5A", // Il token simulato che il frontend dovrà conservare
            "utente" => [
                "username" => "admin",
                "ruolo" => "Amministratore"
            ]
        ]);
    } else {
        http_response_code(401); // Unauthorized
        echo json_encode(["errore" => "Credenziali errate. Riprova."]);
    }
    exit;
}

http_response_code(405); // Method Not Allowed
echo json_encode(["errore" => "Metodo non consentito. Usa POST per il login."]);
exit;
?>