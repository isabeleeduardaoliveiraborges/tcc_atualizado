// Função para simular o clique nos filtros do mapa
function filtrar(tipo) {
    const mapaTexto = document.querySelector('.map-placeholder p');
    
    // Atualiza o texto do mapa fingindo que está aplicando a busca
    if (tipo === 'cadeirante') {
        mapaTexto.innerHTML = "📍 Mostrando academias com rampas e banheiros acessíveis...";
    } else if (tipo === 'mental') {
        mapaTexto.innerHTML = "📍 Mostrando dojôs com suporte a Autismo, Síndrome de Down e TDAH...";
    } else if (tipo === 'jiujitsu') {
        mapaTexto.innerHTML = "📍 Filtrando por locais que oferecem Para-Jiu-Jitsu...";
    } else if (tipo === 'boxe') {
        mapaTexto.innerHTML = "📍 Filtrando por locais com treinos adaptados de Boxe/Muay Thai...";
    }
}

// Recurso de Acessibilidade 1: Mudar a fonte para leitura fácil (Dislexia)
function alterarFonte() {
    document.body.classList.toggle('fonte-dislexia');
}

// Recurso de Acessibilidade 2: Ativar o modo de Alto Contraste
function alterarContraste() {
    document.body.classList.toggle('alto-contraste');
}
// --- LÓGICA DO MODAL DE PROFISSIONAIS ---
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-perfil');
    const btnFechar = document.querySelector('.modal-close');
 
    // Abre o modal ao clicar em qualquer botão de profissional
    document.querySelectorAll('.btn-modal-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('modal-foto').src        = btn.dataset.foto;
            document.getElementById('modal-foto').alt        = btn.dataset.nome;
            document.getElementById('modal-nome').textContent         = btn.dataset.nome;
            document.getElementById('modal-cargo').textContent        = btn.dataset.cargo;
            document.getElementById('modal-especializacao').textContent = btn.dataset.especializacao;
            document.getElementById('modal-experiencia').textContent  = btn.dataset.experiencia;
            document.getElementById('modal-modalidades').textContent  = btn.dataset.modalidades;
            document.getElementById('modal-estilo').textContent       = btn.dataset.estilo;
            document.getElementById('modal-biografia').textContent    = btn.dataset.biografia;
            document.getElementById('modal-whatsapp').href =
                'https://wa.me/' + btn.dataset.whatsapp;
 
            modal.classList.add('active');
        });
    });
 
    // Fecha ao clicar no X
    if (btnFechar) {
        btnFechar.addEventListener('click', function () {
            modal.classList.remove('active');
        });
    }
 
    // Fecha ao clicar fora do modal
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
 
    // Fecha com a tecla ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            modal.classList.remove('active');
        }
    });
})

document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sportCards = document.querySelectorAll('.sport-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // 1. Remove classe 'active' de todos os botões e adiciona no clicado
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // 2. Pega o valor do filtro selecionado
            const filterValue = button.getAttribute('data-filter');

            // 3. Mostra ou oculta os cards baseado na categoria
            sportCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');

                if (filterValue === 'todos' || filterValue === cardCategory) {
                    card.style.display = 'flex'; // Exibe o card
                } else {
                    card.style.display = 'none'; // Oculta o card
                }
            });
        });
    });
});
