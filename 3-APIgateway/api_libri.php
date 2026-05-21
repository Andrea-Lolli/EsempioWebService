<?php
// Questo file non ha bisogno di header di sicurezza, è protetto dal Gateway
$libri = [
    ["id" => 1, "titolo" => "Il Conte di Montecristo", "autore" => "Alexandre Dumas"],
    ["id" => 2, "titolo" => "1984", "autore" => "George Orwell"]
];

echo json_encode([
    "servizio_origine" => "Microservizio Libri (Protetto)",
    "data" => $libri
]);
exit;
?>