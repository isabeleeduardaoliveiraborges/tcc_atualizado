<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdaptMove - Profissionais</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* ACESSIBILIDADE */
        body.alto-contraste {
            --bg: #000; --bg2: #000; --bg3: #000;
            --accent: #ffff00; --text: #ffff00; --muted: #fff; --border: #ffff00;
        }
        body.fonte-dislexia, body.fonte-dislexia * {
            font-family: Arial, sans-serif !important;
            letter-spacing: 0.05em !important;
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
        .logo { font-family: 'Bebas Neue', sans-serif; font-size: 2rem; letter-spacing: 2px; color: var(--text); }
        .logo span { color: var(--accent); }
        nav ul { display: flex; list-style: none; gap: 30px; }
        nav a { color: var(--muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; }
        nav a.active, nav a:hover { color: var(--text); }

        main { padding: 60px 5%; max-width: 1400px; margin: 0 auto; }
        .page-title { font-family: 'Bebas Neue', sans-serif; font-size: 3rem; margin-bottom: 40px; letter-spacing: 1px; }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }

        /* MAPA REAL */
        #map {
            width: 100%;
            height: 600px;
            border-radius: 16px;
            border: 1px solid var(--border);
            z-index: 1;
        }

        /* LISTA PROFISSIONAIS */
        .prof-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }
        .prof-list::-webkit-scrollbar { width: 6px; }
        .prof-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

        .prof-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            gap: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .prof-card:hover { border-color: var(--accent); background: var(--bg3); }
        .prof-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
        .prof-info h3 { font-size: 1.2rem; margin-bottom: 4px; }
        .prof-tag { font-size: 0.8rem; color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .prof-desc { font-size: 0.9rem; color: var(--muted); margin-top: 8px; }

        /* MODAL */
        .modal {
            position: fixed; inset: 0; background: rgba(0,0,0,0.8);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; z-index: 200; transition: opacity 0.3s;
            padding: 20px;
        }
        .modal.active { opacity: 1; pointer-events: auto; }
        .modal-content {
            background: var(--bg2); border: 1px solid var(--border); width: 100%; max-width: 700px;
            border-radius: 16px; padding: 40px; position: relative; max-height: 90vh; overflow-y: auto;
        }
        .modal-close { position: absolute; top: 20px; right: 20px; background: transparent; border: none; color: var(--muted); font-size: 1.5rem; cursor: pointer; }
        .modal-header { display: flex; gap: 30px; margin-bottom: 30px; align-items: center; }
        .modal-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent); }
        .modal-header-info h2 { font-family: 'Bebas Neue', sans-serif; font-size: 2.5rem; letter-spacing: 1px; line-height: 1.1; }
        
        .modal-body { display: flex; flex-direction: column; gap: 24px; }
        .info-group h4 { font-size: 0.8rem; text-transform: uppercase; color: var(--accent); letter-spacing: 1px; margin-bottom: 6px; }
        .info-group p { font-size: 0.95rem; color: var(--text); line-height: 1.6; }
        
        .btn-wpp {
            display: block; width: 100%; background: #25d366; color: #fff; text-align: center;
            padding: 14px; border-radius: 8px; font-weight: 700; text-decoration: none; margin-top: 10px; transition: opacity 0.2s;
        }
        .btn-wpp:hover { opacity: 0.9; }

        @media (max-width: 992px) {
            .layout-grid { grid-template-columns: 1fr; }
            #map { height: 350px; }
        }
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
                <li><a href="proficionais.php" class="active">Mapa</a></li>
                <li><a href="recomendados.php">Recomendados</a></li>
                <li><a href="calendario.php">Calendário</a></li>
                <li><a href="proficionais.php">Profissionais</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1 class="page-title">Rede Credenciada & Especialistas</h1>
        
        <div class="layout-grid">
            <div id="map"></div>

            <div class="prof-list">
                
                <div class="prof-card card-click" 
                     data-nome="Sensei Ricardo Silva" 
                     data-cargo="Faixa Preta 4º Dan — Especialista em Para-Jiu-Jitsu"
                     data-biografia="Mais de 15 anos de experiência no ensino de artes marciais adaptadas. Fundador do projeto Tatame para Todos, focado no desenvolvimento de atletas cadeirantes e amputados."
                     data-especializacao="Adaptação de alavancas para membros superiores/inferiores comprometidos."
                     data-estilo="Foco na paciência, técnica pura e repetição guiada por toque táctil."
                     data-metas="Levar 3 atletas para o próximo circuito internacional de Para-Jiu-Jitsu."
                     data-agendamento="Terças e Quintas: 14h às 17h. Sábados: 09h às 11h."
                     data-foto="https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=300"
                     data-whatsapp="5511999999999">
                    <img class="prof-avatar" src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=300" alt="Ricardo Silva">
                    <div class="prof-info">
                        <span class="prof-tag">Jiu-Jitsu Adaptado</span>
                        <h3>Sensei Ricardo Silva</h3>
                        <p class="prof-desc">Especializado em adaptação mecânica de alavancas para cadeirantes.</p>
                    </div>
                </div>

                <div class="prof-card card-click" 
                     data-nome="Dra. Aline Mendes" 
                     data-cargo="Psicopedagoga & Instrutora de Karatê Inclusivo"
                     data-biografia="Aline une conceitos de neuropsicologia aplicada ao esporte com os katas tradicionais do Karatê para aperfeiçoar foco, regulação emocional e tônus muscular de crianças e adultos neurodivergentes."
                     data-especializacao="Intervenções motoras para TEA (Autismo), TDAH e Síndrome de Down."
                     data-estilo="Instruções visuais lúdicas, reforço positivo imediato e controle sensorial de ambiente."
                     data-metas="Expandir turmas de inclusão infantil para mais 4 dojôs parceiros este ano."
                     data-agendamento="Segundas e Quartas: 08h às 12h. Sextas: 14h às 18h."
                     data-foto="https://images.unsplash.com/photo-1594824813573-246434e3b96f?q=80&w=300"
                     data-whatsapp="5511988888888">
                    <img class="prof-avatar" src="https://images.unsplash.com/photo-1594824813573-246434e3b96f?q=80&w=300" alt="Aline Mendes">
                    <div class="prof-info">
                        <span class="prof-tag">Suporte Neurodivergente</span>
                        <h3>Dra. Aline Mendes</h3>
                        <p class="prof-desc">Aplica o Karatê como terapia psicomotora para Autismo e TDAH.</p>
                    </div>
                </div>

                <div class="prof-card card-click" 
                     data-nome="Coach Thiago Santos" 
                     data-cargo="Treinador de Boxe Adaptado & Fisioterapeuta"
                     data-biografia="Thiago desenvolve metodologias de manoplas e sacos de pancada de alta absorção de impacto estruturadas especificamente para o treino sentado ou com órteses estáveis."
                     data-especializacao="Fortalecimento de core e estabilização escapular para praticantes em cadeiras de rodas."
                     data-estilo="Treino dinâmico focado em potência cardiovascular, ritmo coordenado e esquivas adaptadas."
                     data-metas="Criar a primeira competição regional de Boxe adaptado em cadeira de rodas."
                     data-agendamento="Segunda a Quinta: 18h às 21h."
                     data-foto="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=300"
                     data-whatsapp="5511977777777">
                    <img class="prof-avatar" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=300" alt="Thiago Santos">
                    <div class="prof-info">
                        <span class="prof-tag">Boxe Tradicional & Adaptado</span>
                        <h3>Coach Thiago Santos</h3>
                        <p class="prof-desc">Fisioterapia aplicada ao combate esportivo e ganho de mobilidade de tronco.</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div id="modal-perfil" class="modal">
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <div class="modal-header">
                <img id="m-foto" class="modal-img" src="" alt="">
                <div class="modal-header-info">
                    <h2 id="m-nome"></h2>
                    <p id="m-cargo" style="color: var(--accent); font-size:0.95rem; margin-top:4px;"></p>
                </div>
            </div>
            <div class="modal-body">
                <div class="info-group">
                    <h4>Sobre o Profissional</h4>
                    <p id="m-biografia"></p>
                </div>
                <div class="info-group">
                    <h4>Especialização Técnica</h4>
                    <p id="m-especializacao"></p>
                </div>
                <div class="info-group">
                    <h4>Estilo Didático</h4>
                    <p id="m-estilo"></p>
                </div>
                <div class="info-group">
                    <h4>Objetivos com Alunos Adaptados</h4>
                    <p id="m-metas"></p>
                </div>
                <div class="info-group">
                    <h4>Disponibilidade para Avaliação</h4>
                    <p id="m-agendamento"></p>
                </div>
                <a id="m-whatsapp" class="btn-wpp" href="" target="_blank">💬 Agendar via WhatsApp</a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Inicialização Local do Mapa Leaflet
        const map = L.map('map').setView([-23.55052, -46.633308], 11); // São Paulo Base
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO'
        }).addTo(map);

        // Marcadores de Exemplo coerentes com a lista
        L.marker([-23.5615, -46.6562]).addTo(map).bindPopup('<b>Centro de Treinamento Ricardo Silva</b><br>Para-Jiu-Jitsu e Acessibilidade.');
        L.marker([-23.5875, -46.6575]).addTo(map).bindPopup('<b>Clínica e Dojô Aline Mendes</b><br>Karatê cognitivo e comportamental.');
        L.marker([-23.5432, -46.6421]).addTo(map).bindPopup('<b>Boxe Evolution Thiago Santos</b><br>Estrutura totalmente plana.');
    </script>
    <script src="script.js"></script>
</body>
</html>