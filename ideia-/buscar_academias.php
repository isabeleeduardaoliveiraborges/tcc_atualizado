<?php
// buscar_academias.php
header('Content-Type: application/json; charset=utf-8');

// Configurações do seu banco de dados MySQL
$host = 'localhost';
$dbname = 'adaptmove_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    if (!empty($tipo)) {
        // Query utilizando Prepared Statements para evitar SQL Injection
        $stmt = $pdo->prepare("SELECT icone, descricao, status_info FROM academias WHERE tipo_filtro = :tipo");
        $stmt->execute(['tipo' => $tipo]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            echo json_encode($resultado);
            exit;
        }
    }

    // Retorno padrão caso não encontre o filtro solicitado
    echo json_encode([
        'icone' => '📍',
        'descricao' => 'Selecione um filtro acima para localizar os dojôs e academias parceiras.',
        'status_info' => 'Aguardando seleção de categoria...'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'icone' => '⚠️',
        'descricao' => 'Erro ao conectar ao banco de dados.',
        'status_info' => 'Por favor, verifique sua conexão.'
    ]);
}
?>