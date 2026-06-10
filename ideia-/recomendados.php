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
            transition: background 0.3s, color 0.3s;
        }

        /* ── MODOS DE ACESSIBILIDADE VIA JAVASCRIPT ── */
        body.alto-contraste {
            --bg: #000000 !important; 
            --bg2: #000000 !important; 
            --bg3: #000000 !important;
            --accent: #ffff00 !important; 
            --accent2: #ffff00 !important;
            --text: #ffff00 !important; 
            --muted: #ffffff !important; 
            --border: #ffff00 !important;
        }
        body.alto-contraste * { border-color: #ffff00 !important; }

        body.fonte-dislexia, body.fonte-dislexia * {
            font-family: Arial, sans-serif !important;
            letter-spacing: 0.05em !important;
            word-spacing: 0.1em !important;
            line-height: 1.9 !important;
        }

        /* ── BARRA DE ACESSIBILIDADE ── */
        .a11y-bar {
            background: #000;
            padding: 6px 5%;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-bottom: 1px solid var(--border);
        }
        .a11y-bar button {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 4px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.78rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.2s;
        }
        .a11y-bar button:hover { background: var(--accent); color: #000; }

        /* ── HEADER & MENU NAVEGAÇÃO ── */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(12,12,15,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 5%;
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 2px;
            color: var(--text);
            text-decoration: none;
        }
        .logo span { color: var(--accent); }
        
        nav ul { display: flex; list-style: none; gap: 30px; }
        nav a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
            position: relative;
        }
        nav a::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }
        nav a:hover { color: var(--text); }
        nav a:hover::after { width: 100%; }
        nav a.active { color: var(--accent); }
        nav a.active::after { width: 100%; }

        /* ── HERO MINI ── */
        .page-hero {
            padding: 80px 5% 60px;
            text-align: center;
            background:
                radial-gradient(ellipse 60% 50% at 50% 100%, rgba(0,229,255,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 40% 30% at 20% 0%, rgba(123,47,255,0.08) 0%, transparent 50%);
            border-bottom: 1px solid var(--border);
        }
        .page-hero .tag {
            display: inline-block;
            background: rgba(0,229,255,0.1);
            border: 1px solid rgba(0,229,255,0.3);
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 5px 16px;
            border-radius: 30px;
            margin-bottom: 20px;
        }
        .page-hero h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            letter-spacing: 2px;
            line-height: 1.0;
            margin-bottom: 16px;
        }
        .page-hero p { color: var(--muted); font-size: 1rem; max-width: 600px; margin: 0 auto; }

        /* ── GRID DE CARDS DO PORTAL ── */
        .container {
            padding: 60px 5% 80px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 30px;
        }

        .content-card {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }
        
        .content-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            transform: scaleX(0);
            transition: transform 0.35s;
            transform-origin: left;
            z-index: 2;
        }

        .content-card:hover {
            border-color: rgba(0,229,255,0.3);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 0 1px rgba(0,229,255,0.1);
        }
        
        .content-card:hover::before { transform: scaleX(1); }

        .card-image-wrapper {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .card-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .content-card:hover .card-image-wrapper img {
            transform: scale(1.05);
        }

        /* Ícone indicador de play de vídeo */
        .video-play-badge {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.75);
            border: 1px solid var(--accent);
            color: #fff;
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .card-link-area {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex-grow: 1;
        }

        .card-body h2 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.3px;
            line-height: 1.3;
        }

        /* Badge do tipo de deficiência indicativa */
        .deficiency-tag {
            display: inline-block;
            align-self: flex-start;
            background: rgba(123, 47, 255, 0.15);
            border: 1px solid rgba(123, 47, 255, 0.4);
            color: #bfa3ff;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        /* Tópicos de informações exigidas pelo objetivo */
        .info-topic {
            font-size: 0.85rem;
            line-height: 1.5;
            color: var(--muted);
            border-left: 2px solid var(--border);
            padding-left: 10px;
            margin-top: 4px;
        }
        .info-topic strong {
            color: var(--text);
            font-weight: 600;
            display: block;
            font-size: 0.88rem;
            margin-bottom: 2px;
        }
        .info-topic.alert-topic {
            border-left-color: #ff4444;
        }
        .info-topic.alert-topic strong {
            color: #ff6666;
        }

        .card-footer {
            padding: 16px 24px;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
            letter-spacing: 0.5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── RESPONSIVO ── */
        @media (max-width: 768px) {
            header { flex-direction: column; gap: 16px; text-align: center; }
            nav ul { gap: 16px; }
            nav a { font-size: 0.8rem; }
            .content-grid { grid-template-columns: 1fr; }
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
                <li><a href="#sobre">Sobre Nós</a></li>
                <li><a href="proficionais.php">Mapa</a></li>
                <li><a href="recomendados.php" class="active">Recomendados</a></li>
                <li><a href="calendario.php">Calendário</a></li>
                <li><a href="proficionais.php">Profissionais</a></li>
            </ul>
        </nav>
    </header>

    <div class="page-hero" id="inicio">
        <div class="tag">Guia de Esportes</div>
        <h1>Práticas Inclusivas e Adaptadas</h1>
        <p>Descubra os esportes e artes marciais mais recomendados para diferentes tipos de deficiências, com análises técnicas de profissionais e demonstrações práticas.</p>
    </div>
<!-- CONTEÚDO PRINCIPAL (9 CARDS COM LINKS ATIVOS E TESTADOS) -->
    <main class="container">
        <div class="content-grid">
            
            <!-- CARD 1: JUDÔ -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://i.ytimg.com/vi/kZSdg1QZZ0E/hq720.jpg?sqp=-oaymwE7CK4FEIIDSFryq4qpAy0IARUAAAAAGAElAADIQj0AgKJD8AEB-AH-CYAC0AWKAgwIABABGGUgUShJMA8=&rs=AOn4CLBQj5BDhzmrY8U3HoGxDgIrO_NtJw" alt="Profissionais de judô no tatame">
                </div>
                <a href="https://youtu.be/kZSdg1QZZ0E" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Deficiência Visual</span>
                        <h2>Judô: Didática e Contato Corporal</h2>
                        <span class="channel-badge">📺 Canal: Comitê Paralímpico Brasileiro</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Profissionais e técnicos do Comitê explicam como a ausência de visão é compensada pelo estímulo cinestésico e mostram a regra do contato inicializado (Kumikata).
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Refino do mapeamento mental do espaço, ganho de tônus postural, equilíbrio e desenvolvimento da autoconfiança no ambiente diário.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Orientação verbal constante do treinador e tatame com relevo sinalizador nas extremidades para evitar impactos fora da área.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Técnicos da Seleção de Judô</span>
                </div>
            </article>

            <!-- CARD 2: PARA-JIU-JITSU -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://i.ytimg.com/vi/yVkiqZAD29U/maxresdefault.jpg" alt="Atletas treinando jiu-jitsu adaptado">
                </div>
                <a href="https://youtu.be/yVkiqZAD29U" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Deficiência Física / Motora</span>
                        <h2>Biomecânica no ParaJiu-Jitsu</h2>
                        <span class="channel-badge">📺 Canal: Revista TATAME</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Profissionais de educação física analisam como adaptar as alavancas corporais e técnicas de solo para atletas com amputações ou lesões medulares.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Isolamento e fortalecimento de grupos musculares superiores, melhora drástica da mobilidade do core (abdômen e lombar) e foco mental tático.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Monitoramento rigoroso de membros com perda de sensibilidade para evitar fraturas ou torções acidentais por falta de feedback de dor.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Professores e Faixas Pretas Especializados</span>
                </div>
            </article>

            <!-- CARD 3: BASQUETE EM CADEIRA DE RODAS -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://i.ytimg.com/vi/lv7bwjqDuqk/hq720.jpg?sqp=-oaymwE7CK4FEIIDSFryq4qpAy0IARUAAAAAGAElAADIQj0AgKJD8AEB-AH-CYAC0AWKAgwIABABGGUgUihCMA8=&rs=AOn4CLCAIYXolg4CFpHVs2xyWQIT3Ohh-g" alt="Atleta de basquete em cadeira de rodas">
                </div>
                <a href="https://youtu.be/lv7bwjqDuqk" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Cadeirantes e Amputados</span>
                        <h2>Fisiologia no Basquete Adaptado</h2>
                        <span class="channel-badge">📺 Canal: Comitê Paralímpico Brasileiro</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Especialistas detalham a dinâmica do esporte, o manejo técnico da cadeira de rodas em alta velocidade e os sistemas de pontuação funcional.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Aumento massivo do condicionamento cardiorrespiratório, desenvolvimento de agilidade fina nas mãos e alto senso de trabalho em equipe.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Adequação milimétrica do encosto e das faixas de contenção para evitar lesões por atrito contínuo na pele e proteger a coluna.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Preparadores Físicos Paralímpicos</span>
                </div>
            </article>

            <!-- CARD 4: NATAÇÃO -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN4iY1UEVJmQIJswcnYgNRpG5EL4b-o9WrKA&s" alt="Nadador na piscina paralímpica">
                </div>
                <a href="https://youtu.be/Lsjmge-GBx0?si=-zRESO7WKwRkFzQR" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Múltiplas Deficiências</span>
                        <h2>Natação: Classificação e Metodologia</h2>
                        <span class="channel-badge">📺 Canal: Esporte Espetacular / GE</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Profissionais do esporte e atletas explicam detalhadamente o sistema de classificação funcional em classes de 1 a 14 e as metodologias de treinamento fisiológico na água.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Trabalho de resistência aeróbica com impacto zero, alívio de tensões musculares crônicas e forte ganho de autonomia motora.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Controle rigoroso da temperatura da água para evitar espasmos e avaliação prévia da capacidade pulmonar de cada aluno.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Fisioterapeutas e Técnicos Esportivos</span>
                </div>
            </article>

            <!-- CARD 5: PARA-KARATE -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://i.ytimg.com/vi/_cJ8EpcxiZk/sddefault.jpg?sqp=-oaymwEmCIAFEOAD8quKqQMa8AEB-AGMBYAC4AOKAgwIABABGHIgWig4MA8=&rs=AOn4CLAAeWj0KUL9KdOHF1crsTwTI8c2zQ" alt="Treino de Karatê inclusivo">
                </div>
                <a href="https://youtu.be/_cJ8EpcxiZk" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Intelectual / Autismo</span>
                        <h2>Inclusão Cognitiva através do Karatê</h2>
                        <span class="channel-badge">📺 Canal: Programa Sentidos</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Profissionais explicam a aplicação dos "Katas" (sequências estruturadas) como ferramenta terapêutica para foco, rotina e psicomotricidade.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Redução drástica de níveis de ansiedade, melhora na coordenação motora fina bilateral e ganho de disciplina comportamental.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Adaptação do tom de voz do instrutor e controle de iluminação/ruídos para evitar crises de hipersensibilidade sensorial.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Psicopedagogos e Mestres de Artes Marciais</span>
                </div>
            </article>

            <!-- CARD 6: FUTEBOL DE 5 -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRYmrZh8-Pj6clMrehOW9DqOIQBopABOesoZA&s" alt="Bola de futebol adaptada com guizo">
                </div>
                <a href="https://youtu.be/QiSwg-cKET8" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Deficiência Visual Total</span>
                        <h2>Futebol de Cegos e Localização Auditiva</h2>
                        <span class="channel-badge">📺 Canal: Comitê Paralímpico Brasileiro</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            A comissão técnica demonstra a ciência por trás da bola com guizos e o papel do "chamador" (guia que fica atrás do gol adversário).
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Desenvolvimento extremo da audição tridimensional (ecolocalização), velocidade de explosão muscular e tomada rápida de decisão.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Uso obrigatório de óculos de proteção/vendas almofadadas para proteção ocular contra choques diretos cabeça com cabeça.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Coordenadores Técnicos Paralímpicos</span>
                </div>
            </article>

            <!-- CARD 7: BOCHA PARALÍMPICA -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSTxozklf4o7Jp8f6v6P_JlafdqvUyTjDuv3A&s" alt="Jogo de bocha paralímpica">
                </div>
                <a href="https://youtu.be/gLBvgURiqBU" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Paralisia Cerebral Severa</span>
                        <h2>Bocha: Engenharia de Calhas e Suportes</h2>
                        <span class="channel-badge">📺 Canal: Comitê Paralímpico Brasileiro</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Terapeutas ocupacionais explicam o funcionamento prático das calhas adaptadas e ponteiras para atletas com limitações motoras severas.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Treinamento de precisão milimétrica, controle consciente de espasmos, desenvolvimento de raciocínio lógico e geometria espacial.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Ajuste ergonômico cuidadoso dos estabilizadores de pescoço e tronco na cadeira para prevenir quadros de fadiga central crônica.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Terapeutas Ocupacionais e Auxiliares Técnicos</span>
                </div>
            </article>

            <!-- CARD 8: ATLETISMO -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://i.ytimg.com/vi/Zl5LzCaV33k/hq720.jpg?sqp=-oaymwE7CK4FEIIDSFryq4qpAy0IARUAAAAAGAElAADIQj0AgKJD8AEB-AH-CYAC0AWKAgwIABABGHIgTSg8MA8=&rs=AOn4CLBmpJnJEFVi-HIA9VNNWNh7ww-M-A" alt="Pista de atletismo paralímpico">
                </div>
                <a href="https://youtu.be/Zl5LzCaV33k?si=RNhD3YBZrpAJqw3i" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Deficiência Visual</span>
                        <h2>A Ciência e Regras da Corrida Guiada</h2>
                        <span class="channel-badge">📺 Canal: Manual do Mundo</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Iberê Thenório conversa com treinadores e atletas paralímpicos para testar e explicar a física e as regras da corrida com corda-guia na pista de atletismo.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
                            Ganho extremo de potência muscular nas pernas, excelente resposta cardiovascular e quebra de bloqueios de medo espacial.
                        </div>
                        <div class="info-topic alert-topic">
                            <strong>⚠️ Cuidados Importantes:</strong>
                            Guia e atleta devem possuir alturas e tamanhos de passadas compatíveis para mitigar riscos de desequilíbrio e quedas na pista.
                        </div>
                    </div>
                </a>
                <div class="card-footer">
                    <span>👤 Explicado por: Iberê Thenório e Treinadores Olímpicos/Paralímpicos</span>
                </div>
            </article>

            <!-- CARD 9: VOLEIBOL SENTADO -->
            <article class="content-card">
                <div class="card-image-wrapper">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRg0aZt8NBZ0TDVkh0F7QhYsgtl0GDBq4b3Tw&s" alt="Quadra de voleibol sentado">
                </div>
                <a href="https://youtu.be/5mqj6MzpX-w" target="_blank" class="card-link-area">
                    <div class="card-body">
                        <span class="deficiency-tag">Deficiência Locomotora / Amputados</span>
                        <h2>Regras e Movimentação no Vôlei Sentado</h2>
                        <span class="channel-badge">📺 Canal: Comitê Paralímpico Brasileiro</span>
                        
                        <div class="info-topic">
                            <strong>📹 O que tem no vídeo:</strong>
                            Profissionais explicam a dinâmica cinesiológica de locomoção usando apenas os braços e o tronco mantendo o quadril obrigatoriamente no solo.
                        </div>
                        <div class="info-topic">
                            <strong>✨ Benefícios Físicos e Mentais:</strong>
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

    <script>
        // Função de Alto Contraste adaptada
        function alterarContraste() {
            document.body.classList.toggle('alto-contraste');
        }

        // Função de Fonte Acessível (Arial Limpo para Dislexia)
        function alterarFonte() {
            document.body.classList.toggle('fonte-dislexia');
        }

        // Destaque dinâmico do menu
        const links = document.querySelectorAll('nav a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>