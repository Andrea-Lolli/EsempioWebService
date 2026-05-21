# Percorso Didattico: Evoluzione dei Web Services RESTful

Questo repository contiene 3 progetti incrementali sviluppati in **PHP puro** e **JavaScript**. Il percorso è progettato per gli studenti del quinto anno ITIS Informatica come preparazione all'Esame di Stato, mostrando l'evoluzione del software da un'architettura disaccoppiata semplice fino a una struttura simulata a microservizi protetta da un API Gateway.

---

## Struttura del Repository

Il repository è diviso in tre cartelle principali, ognuna rappresentante uno step di complessità crescente:

### 1. Vecchio Servizio Web Semplice (`1-SimpleWebService`)
* **Obiettivo:** Comprendere il disaccoppiamento tra Frontend (SPA) e Backend (Controller) e l'uso del **Routing nativo** basato sui percorsi dell'URL.
* **Concetti chiave:** Chiamate asincrone `fetch()`, instradamento delle rotte (`/tutti`, `/recenti`), formato di interscambio **JSON**, gestione dei blocchi di sicurezza del browser (CORS).

### 2. Servizio Web con Paginazione (`2-Paginazione`)
* **Obiettivo:** Gestire volumi di dati più ampi ottimizzando le prestazioni del server e del canale di comunicazione.
* **Concetti chiave:** Integrazione tra rotte REST e parametri di **Query String** (`?pagina=X`), calcolo dell'offset lato backend (`array_slice`), invio di **metadati applicativi** combinati con i dati grezzi, rendering dinamico dei controlli di navigazione (bottoni Avanti/Indietro) nel DOM.

### 3. API Gateway a Microservizi (`3-APIgateway`)
* **Obiettivo:** Approcciare le architetture aziendali distribuite, la sicurezza e il controllo degli accessi.
* **Concetti chiave:** **API Gateway** come punto di ingresso unico (`gateway.php`), occultamento dei microservizi interni (`api_libri.php`, `api_utenti.php`), autenticazione **Stateless** tramite **Bearer Token** scambiato negli Header HTTP, gestione dei codici di stato di errore (`401 Unauthorized`).

---

## Eseguire i Progetti Localmente

Tutti i progetti sono autonomi e non richiedono la configurazione di un database esterno (i dati sono simulati staticamente nel backend).

1.  Apri la cartella dello specifico progetto su **VS Code**.
2.  Apri il terminale integrato di VS Code (`Ctrl + ò`).
3.  Avvia il server web integrato di PHP con il comando:
    ```bash
    php -S localhost:8000
    ```
4.  Apri il tuo browser e naviga all'indirizzo:
    ```text
    http://localhost:8000/index.html
    ```

*Nota: Non aprire il file `index.html` facendo doppio click dal desktop (`file:///...`), altrimenti i meccanismi di sicurezza del browser (CORS) bloccheranno le chiamate API verso il server.*

---

## Testing degli Endpoint con Postman

Prima di interagire con le interfacce grafiche, si raccomanda di testare l'indipendenza dei backend utilizzando **Postman** per osservare i dati JSON puri e i codici di stato HTTP (`200 OK`, `401 Unauthorized`, `404 Not Found`).

### Esempi di test per il Progetto 2 (Paginazione):
* **GET** `http://localhost:8000/api.php/tutti?pagina=1` (Restituisce i primi 10 libri e i metadati).
* **GET** `http://localhost:8000/api.php/tutti?pagina=2` (Sposta l'offset sui successivi 10 libri).

### Esempi di test per il Progetto 3 (API Gateway):
1.  **POST** `http://localhost:8000/gateway.php/login`
    * Invia nel *Body* (formato `raw -> JSON`) le credenziali: `{"username": "admin", "password": "password123"}`
    * Riceverai il token di risposta: `"token-segreto-5A"`.
2.  **GET** `http://localhost:8000/gateway.php/libri`
    * Se inviato senza modifiche, restituirà un errore `401`.
    * Vai nella scheda *Headers* di Postman, aggiungi la chiave `Authorization` con il valore `Bearer token-segreto-5A` per sbloccare la risorsa.