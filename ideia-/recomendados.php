<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esportes Adaptados — AdaptMove</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #0c0c0f;
            --bg2: #13131a;
            --bg3: #1a1a24;
            --accent: #00e5ff;
            --accent2: #7b2fff;
            --text: #f0f0f5;
            --muted: #6b6b80;
            --border: rgba(255,255,255,0.07);
            --fonte-tamanho-base: 16px;
        }

        html { scroll-behavior: smooth; font-size: var(--fonte-tamanho-base); }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ACESSIBILIDADE */
        body.alto-contraste {
            --bg: #000; --bg2: #000; --bg3: #000;
            --accent: #ffff00; --accent2: #ffff00; --text: #ffff00; --muted: #fff; --border: #ffff00;
        }
        body.alto-contraste * { border-color: #ffff00 !important; color: #ffff00 !important; background: #000 !important; }
        body.fonte-dislexia, body.fonte-dislexia * {
            font-family: Arial, sans-serif !important;
            letter-spacing: 0.04em !important;
            word-spacing: 0.08em !important;
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
            position: sticky; top: 0; z-index: 100; background: rgba(12,12,15,0.92);
            backdrop-filter: blur(20px); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; padding: 18px 5%;
        }
        .logo { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; color: var(--text); }
        .logo span { color: var(--accent); }
        nav ul { display: flex; list-style: none; gap: 30px; }
        nav a { color: var(--muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; }
        nav a:hover, nav a.active { color: var(--text); }

        main { padding: 60px 5%; max-width: 1200px; margin: 0 auto; }
        .intro-block { margin-bottom: 40px; }
        .intro-block h1 { font-family: 'Bebas Neue', sans-serif; font-size: 3.5rem; letter-spacing: 1px; margin-bottom: 8px; }
        .intro-block p { color: var(--muted); font-size: 1.1rem; max-width: 600px; }

        /* FILTROS LOCAIS INTERNOS */
        .sport-filters { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 40px; border-bottom: 1px solid var(--border); padding-bottom: 20px; }
        .filter-btn-sport { background: var(--bg2); border: 1px solid var(--border); color: var(--muted); padding: 8px 20px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; }
        .filter-btn-sport:hover, .filter-btn-sport.active { border-color: var(--accent); color: var(--accent); background: rgba(0,229,255,0.05); }

        .cards-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 30px; }
        .sport-card { background: var(--bg2); border: 1px solid var(--border); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; transition: transform 0.2s, border-color 0.2s; text-decoration: none; color: inherit; }
        .sport-card:hover { transform: translateY(-4px); border-color: rgba(255,255,255,0.15); }
        .card-banner { height: 180px; width: 100%; object-fit: cover; filter: brightness(0.75); }
        .card-content { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; gap: 14px; }
        .card-tag { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; color: var(--accent2); }
        .sport-card[data-category="fisico"] .card-tag { color: var(--accent); }
        .card-content h2 { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 0.5px; line-height: 1.2; color: var(--text); }
        .card-desc { font-size: 0.9rem; color: var(--muted); line-height: 1.6; }
        
        .info-topic { background: var(--bg3); padding: 12px; border-radius: 6px; font-size: 0.85rem; border-left: 3px solid var(--accent2); color: var(--text); }
        .sport-card[data-category="fisico"] .info-topic { border-left-color: var(--accent); }
        .alert-topic { border-left-color: #ffd600 !important; background: rgba(255,214,0,0.02); }
        .info-topic strong { display: block; margin-bottom: 2px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.3px; }

        .card-footer { padding: 16px 24px; border-top: 1px solid var(--border); font-size: 0.78rem; color: var(--muted); background: rgba(0,0,0,0.1); }
    </style>
</head>
<body>

    <div class="a11y-bar">
        <button onclick="alterarFonte()">Fonte Acessível</button>
        <button onclick="alterarContraste()">Alto Contraste</button>
    </div>

    <header>
        <div class="logo">Adapt<span>Move</span></div>
        <nav>
            <ul>
                <li><a href="inde.php">Início</a></li>
                <li><a href="inde.php#sobre">Sobre Nós</a></li>
                <li><a href="proficionais.php">Mapa</a></li>
                <li><a href="recomendados.php" class="active">Recomendados</a></li>
                <li><a href="calendario.php">Calendário</a></li>
                <li><a href="proficionais.php">Profissionais</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="intro-block">
            <h1>Modalidades & Benefícios</h1>
            <p>Descubra como cada arte marcial se adapta a diferentes condições anatômicas ou cognitivas e encontre a modalidade ideal.</p>
        </div>

        <div class="sport-filters">
            <button class="filter-btn-sport active" data-filter="todos">Ver Todas</button>
            <button class="filter-btn-sport" data-filter="fisico">Deficiências Físicas / Motores</button>
            <button class="filter-btn-sport" data-filter="cognitivo">Neurodivergentes / Cognitivo</button>
        </div>

        <div class="cards-container">
            
            <article class="sport-card" data-category="fisico">
                <img class="card-banner" src="https://images.unsplash.com/photo-1555597673-b21d5c935865?q=80&w=500" alt="Para-Jiu-Jitsu">
                <a href="proficionais.php" class="card-content" style="text-decoration:none;">
                    <span class="card-tag">Deficiência Física / Funcional</span>
                    <h2>Para-Jiu-Jitsu (BJJ Adaptado)</h2>
                    <p class="card-desc">Focado no combate de solo, o Jiu-Jitsu elimina a necessidade de quedas complexas em pé, tornando-se perfeito para amputados e pessoas com baixa mobilidade pélvica.</p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div class="info-topic">
                            <strong>🧠 Ganho Terapêutico:</strong>
                            Aumento drástico do controle de tronco, fortalecimento isométrico escapular e desenvolvimento apurado de sensibilidade tátil e propriocepção profunda.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Atenção rigorosa ao atrito constante da pele no tatame para evitar lesões por fricção ou escoriações em áreas com sensibilidade reduzida.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Revisado por: Especialistas em Fisioterapia Esportiva</span>
                </div>
            </article>

            <article class="sport-card" data-category="cognitivo">
                <img class="card-banner" src="https://images.unsplash.com/photo-1509563268479-0f004cf3f58b?q=80&w=500" alt="Karatê Inclusivo">
                <a href="proficionais.php" class="card-content" style="text-decoration:none;">
                    <span class="card-tag">Desenvolvimento Cognitivo</span>
                    <h2>Karatê para Neurodivergentes (TEA / TDAH)</h2>
                    <p class="card-desc">A repetição estruturada dos Katas (formas) oferece um ambiente previsível, seguro e lógico que ajuda na regulação física de alunos dentro do espectro autista.</p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div class="info-topic">
                            <strong>🧠 Ganho Terapêutico:</strong>
                            Organização do planejamento motor básico, aumento do foco atencional sustentado e canalização adequada de crises através da disciplina marcial.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Exige um controle rigoroso do volume de estímulos sonoros no dojô (gritos altos de Kiai) para evitar sobrecarga ou crises de hipersensibilidade sensorial.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Revisado por: Psicopedagogos e Faixas Pretas</span>
                </div>
            </article>

            <article class="sport-card" data-category="fisico">
                <img class="card-banner" src="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?q=80&w=500" alt="Boxe Adaptado">
                <a href="proficionais.php" class="card-content" style="text-decoration:none;">
                    <span class="card-tag">Acessibilidade Motora</span>
                    <h2>Boxe sobre Rodas & Adaptado</h2>
                    <p class="card-desc">Treinos focados na parte superior, utilizando manoplas estáticas e sacos de pancada de alta absorção, adaptados perfeitamente para atletas sentados.</p>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div class="info-topic">
                            <strong>🧠 Ganho Terapêutico:</strong>
                            Fortalecimento integral do core, ganho de agilidade de reação reflexa alta e melhora drástica da circulação periférica.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Uso indispensável de bermudas com tecido de alta resistência ou proteções acolchoadas para evitar escoriações por fricção.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Professores de Educação Física e Atletas da Seleção</span>
                </div>
            </article>

        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>