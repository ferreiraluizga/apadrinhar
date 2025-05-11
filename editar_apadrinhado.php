<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/comportamentoController.php';
$comportamentoController = new ComportamentoController();
$comportamentos = $comportamentoController->list_all();

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/temperamentoController.php';
$temperamentoController = new TemperamentoController();
$temperamentos = $temperamentoController->list_all();

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/linguagem_amorController.php';
$linguagemController = new LinguagemController();
$linguagens = $linguagemController->list_all();

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/padrinhoController.php';
$padrinhoController = new PadrinhoController();
$padrinhos = $padrinhoController->list_all();

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/ministerioController.php';
$ministerioController = new MinisterioController();
$ministerios = $ministerioController->list_all();

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/apadrinhadoController.php';
$apadrinhadoController = new ApadrinhadoController();
$apadrinhado = $apadrinhadoController->search_by_id($_GET['id']);
$redes_sociais = $apadrinhadoController->search_socials_by_id($_GET['id']);
$ministerios_apadr = $apadrinhadoController->search_ministerios_by_id($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/app.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>Apadrinhar</title>

    <style>
        .main-content {
            margin-left: 0;
            margin-top: 60px;
        }

        @media (min-width: 1400px) {
            .main-content {
                margin-left: 18vw;
                margin-top: 0;
            }
        }

        .banner {
            background-image: url(assets/img/banner_apadrinhados.png);
            background-size: cover;
            background-position: center;
            height: 50dvh;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="d-none d-xxl-block">
        <aside class="d-flex flex-column text-white bg-primaryBlue flex-shrink-0 p-3 shadow-lg position-fixed"
            style="width: 18vw; height: 100vh;">
            <a class="navbar-brand text-center" href="index.php" style="margin-bottom: 1vw; margin-top: 1vw;">
                <img src="assets/img/logo.png" alt="Logo" height="170" class="d-inline-block align-text-top">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" style="margin-top: 1vw; ">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white">
                        <i class="bi bi-house-fill me-2"></i>
                        Home
                    </a>
                </li>
                <?php
                if ($_SESSION['status'] == 'administrador') { ?>
                    <a href="padrinhos.php" class="nav-link text-white">
                        <i class="bi bi-person-fill me-2"></i>
                        Padrinhos
                    </a>
                    <li class="nav-item">
                        <a href="#apadrinhadosSubMenu" data-bs-toggle="collapse" class="nav-link text-white dropdown-toggle">
                            <i class="bi bi-people-fill me-2"></i>
                            Apadrinhados
                        </a>
                        <div class="collapse" id="apadrinhadosSubMenu">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-4 small">
                                <li><a href="cadastrar_apadrinhado.php" class="nav-link text-white">Cadastrar Apadrinhado</a></li>
                                <li><a href="apadrinhados.php" class="nav-link text-white">Consultar Apadrinhados</a></li>
                            </ul>
                        </div>
                    </li>
                <?php } else { ?>
                    <a href="apadrinhados.php" class="nav-link text-white">
                        <i class="bi bi-people-fill me-2"></i>
                        Apadrinhados
                    </a>
                    <a href="mensagens.php" class="nav-link text-white">
                        <i class="bi bi-chat-dots-fill me-2"></i>
                        Mensagens
                    </a>
                <?php } ?>
                <li class="nav-item">
                    <a href="#discipuladosSubMenu" data-bs-toggle="collapse" class="nav-link text-white dropdown-toggle">
                        <i class="bi bi-file-earmark-person-fill me-2"></i>
                        Discipulados
                    </a>
                    <div class="collapse" id="discipuladosSubMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-4 small">
                            <li><a href="cadastrar_discipulado.php" class="nav-link text-white">Novo Discipulado</a></li>
                            <li><a href="discipulados.php" class="nav-link text-white">Consultar Discipulados</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
            <hr>
            <div class="dropdown-center mt-2 d-flex justify-content-center">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    $userId = $_SESSION['id_padrinho'];
                    $imageDir = 'assets/uploadsPadrinhos/';
                    $defaultImage = 'assets/img/default-user.png';
                    $userImage = $imageDir . "user_{$userId}.png";
                    if (!file_exists($userImage)) {
                        $userImage = $defaultImage;
                    }
                    ?>
                    <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2" width="40" height="40">
                    <strong class="nome"><?php echo $primeiroNome ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="minha_conta.php">Minha Conta</a></li>
                    <li><a class="dropdown-item" href="meus_apadrinhados.php">Meus Apadrinhados</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </aside>
    </div>

    <!-- Mobile Navbar -->
    <nav class="navbar p-3 d-block d-xxl-none navbar-dark bg-primaryBlue shadow-lg fixed-top">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="col-4 text-start">
                <a class="navbar-brand text-center" href="index.php">
                    <img src="assets/img/logo.png" alt="Logo" height="40">
                </a>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2" width="40" height="40">
                        <strong class="nome"><?php echo $primeiroNome ?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUserMobile">
                        <li><a class="dropdown-item" href="minha_conta.php">Minha Conta</a></li>
                        <li><a class="dropdown-item" href="meus_apadrinhados.php">Meus Apadrinhados</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-4 text-end">
                <button class="btn border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fs-3 text-white bi bi-list"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Offcanvas -->
    <div class="offcanvas offcanvas-end text-bg-primaryBlue" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white">
                        <i class="bi bi-house-fill me-2"></i>
                        Home
                    </a>
                </li>
                <?php
                if ($_SESSION['status'] == 'administrador') { ?>
                    <a href="padrinhos.php" class="nav-link text-white">
                        <i class="bi bi-person-fill me-2"></i>
                        Padrinhos
                    </a>
                    <li class="nav-item">
                        <a href="#apadrinhadosSubMenu" data-bs-toggle="collapse" class="nav-link text-white dropdown-toggle">
                            <i class="bi bi-people-fill me-2"></i>
                            Apadrinhados
                        </a>
                        <div class="collapse" id="apadrinhadosSubMenu">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-4 small">
                                <li><a href="cadastrar_apadrinhado.php" class="nav-link text-white">Cadastrar Apadrinhado</a></li>
                                <li><a href="apadrinhados.php" class="nav-link text-white">Consultar Apadrinhados</a></li>
                            </ul>
                        </div>
                    </li>
                <?php } else { ?>
                    <a href="apadrinhados.php" class="nav-link text-white">
                        <i class="bi bi-people-fill me-2"></i>
                        Apadrinhados
                    </a>
                    <a href="mensagens.php" class="nav-link text-white">
                        <i class="bi bi-chat-dots-fill me-2"></i>
                        Mensagens
                    </a>
                <?php } ?>
                <li class="nav-item">
                    <a href="#discipuladosSubMenu" data-bs-toggle="collapse" class="nav-link text-white dropdown-toggle">
                        <i class="bi bi-file-earmark-person-fill me-2"></i>
                        Discipulados
                    </a>
                    <div class="collapse" id="discipuladosSubMenu">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ps-4 small">
                            <li><a href="cadastrar_discipulado.php" class="nav-link text-white">Novo Discipulado</a></li>
                            <li><a href="discipulados.php" class="nav-link text-white">Consultar Discipulados</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="main-content">
        <section class="banner d-flex justify-content-start align-items-end p-4 mb-5">
            <div class="container">
                <h1 class="fw-semibold text-white display-4">Atualizar dados do Apadrinhado</h1>
            </div>
        </section>
        <div class="container px-4">
            <form method="post" class="row g-3 needs-validation" novalidate action="controller/apadrinhadoController.php?action=update&id=<?php echo $_GET['id']; ?>" id="apadrinhado" enctype="multipart/form-data">
                <div class="col-12 col-md-8">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome do apadrinhado" value="<?php echo $apadrinhado['nome_apadrinhado']; ?>" required>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="phone" class="form-label">Celular</label>
                    <input type="text" class="form-control" name="phone" id="phone" pattern="\(\d{2}\) \d{4,5}-\d{4}" placeholder="Digite o telefone do apadrinhado" value="<?php echo $apadrinhado['telefone_apadrinhado']; ?>" required>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="nasc" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="nasc" name="nasc" value="<?php echo $apadrinhado['nascimento_apadrinhado']; ?>" required>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="mensal" class="form-label">Batizado?</label>
                    <select class="form-select" id="batizado" name="batizado" required>
                        <option value="" disabled>Selecione uma Opção</option>
                        <option value="0" <?php if ($apadrinhado['batizado'] == 0) {
                                                echo 'selected';
                                            } ?>>Não</option>
                        <option value="1" <?php if ($apadrinhado['batizado'] == 1) {
                                                echo 'selected';
                                            } ?>>Sim</option>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <label for="padrinho" class="form-label">Padrinho</label>
                    <select class="form-select" id="padrinho" name="padrinho" required>
                        <option value="" disabled>Selecione um Padrinho</option>
                        <?php foreach ($padrinhos as $padrinho) { ?>
                            <option value="<?php echo $padrinho['id_padrinho'] ?>" <?php if ($apadrinhado['id_padrinho'] == $padrinho['id_padrinho']) {
                                                                                        echo 'selected';
                                                                                    } ?>><?php echo $padrinho['nome_padrinho']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <label for="instagram" class="form-label">Instagram (Opcional)</label>
                    <input type="text" class="form-control" name="instagram" id="instagram" value="<?php echo $redes_sociais['instagram']; ?>">
                </div>
                <div class="col-12 col-md-3">
                    <label for="facebook" class="form-label">Facebook (Opcional)</label>
                    <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $redes_sociais['facebook']; ?>">
                </div>
                <div class="col-12 col-md-3">
                    <label for="twitter" class="form-label">Twitter (Opcional)</label>
                    <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo $redes_sociais['twitter']; ?>">
                </div>
                <div class="col-12 col-md-3">
                    <label for="tiktok" class="form-label">TikTok (Opcional)</label>
                    <input type="text" class="form-control" name="tiktok" id="tiktok" value="<?php echo $redes_sociais['tiktok']; ?>">
                </div>
                <div class="col-12 col-md-6">
                    <label for="temperamento" class="form-label">Temperamento</label>
                    <select class="form-select" id="temperamento" name="temperamento" required>
                        <option value="" disabled>Selecione um Temperamento</option>
                        <?php foreach ($temperamentos as $temperamento) { ?>
                            <option value="<?php echo $temperamento['id_temperamento'] ?>" <?php if ($apadrinhado['id_temperamento'] == $temperamento['id_temperamento']) {
                                                                                                echo 'selected';
                                                                                            } ?>><?php echo $temperamento['nome_temperamento']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="comportamento" class="form-label">Comportamento</label>
                    <select class="form-select" id="comportamento" name="comportamento" required>
                        <option value="" disabled>Selecione um Comportamento</option>
                        <?php foreach ($comportamentos as $comportamento) { ?>
                            <option value="<?php echo $comportamento['id_comportamento'] ?>" <?php if ($apadrinhado['id_comportamento'] == $comportamento['id_comportamento']) {
                                                                                                    echo 'selected';
                                                                                                } ?>><?php echo $comportamento['nome_comportamento']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="linguagem" class="form-label">Linguagem de Amor</label>
                    <select class="form-select" id="linguagem" name="linguagem" required>
                        <option value="" disabled>Selecione uma Linguagem de Amor</option>
                        <?php foreach ($linguagens as $linguagem) { ?>
                            <option value="<?php echo $linguagem['id_linguagem'] ?>" <?php if ($apadrinhado['id_ling_amor'] == $linguagem['id_linguagem']) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $linguagem['nome_linguagem']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="voluntario" class="form-label">Voluntário?</label>
                    <select class="form-select" id="voluntario" name="voluntario" required>
                        <option value="" disabled>Selecione uma Opção</option>
                        <option value="nenhum" <?php if ($apadrinhado['status_voluntario'] == 'nenhum') {
                                                    echo 'selected';
                                                } ?>>Não</option>
                        <option value="junior" <?php if ($apadrinhado['status_voluntario'] == 'junior') {
                                                    echo 'selected';
                                                } ?>>Junior</option>
                        <option value="oficial" <?php if ($apadrinhado['status_voluntario'] == 'oficial') {
                                                    echo 'selected';
                                                } ?>>Oficial</option>
                    </select>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12" id="ministerios-container" style="display: none;">
                    <label class="form-label">Caso queira, especifique o(s) ministerio(s):</label>
                    <br>
                    <?php foreach ($ministerios as $ministerio) { ?>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="checkbox" name="ministerios[]" value="<?php echo $ministerio['id_ministerio'] ?>" id="ministerios[]" <?php foreach ($ministerios_apadr as $ministerio_apadr) {
                                                                                                                                                                            if ($ministerio_apadr['id_ministerio'] == $ministerio['id_ministerio']) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                            <label class="form-check-label" for="ministerio"><?php echo $ministerio['nome_ministerio'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição do Apadrinhado</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="5" placeholder="Digite a descrição e observações sobre o apadrinhado" required><?php echo $apadrinhado['descricao_apadrinhado']; ?></textarea>
                    <div class="invalid-feedback">
                        Preencha o campo para continuar.
                    </div>
                </div>
                <div class="col-12 mb-5">
                    <button class="btn btn-primaryBrown" id="cadastrar" type="submit">Atualizar dados do Apadrinhado</button>
                </div>
            </form>
        </div>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="assets/js/jquerymasks_implementation.js"></script>
    <script>
        $(document).ready(function() {
            $('#voluntario').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue === 'junior' || selectedValue === 'oficial') {
                    $('#ministerios-container').show();
                } else {
                    $('#ministerios-container').hide();
                }
            });
        });
    </script>
</body>

</html>