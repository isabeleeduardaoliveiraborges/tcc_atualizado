<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner de Treino — AdaptMove</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
 
        :root {
            --bg:      #0c0c0f;
            --bg2:     #13131a;
            --bg3:     #1a1a24;
            --accent:  #00e5ff;
            --accent2: #7b2fff;
            --text:    #f0f0f5;
            --muted:   #6b6b80;
            --border:  rgba(255,255,255,0.07);
            --success: #00e676;
            --favorite: #ffd600;
        }
 
        html { 
            scroll-behavior: smooth; 
        }
 
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            padding-bottom: 60px;
        }

        /* ACESSIBILIDADE */
        body.alto-contraste {
            --bg: #000; --bg2: #000; --bg3: #000;
            --accent: #ffff00; --text: #ffff00; --muted: #fff; --border: #ffff00;
        }
        body.fonte-dislexia, body.fonte-dislexia * {
            font-family: Arial, sans-serif !important;
            letter-spacing: 0.04em !important;
            line-height: 1.8 !important;
        }

        .a11y-bar {
            background: #000; padding: 6px 5%; display: flex; justify-content: flex-end; gap: 10px;
            border-bottom: 1px solid var(--border);
        }
        .a11y-bar button {
            background: transparent; border: 1px solid var(--accent); color: var(--accent);
            padding: 4px 14px; border-radius: 20px; cursor: pointer; font-size: 0.78rem; font-weight: 600;
        }
 
        header {
            position: sticky; top: 0; z-index: 100;
            background: rgba(12,12,15,0.92); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 5%;
        }
        .logo { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: var(--text); text-decoration:none;}
        .logo span { color: var(--accent); }
        nav ul { display: flex; list-style: none; gap: 30px; }
        nav a { color: var(--muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; }
        nav a:hover, nav a.active { color: var(--text); }
 
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }
 
        .top-banner {
            background: linear-gradient(135deg, var(--bg2) 0%, #171724 100%);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .top-banner h1 { font-family: 'Bebas Neue', sans-serif; font-size: 2.8rem; letter-spacing: 0.5px; }
        .top-banner p { color: var(--muted); font-size: 0.95rem; margin-top: 4px; }
 
        /* PROGRESSO */
        .progress-box {
            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 10px;
            min-width: 280px;
            border: 1px solid var(--border);
        }
        .progress-header { display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 8px; }
        .progress-bar { width: 100%; height: 8px; background: var(--bg3); border-radius: 4px; overflow: hidden; }
        .progress-fill { width: 0%; height: 100%; background: var(--accent); transition: width 0.4s ease; }
 
        /* GRID DE SEMANAS */
        .weeks-grid {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .week-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .week-header {
            background: rgba(255,255,255,0.02);
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .week-header h2 { font-size: 1.1rem; font-weight: 600; color: var(--accent); }
        .week-counter { font-size: 0.85rem; color: var(--muted); }
 
        .days-list { padding: 10px 20px; }
        .day-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
        }
        .day-row:last-child { border-bottom: none; }
        
        .day-meta { display: flex; align-items: center; gap: 16px; }
        .day-name { font-weight: 600; font-size: 0.9rem; width: 80px; text-transform: uppercase; color: var(--muted); }
        .day-row.completed .day-name { color: var(--success); }
        
        .workout-title { font-size: 0.95rem; color: var(--text); }
        .day-row.completed .workout-title { color: var(--muted); text-decoration: line-through; }
 
        /* CONTROLES */
        .checkbox-wrapper {
            position: relative;
            width: 24px;
            height: 24px;
        }
        .day-check {
            width: 100%; height: 100%;
            cursor: pointer; opacity: 0;
            position: absolute; inset:0; z-index: 2;
        }
        .custom-box {
            position: absolute; inset:0;
            border: 2px solid var(--border);
            border-radius: 6px;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; color: transparent;
            background: var(--bg3);
        }
        .day-check:checked + .custom-box {
            background: var(--success);
            border-color: var(--success);
            color: #000;
        }
 
        /* TOAST NOTIFICAÇÃO */
        .toast {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--accent2); color: #fff;
            padding: 14px 24px; border-radius: 8px;
            font-size: 0.9rem; font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transform: translateY(100px); opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1000;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
    </style>
</head>
<body>

    <div class="a11y-bar">
        <button onclick="alterarFonte()">Fonte Acessível</button>
        <button onclick="alterarContraste()">Alto Contraste</button>
    </div>

    <header>
        <a class="logo" href="inde.php">Adapt<span>Move</span></a>
        <nav>
            <ul>
                <li><a href="inde.php">Início</a></li>
                <li><a href="inde.php#sobre">Sobre Nós</a></li>
                <li><a href="proficionais.php">Mapa</a></li>
                <li><a href="recomendados.php">Recomendados</a></li>
                <li><a href="calendario.php" class="active">Calendário</a></li>
                <li><a href="proficionais.php">Profissionais</a></li>
            </ul>
        </nav>
    </header>
 
    <div class="container">
        <div class="top-banner">
            <div>
                <h1>Meu Cronograma Adaptado</h1>
                <p>Acompanhe sua regularidade marcial e gerencie suas metas semanais de mobilidade.</p>
                <button onclick="configurarLembrete()" style="margin-top:14px; background: transparent; border: 1px solid var(--accent); color: var(--accent); padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.8rem;">🔔 Ativar Lembrete</button>
            </div>
            <div class="progress-box">
                <div class="progress-header">
                    <span>Progresso do Ciclo</span>
                    <span id="progresso-texto">0 / 28 dias</span>
                </div>
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
            </div>
        </div>
 
        <div id="weeks-container" class="weeks-grid">
            </div>
    </div>
 
    <div id="toast" class="toast">🔔 Notificação de meta ativa!</div>
 
    <script>
        // Lógica de Renderização do Planner mantida no escopo local
        const NUM_SEMANAS = 4;
        const ROTINA_BASE = [
            "Mobilidade Articular Ativa + Alongamento Estático Guiado",
            "Técnicas de Alavancas Básicas (Solo/Bancada)",
            "Descanso Ativo (Exercícios Respiratórios / Meditação Zazen)",
            "Treino Cardiovascular Marcial (Sombra/Manopla Adaptada)",
            "Técnica Específica de Combate Clássico (Foco em Postura)",
            "Simulação Tática Controlada / Sparring Adaptado",
            "Descanso Integral / Regenerativo Completo"
        ];
        const DIAS_NOMES = ["Seg", "Ter", "Qua", "Qui", "Sex", "Sáb", "Dom"];
 
        function carregarDados() {
            const salvo = localStorage.getItem('adaptmove_planner');
            return salvo ? JSON.parse(salvo) : {};
        }
 
        function salvarDado(diaId, status) {
            const dados = carregarDados();
            dados[diaId] = status;
            localStorage.setItem('adaptmove_planner', JSON.stringify(dados));
            atualizarProgresso();
        }
 
        function renderizar() {
            const container = document.getElementById('weeks-container');
            const dadosSalvos = carregarDados();
            let html = '';
 
            for (let s = 1; s <= NUM_SEMANAS; s++) {
                html += `
                <div class="week-card" id="semana-${s}">
                    <div class="week-header">
                        <h2>Semana ${s} — Evolução Contínua</h2>
                        <span class="week-counter"><span id="wcount-${s}">0</span> de 7 concluídos</span>
                    </div>
                    <div class="days-list">`;
 
                for (let d = 0; d < 7; d++) {
                    const diaId = `s${s}d${d}`;
                    const checked = dadosSalvos[diaId] ? 'checked' : '';
                    const classeConcluido = dadosSalvos[diaId] ? 'completed' : '';
 
                    html += `
                    <div class="day-row ${classeConcluido}" id="row-${diaId}">
                        <div class="day-meta">
                            <span class="day-name">${DIAS_NOMES[d]}</span>
                            <span class="workout-title">${ROTINA_BASE[d]}</span>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" class="day-check" id="${diaId}" ${checked} onchange="alternarDia('${diaId}')">
                            <div class="custom-box">✓</div>
                        </div>
                    </div>`;
                }
 
                html += `</div></div>`;
            }
 
            container.innerHTML = html;
            atualizarProgresso();
        }
 
        function alternarDia(diaId) {
            const checkbox = document.getElementById(diaId);
            const linha = document.getElementById(`row-${diaId}`);
            
            if(checkbox.checked) {
                linha.classList.add('completed');
                salvarDado(diaId, true);
                mostrarToast("🎉 Excelente! Treino marcado como concluído.");
            } else {
                linha.classList.remove('completed');
                salvarDado(diaId, false);
            }
        }
 
        function atualizarProgresso() {
            const dados = carregarDados();
            let totalConcluidos = 0;
 
            for(let s = 1; s <= NUM_SEMANAS; s++) {
                let semanaConcluidos = 0;
                for(let d = 0; d < 7; d++) {
                    if(dados[`s${s}d${d}`]) {
                        semanaConcluidos++;
                        totalConcluidos++;
                    }
                }
                const wCount = document.getElementById(`wcount-${s}`);
                if(wCount) wCount.textContent = semanaConcluidos;
            }
 
            const totalDias = NUM_SEMANAS * 7; 
            const pct = (totalConcluidos / totalDias) * 100;
            
            document.getElementById('progresso-texto').textContent = `${totalConcluidos} / ${totalDias} dias concluídos`;
            document.getElementById('progress-fill').style.width = `${pct}%`;
        }
 
        function mostrarToast(msg) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }
 
        function configurarLembrete() {
            mostrarToast("🔔 Lembretes ativados no navegador!");
        }
 
        window.onload = renderizar;
    </script>
    <script src="script.js"></script>
</body>
</html>