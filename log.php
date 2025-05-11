<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/app.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>Apadrinhar: Login</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h2 class="text-center mb-4">Login</h2>
                <?php
                if (isset($_GET['erro']) && $_GET['erro'] == 'login') {
                ?>
                    <div class="alert alert-danger" role="alert">
                        Usuário e/ou senha incorretos!
                    </div>
                <?php
                }
                ?>
                <form action="login.php" class="needs-validation" id="log" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="text" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Digite seu usuário" required>
                        <div class="invalid-feedback">
                            Por favor, insira um usuário válido.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
                        <div class="invalid-feedback">
                            Por favor, insira sua senha.
                        </div>
                    </div>
                    <button type="submit" name="log" class="btn btn-primaryBlue w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</body>

</html>