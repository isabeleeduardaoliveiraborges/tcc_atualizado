<?php
// login.php
session_start();

$host = 'localhost';
$dbname = 'adaptmove_db';
$username = 'root';
$password = '';

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if (!empty($email) && !empty($senha)) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Busca o usuário baseado no e-mail fornecido
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Validação direta baseada na estrutura do seu banco de dados
            if ($usuario && ($usuario['senha'] === $senha || password_verify($senha, $usuario['senha']))) {
                
                // Grava as informações REAIS encontradas na tabela 'usuarios'
                $_SESSION['usuario_id']    = $usuario['id_usuario']; 
                $_SESSION['usuario_nome']  = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                
                // Envia diretamente para a página de perfil
                header("Location: perfil.php");
                exit;
            } else {
                $mensagem = "❌ E-mail ou senha incorretos.";
                $tipo_mensagem = "erro";
            }

        } catch (PDOException $e) {
            $mensagem = "🚨 Erro de ligação ao banco de dados: " . $e->getMessage();
            $tipo_mensagem = "erro";
        }
    } else {
        $mensagem = "⚠️ Por favor, preencha todos os campos.";
        $tipo_mensagem = "erro";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AdaptMove</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --bg: #0c0c0f;
            --bg2: #13131a;
            --bg3: #1a1a24;
            --accent: #00e5ff;
            --text: #f0f0f5;
            --muted: #6b6b80;
            --border: rgba(255,255,255,0.07);
        }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: var(--bg2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 30px;
        }
        .logo span { color: var(--accent); }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-group input {
            width: 100%;
            background: var(--bg3);
            border: 1px solid var(--border);
            padding: 14px;
            border-radius: 6px;
            color: var(--text);
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.2);
        }
        .btn-submit {
            width: 100%;
            background: var(--accent);
            color: #000;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover { opacity: 0.9; }
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .alert-erro { background: rgba(255, 23, 68, 0.15); border: 1px solid #ff1744; color: #ff1744; }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="logo">Adapt<span>Move</span></div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-erro">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="teste@adaptmove.com" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="••••••" required>
            </div>

            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>

</body>
</html>