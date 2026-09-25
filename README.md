# GameSAW
## Applicazione Web Full-Stack Interattiva

Progetto di applicazione web sviluppato per il corso di Sistemi di Applicazioni Web (SAW) presso **Università degli Studi di Genova (UniGe)**.

## 📋 Panoramica del Progetto
**GameSAW** è un'applicazione web interattiva caratterizzata da un frontend dinamico che comunica in modo asincrono con un backend sicuro. Il progetto si concentra su una solida gestione del database, una netta separazione delle responsabilità e un'esperienza utente reattiva.

L'applicazione è stata inoltre distribuita e testata sui server ufficiali dell'università (`saw.dibris.unige.it`).

---

## 🛠️ Stack Tecnologico e Architettura

* **Frontend:** HTML5, CSS3, JavaScript (ES6+ con Fetch API per richieste asincrone)
* **Backend:** PHP (gestione del routing, della logica di business e delle sessioni)
* **Database e Persistenza:** MySQL gestito tramite **PHP Data Objects (PDO)**, utilizzando *prepared statements* per prevenire attacchi di tipo SQL injection.
* **Ambiente di Sviluppo:** XAMPP (Apache, MySQL)

---

## 🚀 Caratteristiche Principali

* **Comunicazione Asincrona:** Scambio di dati fluido tra client e server senza ricaricare l'intera pagina, sfruttando la JavaScript Fetch API.
* **Sicurezza del Database:** Utilizzo rigoroso di PDO e prepared statements per tutte le query al database, garantendo un'elevata protezione contro le vulnerabilità.
* **Interfaccia Responsiva:** Fogli di stile CSS personalizzati progettati per offrire un'esperienza utente pulita e intuitiva su diversi dispositivi.
* **Gestione delle Sessioni:** Gestione robusta dello stato degli utenti e dei controlli di accesso lato server.

---

## ⚙️ Installazione e Configurazione Locale

Per eseguire GameSAW in locale sulla tua macchina utilizzando XAMPP:

1. Clona il repository all'interno della cartella `htdocs` di XAMPP:
   ```bash
   cd C:/xampp/htdocs
   git clone [https://github.com/S6520241/GameSAW.git](https://github.com/S6520241/GameSAW.git)

   Avvia i servizi Apache e MySQL dal Pannello di Controllo di XAMPP.

Importa lo schema del database SQL fornito nel tuo server MySQL locale (tramite phpMyAdmin o DataGrip).

Configura le credenziali di connessione al database nel file di configurazione PHP del progetto.

Apri il browser e vai all'indirizzo:
   ```bash
http://localhost/GameSAW/
  ```

## Autore
Francesco Giuseppino (Matricola: 6520241)

Corso di Laurea in Informatica – Università degli Studi di Genova (UniGe)
