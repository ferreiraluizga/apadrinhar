<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/discipuladoController.php';
$discipuladoController = new DiscipuladoController();
$discipulados = $discipuladoController->list_all();
$discipulado_mais_recente = $discipuladoController->search_latest();
$meu_discipulado_mais_recente = $discipuladoController->search_my_latest($_SESSION['id_padrinho']);
$discipulados_pendentes = $discipuladoController->search_pending();
$discipulados_respondidos = $discipuladoController->search_completed();
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
            background-image: url(assets/img/banner_discipulados.png);
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
                <h1 class="fw-semibold text-white display-4">Discipulados</h1>
            </div>
        </section>
        <div class="container px-5">
            <?php if ($_SESSION['status'] == 'administrador') { ?>
                <div class="row mb-5">
                    <div class="d-flex justify-content-between align-items-center border-start border-4 border-primaryBrown bg-white p-3 rounded shadow">
                        <div>
                            <div class="text-primaryBrown fw-bold text-lowercase fs-3">Discipulado mais Recente</div>
                            <?php if ($discipulado_mais_recente == null) {
                                echo '<div class="fs-5">Nenhum discipulado disponível.</div>';
                            } else { ?>
                                <div class="fs-5"><strong>Padrinho:</strong> <?php echo $discipulado_mais_recente['nome_padrinho'] ?></div>
                                <div class="fs-5"><strong>Apadrinhado:</strong> <?php echo $discipulado_mais_recente['nome_apadrinhado'] ?></div>
                                <div class="fs-5"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($discipulado_mais_recente['data_discipulado'])) ?></div>
                                <div class="fs-5"><strong>Local:</strong> <?php echo $discipulado_mais_recente['local_discipulado'] ?></div>
                                <div class="fs-5"><a href="consultar_discipulado.php?id=<?php echo $discipulado_mais_recente['id_discipulado'] ?>">ler mais</a></div>
                            <?php } ?>
                        </div>
                        <div class="text-primaryBrown fs-1">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row mb-5">
                <div class="d-flex justify-content-between align-items-center border-start border-4 border-primaryBrown bg-white p-3 rounded shadow">
                    <div>
                        <div class="text-primaryBrown fw-bold text-lowercase fs-3">Meu Discipulado mais Recente</div>
                        <?php if ($meu_discipulado_mais_recente == null) {
                            echo '<div class="fs-5">Nenhum discipulado disponível.</div>';
                        } else { ?>
                            <div class="fs-5"><strong>Padrinho:</strong> <?php echo $meu_discipulado_mais_recente['nome_padrinho'] ?></div>
                            <div class="fs-5"><strong>Apadrinhado:</strong> <?php echo $meu_discipulado_mais_recente['nome_apadrinhado'] ?></div>
                            <div class="fs-5"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($meu_discipulado_mais_recente['data_discipulado'])) ?></div>
                            <div class="fs-5"><strong>Local:</strong> <?php echo $meu_discipulado_mais_recente['local_discipulado'] ?></div>
                            <div class="fs-5"><a href="consultar_discipulado.php?id=<?php echo $meu_discipulado_mais_recente['id_discipulado'] ?>">ler mais</a></div>
                        <?php } ?>
                    </div>
                    <div class="text-primaryBrown fs-1">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['status'] == 'administrador') { ?>
                <hr>
                <h3 class="fw-semibold mb-3">Discipulados Pendentes</h3>
                <div class="row mb-5">
                    <?php if ($meu_discipulado_mais_recente == null) {
                        echo '<p>Nenhum discipulado a ser respondido.</p>';
                    } else {
                        foreach ($discipulados_pendentes as $discipulado) { ?>
                            <div class="col-12 col-md-4">
                                <div class="d-flex justify-content-between align-items-center border-start border-4 border-primaryBlue bg-white p-3 rounded shadow">
                                    <div class="col-10">
                                        <div class="text-primaryBlue fw-bold text-uppercase">Padrinho: <?php echo $discipulado['nome_padrinho'] ?></div>
                                        <div class="fs-6"><strong>Apadrinhado:</strong> <?php echo $discipulado['nome_apadrinhado'] ?></div>
                                        <div class="fs-6"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($discipulado['data_discipulado'])) ?></div>
                                        <div class="fs-6"><strong>Local:</strong> <?php echo $discipulado['local_discipulado'] ?></div>
                                        <div class="fs-6"><a href="consultar_discipulado.php?id=<?php echo $discipulado['id_discipulado'] ?>">ler mais</a></div>
                                    </div>
                                    <div class="col-2">
                                        <?php
                                        $id_padrinho = $_SESSION['id_padrinho'];
                                        $imageDir = 'assets/uploadsPadrinhos/';
                                        $defaultImage = 'assets/img/default-user.png';
                                        $userImage = $imageDir . "user_{$id_padrinho}.png";
                                        if (!file_exists($userImage)) {
                                            $userImage = $defaultImage;
                                        }
                                        ?>
                                        <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2 w-100">
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
                <hr>
                <h3 class="fw-semibold mb-3">Discipulados Respondidos</h3>
                <div class="row mb-5">
                    <?php if ($discipulados_respondidos == null) {
                        echo '<p>Nenhum discipulado respondido.</p>';
                    } else {
                        foreach ($discipulados_respondidos as $discipulado) { ?>
                            <div class="col-12 col-md-4">
                                <div class="d-flex justify-content-between align-items-center border-start border-4 border-primaryGreen bg-white p-3 rounded shadow">
                                    <div class="col-10">
                                        <div class="text-primaryGreen fw-bold text-uppercase">Padrinho: <?php echo $discipulado['nome_padrinho'] ?></div>
                                        <div class="fs-6"><strong>Apadrinhado:</strong> <?php echo $discipulado['nome_apadrinhado'] ?></div>
                                        <div class="fs-6"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($discipulado['data_discipulado'])) ?></div>
                                        <div class="fs-6"><strong>Local:</strong> <?php echo $discipulado['local_discipulado'] ?></div>
                                        <div class="fs-6"><a href="consultar_discipulado.php?id=<?php echo $discipulado['id_discipulado'] ?>">ler mais</a></div>
                                    </div>
                                    <div class="col-2">
                                        <?php
                                        $id_padrinho = $_SESSION['id_padrinho'];
                                        $imageDir = 'assets/uploadsPadrinhos/';
                                        $defaultImage = 'assets/img/default-user.png';
                                        $userImage = $imageDir . "user_{$id_padrinho}.png";
                                        if (!file_exists($userImage)) {
                                            $userImage = $defaultImage;
                                        }
                                        ?>
                                        <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2 w-100">
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            <?php } ?>
            <hr>
            <h3 class="fw-semibold mb-3">Meus Discipulados</h3>
            <div class="row mb-5">
                <?php
                $temDiscipulados = false;

                foreach ($discipulados as $discipulado) {
                    if ($discipulado['id_padrinho'] == $_SESSION['id_padrinho']) {
                        $temDiscipulados = true;
                ?>
                        <div class="col-12 col-md-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center border-start border-4 border-terciaryBlue bg-white p-3 rounded shadow">
                                <div class="col-10">
                                    <div class="text-terciaryBlue fw-bold text-uppercase">Apadrinhado: <?php echo $discipulado['nome_apadrinhado'] ?></div>
                                    <div class="fs-6"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($discipulado['data_discipulado'])) ?></div>
                                    <div class="fs-6"><strong>Local:</strong> <?php echo $discipulado['local_discipulado'] ?></div>
                                    <div class="fs-6">
                                        <strong>Feedback:</strong>
                                        <?php echo ($discipulado['id_feedback'] == null) ? 'Aguardando' : 'Respondido'; ?>
                                    </div>
                                    <div class="fs-6"><a href="consultar_discipulado.php?id=<?php echo $discipulado['id_discipulado'] ?>">ler mais</a></div>
                                </div>
                                <div class="col-2">
                                    <?php
                                    $id_apadrinhado = $discipulado['id_apadrinhado'];
                                    $imageDir = 'assets/uploadsApadrinhados/';
                                    $defaultImage = 'assets/img/default-user.png';
                                    $userImage = $imageDir . "user_{$id_apadrinhado}.png";
                                    if (!file_exists($userImage)) {
                                        $userImage = $defaultImage;
                                    }
                                    ?>
                                    <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2 w-100">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                if (!$temDiscipulados) {
                    ?>
                    <div class="col-12">
                        <p>Nenhum discipulado encontrado.</p>
                    </div>
                <?php
                }
                ?>
            </div>
            <?php if ($_SESSION['status'] == 'comum') { ?>
                <hr>
                <h3 class="fw-semibold mb-3">Outros Discipulados</h3>
                <div class="row mb-5">
                    <?php
                    $temDiscipuladosPublicos = false;

                    foreach ($discipulados as $discipulado) {
                        if ($discipulado['nivel_acesso'] == 'publico' && $discipulado['id_padrinho'] != $_SESSION['id_padrinho']) {
                            $temDiscipuladosPublicos = true;
                    ?>
                            <div class="col-12 col-md-4">
                                <div class="d-flex justify-content-between align-items-center border-start border-4 border-secondaryBrown bg-white p-3 rounded shadow">
                                    <div class="col-10">
                                        <div class="text-secondaryBrown fw-bold text-uppercase">Padrinho: <?php echo $discipulado['nome_padrinho'] ?></div>
                                        <div class="fs-6"><strong>Apadrinhado:</strong> <?php echo $discipulado['nome_apadrinhado'] ?></div>
                                        <div class="fs-6"><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($discipulado['data_discipulado'])) ?></div>
                                        <div class="fs-6"><strong>Local:</strong> <?php echo $discipulado['local_discipulado'] ?></div>
                                        <div class="fs-6"><a href="consultar_discipulado.php?id=<?php echo $discipulado['id_discipulado'] ?>">ler mais</a></div>
                                    </div>
                                    <div class="col-2">
                                        <?php
                                        $id_padrinho = $discipulado['id_padrinho'];
                                        $imageDir = 'assets/uploadsPadrinhos/';
                                        $defaultImage = 'assets/img/default-user.png';
                                        $userImage = $imageDir . "user_{$id_padrinho}.png";
                                        if (!file_exists($userImage)) {
                                            $userImage = $defaultImage;
                                        }
                                        ?>
                                        <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2 w-100">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    if (!$temDiscipuladosPublicos) {
                        ?>
                        <div class="col-12">
                            <p>Nenhum discipulado público disponível.</p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php } ?>

        </div>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="assets/js/jquerymasks_implementation.js"></script>
</body>

</html>