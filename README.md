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


______________________________________________________________

# GameSAW
## Interactive Full-Stack Web Application

Web application project developed for the Web Application Systems (SAW) course at DIBRIS, **University of Genoa (UniGe)**.

## 📋 Project Overview
**GameSAW** is an interactive web-based application featuring a dynamic frontend communicating asynchronously with a secure backend. The project focuses on robust database management, clean separation of concerns, and a responsive user experience. 

The application has been deployed and tested on the official university servers (`saw.dibris.unige.it`).

---

## 🛠️ Tech Stack & Architecture

* **Frontend:** HTML5, CSS3, JavaScript (ES6+ with Fetch API for asynchronous requests)
* **Backend:** PHP (handling routing, business logic, and session management)
* **Database & Persistence:** MySQL managed via **PHP Data Objects (PDO)** using prepared statements to prevent SQL injection.
* **Development Environment:** XAMPP (Apache, MySQL)

---

## 🚀 Key Features

* **Asynchronous Communication:** Seamless data exchange between client and server without full page reloads using the JavaScript Fetch API.
* **Secure Database Operations:** Strict use of PDO and prepared statements for all database queries, ensuring high security against vulnerabilities.
* **Responsive Interface:** Custom CSS styling designed for a clean and intuitive user experience across different screen sizes.
* **Session Management:** Robust handling of user states and server-side logic.

---

## ⚙️ Local Installation & Setup

To run GameSAW locally on your machine using XAMPP:

1. Clone the repository into your XAMPP `htdocs` directory:
   ```bash
   cd C:/xampp/htdocs
   git clone [https://github.com/S6520241/GameSAW.git](https://github.com/S6520241/GameSAW.git)

Start Apache and MySQL from the XAMPP Control Panel.

Import the provided SQL database schema into your local MySQL server (via phpMyAdmin or DataGrip).

Configure your database connection credentials in the PHP configuration/connection file.

Open your browser and navigate to:
   ```bash
   http://localhost/GameSAW/
 ```
## Author
Francesco Giuseppino (Student ID: 6520241)

Bachelor’s Degree in Computer Science – University of Genoa (UniGe)
