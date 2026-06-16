<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KixiCrédito</title>

    <link rel="stylesheet" href="css/style.css?v=2">
</head>

<body>

    <div class="card">

        <div class="card-header">

            <img src="img/logo.png"
                 alt="Logo KixiCrédito"
                 class="login-logo">

            <h1>Bem-vindo</h1>

            <p>Acede à tua conta para continuar</p>

        </div>

        <form action="login.php" method="POST" class="form">

            <div class="field">
                <label for="username">Utilizador</label>

                <div class="input-wrap">
                    <span class="icon">👤</span>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="O teu nome de utilizador"
                        required>
                </div>
            </div>

            <div class="field">
                <label for="password">Palavra-passe</label>

                <div class="input-wrap">
                    <span class="icon">🔒</span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="A tua palavra-passe"
                        required>
                </div>
            </div>

            <div class="options">

                <label class="remember">
                    <input type="checkbox" name="remember">
                    <span>Lembrar-me</span>
                </label>

                <a href="#" class="forgot">
                    Esqueceu a senha?
                </a>

            </div>

            <button type="submit" class="btn">
                Entrar
            </button>

        </form>

        <p class="register">
            Não tens conta?
            <a href="registrar.php">Regista-te</a>
        </p>

    </div>

</body>
</html>