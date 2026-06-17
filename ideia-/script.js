// script.js

// Função que substitui os textos estáticos por dados reais do Banco de Dados via PHP (AJAX/Fetch)
function filtrar(tipo, btn) {
    // 1. Gerencia as classes visuais dos botões ativos da seção do mapa
    if (btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // 2. Faz a chamada ao backend PHP passando o parâmetro de filtro
    fetch(`buscar_academias.php?tipo=${tipo}`)
        .then(response => {
            if (!response.ok) throw new Error('Erro na comunicação com o servidor.');
            return response.json();
        })
        .then(data => {
            // 3. Atualiza os elementos da seção do mapa dinamicamente
            const mapIcon = document.querySelector('.map-icon');
            const mapText = document.getElementById('map-text');
            const mapSub = document.getElementById('map-sub');

            if (mapIcon) mapIcon.textContent = data.icone;
            if (mapText) mapText.textContent = data.descricao;
            if (mapSub)  mapSub.textContent = data.status_info;
        })
        .catch(error => {
            console.error('Erro ao buscar dados:', error);
            const mapText = document.getElementById('map-text');
            if (mapText) mapText.textContent = "Não foi possível carregar os dados agora.";
        });
}

// Recursos Globais de Acessibilidade Visual
function alterarFonte() {
    document.body.classList.toggle('fonte-dislexia');
}

function alterarContraste() {
    document.body.classList.toggle('alto-contraste');
}

// Lógica Unificada do Modal de Profissionais
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-perfil');
    const btnFechar = document.querySelector('.modal-close');
    const cards = document.querySelectorAll('.card-click'); // Seletor ajustado para bater com a página de profissionais
 
    if (cards.length > 0 && modal) {
        cards.forEach(function (card) {
            card.addEventListener('click', function () {
                document.getElementById('m-foto').src = card.getAttribute('data-foto');
                document.getElementById('m-foto').alt = card.getAttribute('data-nome');
                document.getElementById('m-nome').innerText = card.getAttribute('data-nome');
                document.getElementById('m-cargo').innerText = card.getAttribute('data-cargo');
                document.getElementById('m-biografia').innerText = card.getAttribute('data-biografia');
                document.getElementById('m-especializacao').innerText = card.getAttribute('data-especializacao');
                document.getElementById('m-estilo').innerText = card.getAttribute('data-estilo');
                document.getElementById('m-metas').innerText = card.getAttribute('data-metas');
                document.getElementById('m-agendamento').innerText = card.getAttribute('data-agendamento');
                
                const wppLink = "https://api.whatsapp.com/send?phone=" + card.getAttribute('data-whatsapp') + "&text=Olá! Gostaria de agendar uma avaliação com você.";
                document.getElementById('m-whatsapp').href = wppLink;
     
                modal.classList.add('active');
            });
        });
    }
 
    if (btnFechar && modal) {
        btnFechar.addEventListener('click', () => modal.classList.remove('active'));
    }
 
    window.addEventListener('click', (e) => { 
        if (modal && e.target === modal) modal.classList.remove('active'); 
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal) {
            modal.classList.remove('active');
        }
    });
});

// Filtros Locais para Cards Estáticos (Página Recomendados)
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn-sport');
    const sportCards = document.querySelectorAll('.sport-card');

    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.add('active');

                const filterValue = button.getAttribute('data-filter');

                sportCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category');
                    if (filterValue === 'todos' || filterValue === cardCategory) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
});