<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/discipuladoController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/feedbackController.php';
$discipuladoController = new DiscipuladoController();
$feedbackController = new FeedbackController();
$discipulado = $discipuladoController->search_by_id($_GET['id']);
$feedbacks = $feedbackController->list_all_by_id($_GET['id']);

if ($discipulado['nivel_acesso'] == 'privado') {
    if ($_SESSION['status'] != 'administrador' && $discipulado['id_padrinho'] != $_SESSION['id_padrinho'] && $discipulado['padrinho_apadrinhado'] != $_SESSION['id_padrinho']) {
        header('Location: discipulados.php');
        exit;
    }
}


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
                <?php } ?>
                <a href="mensagens.php" class="nav-link text-white">
                    <i class="bi bi-chat-dots-fill me-2"></i>
                    Mensagens
                </a>
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
                <?php } ?>
                <a href="mensagens.php" class="nav-link text-white">
                    <i class="bi bi-chat-dots-fill me-2"></i>
                    Mensagens
                </a>
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
                <h1 class="fw-semibold text-white display-4">Discipulado</h1>
        </section>
        <div class="container px-5">
            <?php
            $defaultImage = 'assets/img/default-user.png';

            $id_apadrinhado = $discipulado['id_apadrinhado'];
            $apadrinhadoImageDir = 'assets/uploadsApadrinhados/';
            $apadrinhadoImage = $apadrinhadoImageDir . "user_{$id_apadrinhado}.png";
            if (!file_exists($apadrinhadoImage)) {
                $apadrinhadoImage = $defaultImage;
            }

            $id_padrinho = $discipulado['id_padrinho'];
            $imageDir = 'assets/uploadsPadrinhos/';
            $userImage = $imageDir . "user_{$id_apadrinhado}.png";
            if (!file_exists($userImage)) {
                $userImage = $defaultImage;
            }
            ?>
            <div class="row mb-3 justify-content-center align-items-baseline">
                <div class="col-12 col-md-6 text-center">
                    <img src="<?php echo $apadrinhadoImage; ?>" alt="Usuário" class="w-50 mb-3 rounded-circle">
                    <p class="mb-5"><?php echo $discipulado['nome_apadrinhado'] ?></p>
                </div>
                <div class="col-12 col-md-6 text-center">
                    <img src="<?php echo $userImage; ?>" alt="Usuário" class="w-50 mb-3 rounded-circle">
                    <p><?php echo $discipulado['nome_padrinho'] ?></p>
                </div>
            </div>
            <h2 class="fw-semibold border-3 border-bottom pb-2">Sobre o Discipulado:</h2>
            <div class="row mb-4">
                <p><strong>Realizado por:</strong> <?php echo $discipulado['nome_padrinho'] ?></p>
                <p><strong>Apadrinhado envolvido:</strong> <?php echo $discipulado['nome_apadrinhado'] ?></p>
                <p><strong>Data do Discipulado:</strong> <?php echo date('d/m/Y', strtotime($discipulado['data_discipulado'])) ?></p>
                <p><strong>Local do Discipulado:</strong> <?php echo $discipulado['local_discipulado'] ?></p>
                <p><strong>Descrição do Discipulado:</strong> <?php echo $discipulado['descricao_discipulado'] ?></p>
                <p class="small text-muted">Última alteração feita: <?php echo date('d/m/Y | H:i', strtotime($discipulado['data_alteracao'])) ?></p>
            </div>
            <?php if ($_SESSION['id_padrinho'] == $discipulado['id_padrinho'] || $_SESSION['status'] == 'administrador' || $_SESSION['id_padrinho'] == $discipulado['padrinho_apadrinhado']) { ?>
                <h2 class="fw-semibold border-3 border-bottom pb-2">Feedbacks:</h2>
                <div class="row">
                    <?php
                    if (count($feedbacks) > 0) {
                        foreach ($feedbacks as $feedback) {
                            $id_padrinho = $feedback['id_padrinho'];
                            $imageDir = 'assets/uploadsPadrinhos/';
                            $userImage = $imageDir . "user_{$id_padrinho}.png";
                            if (!file_exists($userImage)) {
                                $userImage = $defaultImage;
                            } ?>
                            <div class="col-12 mb-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-start border-4 border-primaryBlue bg-white p-3 rounded shadow">
                                    <div class="col-auto text-center text-md-start me-0 me-md-4 mb-3 mb-md-0">
                                        <img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-circle w-100" style="max-width: 100px;">
                                    </div>
                                    <div class="col">
                                        <div class="text-primaryBlue fw-bold text-uppercase mb-2"><?php echo $feedback['nome_padrinho'] ?></div>
                                        <div class="fs-6 text-wrap mb-2"><?php echo nl2br($feedback['descricao']); ?></div>
                                        <div class="fs-6 mb-2">
                                            <?php switch ($feedback['avaliacao']) {
                                                case 'ruim':
                                                    echo '<span class="fw-bold text-primaryRed">Ruim</span>';
                                                    break;
                                                case 'medio':
                                                    echo '<span class="fw-bold text-primaryYellow">Médio</span>';
                                                    break;
                                                case 'bom':
                                                    echo '<span class="fw-bold text-primaryGreen">Bom</span>';
                                                    break;
                                                default:
                                                    echo '<span>Sem Avaliação</span>';
                                                    break;
                                            } ?>
                                        </div>
                                        <div class="small text-muted">Última alteração em: <?php echo date('d/m/Y, H:i', strtotime($feedback['data_alteracao'])) ?></div>
                                    </div>
                                    <?php if ($_SESSION['id_padrinho'] == $feedback['id_padrinho']) { ?>
                                        <div class="col-auto ms-auto mt-3 mt-md-0">
                                            <a href="controller/feedbackController.php?action=delete&id=<?php echo $feedback['id_feedback'] ?>"
                                                class="btn btn-outline-primaryRed d-flex align-items-center justify-content-center">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col-12">
                            <p>Nenhum feedback encontrado.</p>
                            <?php if ($_SESSION['id_padrinho'] == $discipulado['id_padrinho']) { ?>
                                <p><a href="editar_discipulado.php?id=<?php echo $discipulado['id_discipulado'] ?>">Alterar informações do discipulado</a></p>
                            <?php } ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php } ?>

            <div class="row mb-5">
                <div class="col d-flex justify-content-start align-items-center">
                    <?php if ($_SESSION['status'] == 'administrador') { ?>
                        <button class="btn btn-primaryBlue me-5" data-bs-toggle="modal" data-bs-target="#modal">Adicionar Feedback</button>
                    <?php } ?>
                    <a href="discipulados.php" class="btn btn-primaryBrown">Voltar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Adicionar Feedback</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="controller/feedbackController.php?action=insert" class="needs-validation" novalidate method="post">
                    <div class="modal-body">
                        <div class="col-12 mb-3">
                            <label for="descricao" class="form-label">Comentário</label>
                            <textarea class="form-control" name="descricao" id="descricao" placeholder="Digite o feedback acerca do discipulado" rows="5" required></textarea>
                            <div class="invalid-feedback">
                                Preencha o campo para continuar.
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="avaliacao" class="form-label">Avaliação</label>
                            <select class="form-select" id="avaliacao" name="avaliacao" required>
                                <option value="" selected disabled>Selecione uma Opção</option>
                                <option value="ruim">Ruim</option>
                                <option value="medio">Médio</option>
                                <option value="bom">Bom</option>
                            </select>
                            <div class="invalid-feedback">
                                Preencha o campo para continuar.
                            </div>
                        </div>
                        <div class="col-12 visually-hidden">
                            <input type="text" class="form-control" name="discipulado" id="discipulado" value="<?php echo $discipulado['id_discipulado'] ?>" required>
                            <input type="text" class="form-control" name="padrinho" id="padrinho" value="<?php echo $_SESSION['id_padrinho'] ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primaryBrown" type="submit">Enviar Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="assets/js/jquerymasks_implementation.js"></script>
</body>

</html>