<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/apadrinhadoController.php';
$apadrinhadoController = new ApadrinhadoController();
$apadrinhado = $apadrinhadoController->search_by_id($_GET['id']);
$redes_sociais = $apadrinhadoController->search_socials_by_id($_GET['id']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/discipuladoController.php';
$discipuladoController = new DiscipuladoController();
$ultimo_discipulado = $discipuladoController->search_latest_apadrinhado($_GET['id']);

$idade = date_diff(date_create($apadrinhado['nascimento_apadrinhado']), date_create('now'))->y;
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
                <h1 class="fw-semibold text-white display-4"><?php echo $apadrinhado['nome_apadrinhado'] ?></h1>
            </div>
        </section>
        <div class="container px-5">
            <h2 class="fw-semibold border-3 border-bottom pb-2">Dados Pessoais</h2>
            <div class="row mb-4">
                <div class="col-12 col-md-8 text-start">
                    <p><strong>Nome Completo:</strong> <?php echo $apadrinhado['nome_apadrinhado'] ?></p>
                    <p><strong>Data de Nascimento:</strong> <?php echo date('d/m/Y', strtotime($apadrinhado['nascimento_apadrinhado'])) . ' (' . $idade . ' anos)' ?></p>
                    <p><strong>Telefone:</strong>
                        <?php
                        $telefone = $apadrinhado['telefone_apadrinhado'];
                        $telefoneFormatado = preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
                        echo $telefoneFormatado;
                        ?>
                    </p>
                    <p><strong>Instagram:</strong> <?php echo $redes_sociais['instagram'] ?></p>
                    <p><strong>Facebook:</strong> <?php echo $redes_sociais['facebook'] ?></p>
                    <p><strong>Twitter:</strong> <?php echo $redes_sociais['twitter'] ?></p>
                    <p><strong>TikTok:</strong> <?php echo $redes_sociais['tiktok'] ?></p>
                    <p><strong>Batizado?</strong> <?php if ($apadrinhado['batizado'] == 0) {
                                                        echo 'Não';
                                                    } else {
                                                        echo 'Sim';
                                                    } ?></p>
                    <p><strong>Padrinho:</strong> <?php echo $apadrinhado['nome_padrinho'] ?></p>
                    <p><strong>Voluntário?</strong> <?php if ($apadrinhado['status_voluntario'] == 'nenhum') {
                                                        echo 'Não';
                                                    } else if ($apadrinhado['status_voluntario'] == 'junior') {
                                                        echo 'Junior';
                                                    } else {
                                                        echo 'Oficial';
                                                    } ?></p>
                    <?php
                    if ($apadrinhado['status_voluntario'] == 'junior' || $apadrinhado['status_voluntario'] == 'oficial') {
                        $ministerios = $apadrinhadoController->search_ministerios_by_id($_GET['id']);

                        if (!empty($ministerios)) {
                            $nomesMinisterios = array_column($ministerios, 'nome_ministerio');
                            echo '<p><strong>Ministérios:</strong> ' . implode(', ', $nomesMinisterios) . '</p>';
                        } else {
                            echo '<p><strong>Ministérios:</strong> Não Especificados</p>';
                        }
                    }
                    ?>
                </div>
                <div class="col-12 col-md-4">
                    <?php
                    $id_apadrinhado = $apadrinhado['id_apadrinhado'];
                    $imageDir = 'assets/uploadsApadrinhados/';
                    $defaultImage = 'assets/img/default-user.png';
                    $userImage = $imageDir . "user_{$id_apadrinhado}.png";
                    if (!file_exists($userImage)) {
                        $userImage = $defaultImage;
                    }
                    ?>
                    <img src="<?php echo $userImage; ?>" alt="Usuário" class="w-100 mb-3">
                    <p><strong>Descrição do Apadrinhado:</strong> <?php echo $apadrinhado['descricao_apadrinhado'] ?></p>
                </div>
            </div>
            <h2 class="fw-semibold border-3 border-bottom pb-2">Análise de Personalidade:</h2>
            <div class="row mb-4">
                <p>
                    <span class="fs-5 fw-semibold">Comportamento: <?php echo $apadrinhado['nome_comportamento'] ?></span><br>
                    <?php echo $apadrinhado['descricao_comportamento'] ?>
                </p>
                <p>
                    <span class="fs-5 fw-semibold">Temepramento: <?php echo $apadrinhado['nome_temperamento'] ?></span><br>
                    <?php echo $apadrinhado['descricao_temperamento'] ?>
                </p>
                <p>
                    <span class="fs-5 fw-semibold">Linguagem de Amor: <?php echo $apadrinhado['nome_linguagem'] ?></span><br>
                    <?php echo $apadrinhado['descricao_linguagem'] ?>
                </p>
            </div>
            <h2 class="fw-semibold border-3 border-bottom pb-2">Último Discipulado:</h2>
            <div class="row mb-4">
                <p><strong>Padrinho:</strong> <?php echo $ultimo_discipulado['nome_padrinho']; ?></p>
                <p><strong>Data do Discipulado:</strong> <?php echo date('d/m/Y', strtotime($ultimo_discipulado['data_discipulado'])); ?></p>
                <p><strong>Local do Discipulado:</strong> <?php echo $ultimo_discipulado['local_discipulado']; ?></p>
                <p><strong>Descrição do Discipulado:</strong> <?php echo $ultimo_discipulado['descricao_discipulado']; ?></p>
            </div>
            <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'apadrinhados.php' ?>" class="btn btn-primaryBrown mb-4">Voltar</a>
        </div>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="assets/js/jquerymasks_implementation.js"></script>
</body>

</html>