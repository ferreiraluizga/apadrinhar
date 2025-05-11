<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

$userId = $_SESSION['id_padrinho'];

$defaultImage = 'assets/img/default-user.png';
$defaultBanner = 'assets/img/default-banner.png';

$imageDir = 'assets/uploadsPadrinhos/';
$userImage = $imageDir . "user_{$userId}.png";
if (!file_exists($userImage)) {
    $userImage = $defaultImage;
}

$bannerDir = 'assets/uploadsPadrinhos/';
$userBanner = $bannerDir . "banner_user_{$userId}.png";
if (!file_exists($userBanner)) {
    $userBanner = $defaultBanner;
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
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/app.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet">
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
            background-image: url(<?php echo $userBanner; ?>);
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
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="fw-semibold text-white display-4">Olá, <?php echo $_SESSION['nome'] ?></h1>
                <button class="btn btn-primaryBrown" data-bs-toggle="modal" data-bs-target="#alterarBannerModal"><i class="bi bi-pencil-square me-2"></i>Alterar Banner</button>
            </div>
        </section>
        <div class="container px-4">
            <h4 class="fw-medium">Alterar Informações de Login</h4>
            <hr>
            <div class="row mb-5">
                <div class="col-12 col-md-8">
                    <form action="controller/padrinhoController.php?action=update&id=<?php echo $_SESSION['id_padrinho'] ?>" method="post">
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $_SESSION['nome'] ?>" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Telefone</label>
                            <input type="text" class="form-control" name="phone" id="phone" pattern="\(\d{2}\) \d{4,5}-\d{4}" value="<?php echo $_SESSION['telefone'] ?>" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="nome" class="form-label">Descrição do Perfil</label>
                            <textarea rows="5" class="form-control" name="descricao" id="descricao"><?php echo $_SESSION['descricao_perfil'] ?></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="linguagem" class="form-label">Linguagem de Amor</label>
                            <select class="form-select" id="linguagem" name="linguagem" required>
                                <option value="" disabled>Selecione uma Linguagem de Amor</option>
                                <?php foreach ($linguagens as $linguagem) {
                                    if ($linguagem['id_linguagem'] == $_SESSION['id_ling_amor']) { ?>
                                        <option value="<?php echo $linguagem['id_linguagem'] ?>" selected><?php echo $linguagem['nome_linguagem']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $linguagem['id_linguagem'] ?>"><?php echo $linguagem['nome_linguagem']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="comportamento" class="form-label">Comportamento</label>
                            <select class="form-select" id="comportamento" name="comportamento" required>
                                <option value="" disabled>Selecione um Comportamento</option>
                                <?php foreach ($comportamentos as $comportamento) {
                                    if ($comportamento['id_comportamento'] == $_SESSION['id_comportamento']) { ?>
                                        <option value="<?php echo $comportamento['id_comportamento'] ?>" selected><?php echo $comportamento['nome_comportamento']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $comportamento['id_comportamento'] ?>"><?php echo $comportamento['nome_comportamento']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="temperamento" class="form-label">Temperamento</label>
                            <select class="form-select" id="temperamento" name="temperamento" required>
                                <option value="" disabled>Selecione um Temperamento</option>
                                <?php foreach ($temperamentos as $temperamento) {
                                    if ($temperamento['id_temperamento'] == $_SESSION['id_temperamento']) { ?>
                                        <option value="<?php echo $temperamento['id_temperamento'] ?>" selected><?php echo $temperamento['nome_temperamento']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $temperamento['id_temperamento'] ?>"><?php echo $temperamento['nome_temperamento']; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primaryBrown">Salvar</button>
                    </form>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <div class="position-relative d-inline-block">
                        <img src="<?php echo $userImage; ?>" alt="Profile picture" class="rounded-circle img-fluid border border-2 w-75">
                        <button class="btn btn-primaryBrown rounded-circle border-0 position-absolute bottom-0 start-50 translate-middle-x" data-bs-toggle="modal" data-bs-target="#alterarImagemModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                    <div class="row mt-3">
                        <a href="alterar_login.php">Alterar Usuário e Senha</a>
                    </div>
                    <div class="row mt-3">
                        <a href="meus_apadrinhados.php">Meus Apadrinhados</a>
                    </div>
                    <div class="row mt-3">
                        <a href="logout.php">Sair da Conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- change banner modal -->
    <div class="modal fade" id="alterarBannerModal" tabindex="-1" aria-labelledby="alterarBannerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alterarBannerLabel">Alterar Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="assets/php/upload_banner_padrinho.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bannerImage" class="form-label">Escolha uma imagem para o banner</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primaryBrown">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- change image modal -->
    <div class="modal fade" id="alterarImagemModal" tabindex="-1" aria-labelledby="alterarImagemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alterarImagemLabel">Alterar Imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="imageInput" class="form-label">Escolha uma Foto de Perfil</label>
                        <input type="file" class="form-control" id="imageInput" accept="image/*">
                    </div>
                    <div class="text-center">
                        <img id="imagePreview" style="max-width: 100%; display: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="cropAndSave" type="button" class="btn btn-primaryBrown" disabled>Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <script src="assets/js/bootstrap_validation.js"></script>
    <script src="assets/js/jquerymasks_implementation.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const cropAndSave = document.getElementById('cropAndSave');
            let cropper = null;

            // Quando o usuário selecionar uma imagem
            imageInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';

                        // Inicializar o Cropper.js
                        if (cropper) {
                            cropper.destroy(); // Destruir o cropper anterior
                        }
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 1, // Proporção 1:1
                            viewMode: 1, // Limitar recorte à imagem visível
                        });

                        // Ativar o botão "Recortar e Salvar"
                        cropAndSave.disabled = false;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Quando o usuário clicar em "Recortar e Salvar"
            cropAndSave.addEventListener('click', () => {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 500, // Largura do recorte
                        height: 500, // Altura do recorte
                    });

                    // Converter para blob e enviar para o servidor
                    canvas.toBlob((blob) => {
                        const formData = new FormData();
                        formData.append('image', blob, 'cropped-image.png');

                        fetch('assets/php/upload_image_padrinho.php', {
                                method: 'POST',
                                body: formData,
                            })
                            .then(response => response.text())
                            .then(data => {
                                alert('Imagem enviada com sucesso!');
                                console.log(data);

                                // Atualizar a imagem de perfil no frontend
                                const profileImage = document.querySelector('.rounded-circle.img-fluid');
                                if (profileImage) {
                                    profileImage.src = URL.createObjectURL(blob);
                                }

                                // Fechar o modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById('alterarImagemModal'));
                                modal.hide();
                            })
                            .catch(error => {
                                console.error('Erro ao enviar a imagem:', error);
                            });
                    });
                }
            });
        });
    </script>
</body>

</html>