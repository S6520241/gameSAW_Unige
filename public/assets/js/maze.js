(() => {
  const mazeEl = document.getElementById("maze");
  const timerEl = document.getElementById("timer");
  const movesEl = document.getElementById("moves");
  const scoreEl = document.getElementById("score");
  const msgEl = document.getElementById("message");
  const btnStart = document.getElementById("btnStart");
  const btnReset = document.getElementById("btnReset");
  const diffSel = document.getElementById("difficultySelect");

  const scoreForm = document.getElementById("scoreForm");
  const scoreField = document.getElementById("scoreField");
  const movesField = document.getElementById("movesField");
  const timeField = document.getElementById("timeField");
  const difficultyField = document.getElementById("difficultyField");

  // 0 percorso, 1 muro, 2 inizio, 3 fine
  const MAPS = {
    easy: [
      [1,1,1,1,1,1,1,1,1,1,1,1],
      [1,2,0,0,1,0,0,0,0,0,0,1],
      [1,1,1,0,1,0,1,1,1,1,0,1],
      [1,0,0,0,0,0,0,0,1,0,0,1],
      [1,0,1,1,1,1,1,0,1,0,1,1],
      [1,0,0,0,0,0,1,0,0,0,0,1],
      [1,1,1,1,1,0,1,1,1,1,0,1],
      [1,0,0,0,1,0,0,0,0,1,0,1],
      [1,0,1,0,1,1,1,1,0,1,0,1],
      [1,0,1,0,0,0,0,1,0,0,0,1],
      [1,0,0,0,1,1,0,1,1,1,3,1],
      [1,1,1,1,1,1,1,1,1,1,1,1],
    ],
    medium: [
      [1,1,1,1,1,1,1,1,1,1,1,1,1,1],
      [1,2,0,0,1,0,0,0,1,0,0,0,0,1],
      [1,1,1,0,1,0,1,0,1,0,1,1,0,1],
      [1,0,0,0,0,0,1,0,0,0,0,1,0,1],
      [1,0,1,1,1,0,1,1,1,1,0,1,0,1],
      [1,0,0,0,1,0,0,0,0,1,0,0,0,1],
      [1,1,1,0,1,1,1,1,0,1,1,1,0,1],
      [1,0,0,0,0,0,0,1,0,0,0,1,0,1],
      [1,0,1,1,1,1,0,1,1,1,0,1,0,1],
      [1,0,0,0,0,1,0,0,0,1,0,0,0,1],
      [1,1,1,1,0,1,1,1,0,1,1,1,0,1],
      [1,0,0,0,0,0,0,1,0,0,0,0,0,1],
      [1,0,1,1,1,1,0,1,1,1,1,1,3,1],
      [1,1,1,1,1,1,1,1,1,1,1,1,1,1],
    ],
    hard: [
      [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1],
      [1,2,0,0,1,0,0,0,1,0,0,0,0,0,0,1],
      [1,1,1,0,1,0,1,0,1,0,1,1,1,1,0,1],
      [1,0,0,0,0,0,1,0,0,0,0,0,0,1,0,1],
      [1,0,1,1,1,0,1,1,1,1,1,1,0,1,0,1],
      [1,0,0,0,1,0,0,0,0,0,0,1,0,1,0,1],
      [1,1,1,0,1,1,1,1,1,1,0,1,0,1,0,1],
      [1,0,0,0,0,0,0,0,0,1,0,1,0,0,0,1],
      [1,0,1,1,1,1,1,1,0,1,0,1,1,1,0,1],
      [1,0,0,0,0,0,0,1,0,1,0,0,0,1,0,1],
      [1,1,1,1,1,1,0,1,0,1,1,1,0,1,0,1],
      [1,0,0,0,0,1,0,0,0,0,0,1,0,1,0,1],
      [1,0,1,1,0,1,1,1,1,1,0,1,0,1,0,1],
      [1,0,0,1,0,0,0,0,0,1,0,0,0,1,3,1],
      [1,0,0,0,0,1,1,1,0,1,1,1,0,0,0,1],
      [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1],
    ],
  };

  let map = null;
  let rows = 0, cols = 0;
  let player = { r: 0, c: 0 };
  let exit = { r: 0, c: 0 };
  let started = false;
  let ended = false;
  let moves = 0;
  let startTs = 0;
  let timerInt = null;

  function formatTime(sec) {
    const m = String(Math.floor(sec / 60)).padStart(2, "0");
    const s = String(sec % 60).padStart(2, "0");
    return `${m}:${s}`;
  }

  function setMessage(t) { msgEl.textContent = t; }

  function findSpecialCells() {
    for (let r = 0; r < rows; r++) {
      for (let c = 0; c < cols; c++) {
        if (map[r][c] === 2) player = { r, c };
        if (map[r][c] === 3) exit = { r, c };
      }
    }
  }

  function render() {
    mazeEl.innerHTML = "";
    mazeEl.style.setProperty("--cols", cols);

    for (let r = 0; r < rows; r++) {
      for (let c = 0; c < cols; c++) {
        const v = map[r][c];
        const cell = document.createElement("div");
        cell.className = "cell";
        if (v === 1) cell.classList.add("wall");
        if (v === 2) cell.classList.add("start");
        if (v === 3) cell.classList.add("exit");
        if (r === player.r && c === player.c) cell.classList.add("player");


        mazeEl.appendChild(cell);
      }
    }
  }


  function resetState() {
    started = false;
    ended = false;
    moves = 0;
    movesEl.textContent = "0";
    scoreEl.textContent = "—";
    timerEl.textContent = "00:00";
    setMessage("Premi Avvia e muoviti con WASD/Frecce.");
    if (timerInt) clearInterval(timerInt);
    timerInt = null;
  }

  function loadDifficulty() {
    const d = diffSel.value;
    difficultyField.value = d;

    map = MAPS[d].map(row => row.slice());
    rows = map.length;
    cols = map[0].length;

    findSpecialCells();
    resetState();
    render();
  }

  function startGame() {
    if (ended) return;
    if (started) return;
    started = true;
    startTs = Date.now();
    setMessage("Vai! Raggiungi EXIT.");

    timerInt = setInterval(() => {
      const sec = Math.floor((Date.now() - startTs) / 1000);
      timerEl.textContent = formatTime(sec);
    }, 250);
  }

  function computeScore(timeSec, movesCount) {
    let s = 1000 - (timeSec * 10) - (movesCount * 2);
    if (s < 0) s = 0;
    return s;
  }

  function win() {
    ended = true;
    if (timerInt) clearInterval(timerInt);

    const timeSec = Math.floor((Date.now() - startTs) / 1000);
    const finalScore = computeScore(timeSec, moves);

    timerEl.textContent = formatTime(timeSec);
    scoreEl.textContent = String(finalScore);

    setMessage(`Hai vinto! Score: ${finalScore}. Salvo il punteggio...`);

    // invia al server tramite Fetch API
    setTimeout(() => {
      const formData = new FormData();
      formData.append("score", finalScore);
      formData.append("moves", moves);
      formData.append("time_sec", timeSec);
      formData.append("difficulty", diffSel.value);

      fetch("api/save_score.php", {
        method: "POST",
        body: formData
      })
      .then(response => {
        if (response.ok) {
            window.location.href = "leaderboard.php";
          } else {
            setMessage("Errore durante il salvataggio del punteggio.");
          }
        })
        .catch(error => {
          console.error("Errore Fetch:", error);
          setMessage("Errore di connessione.");
        });
      }, 600);
  }

  function tryMove(dr, dc) {
    if (!started || ended) return;

    const nr = player.r + dr;
    const nc = player.c + dc;
    if (nr < 0 || nc < 0 || nr >= rows || nc >= cols) return;
    if (map[nr][nc] === 1) return;

    player.r = nr;
    player.c = nc;
    moves++;
    movesEl.textContent = String(moves);
    render();

    if (nr === exit.r && nc === exit.c) win();
  }


  function onKey(e) {
    const k = e.key.toLowerCase();
    if (k === "arrowup" || k === "w") { e.preventDefault(); tryMove(-1, 0); }
    if (k === "arrowdown" || k === "s") { e.preventDefault(); tryMove(1, 0); }
    if (k === "arrowleft" || k === "a") { e.preventDefault(); tryMove(0, -1); }
    if (k === "arrowright" || k === "d") { e.preventDefault(); tryMove(0, 1); }
  }

  btnStart.addEventListener("click", startGame);
  btnReset.addEventListener("click", loadDifficulty);
  diffSel.addEventListener("change", loadDifficulty);
  window.addEventListener("keydown", onKey);

  // inizio
  loadDifficulty();
})();
