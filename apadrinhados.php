<?php
session_start();
if (isset($_SESSION['id_padrinho']) && isset($_SESSION['usuario']) && isset($_SESSION['nome'])) {
    $primeiroNome = explode(' ', $_SESSION['nome'])[0];
} else {
    header('Location: logout.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/juventude/controller/apadrinhadoController.php';
$apadrinhadoController = new ApadrinhadoController();

$apadrinhados = [];
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $apadrinhados = $apadrinhadoController->search_by_name($_GET['search']);
} else {
    $apadrinhados = $apadrinhadoController->list_all();
}
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
                <h1 class="fw-semibold text-white display-4">Apadrinhados</h1>
            </div>
        </section>
        <div class="container px-4">
            <div class="input-group mb-5">
                <form action="apadrinhados.php" method="GET" class="d-flex w-100">
                    <input type="text" class="form-control rounded-start-pill" name="search" placeholder="Insira o nome de um apadrinhado para buscar" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" aria-label="search">
                    <button class="btn btn-primaryBlue rounded-end-pill" type="submit"><i class="bi bi-search me-1"></i></button>
                </form>
            </div>
            <div class="card mb-5">
                <div class="card-header bg-primaryBrown text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Apadrinhados</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                <?php foreach ($apadrinhados as $apadrinhado) { ?>
                                    <tr>
                                        <?php
                                        $id_apadrinhado = $apadrinhado['id_apadrinhado'];
                                        $imageDir = 'assets/uploadsApadrinhados/';
                                        $defaultImage = 'assets/img/default-user.png';
                                        $userImage = $imageDir . "user_{$id_apadrinhado}.png";
                                        if (!file_exists($userImage)) {
                                            $userImage = $defaultImage;
                                        }
                                        ?>
                                        <td><a href="#" data-id="<?php echo $apadrinhado['id_apadrinhado']; ?>" data-nome="<?php echo $apadrinhado['nome_apadrinhado']; ?>" data-telefone="<?php echo $apadrinhado['telefone_apadrinhado']; ?>" data-imagem="<?php echo $userImage; ?>" data-padrinho="<?php echo $apadrinhado['id_padrinho']; ?>" data-bs-toggle="modal" data-bs-target="#modal_perfil"><img src="<?php echo $userImage; ?>" alt="Usuário" class="rounded-5 me-2" width="40" height="40"></a></td>
                                        <td><?php echo $apadrinhado['nome_apadrinhado']; ?></td>
                                        <td>
                                            <?php
                                            $telefone = $apadrinhado['telefone_apadrinhado'];
                                            $telefoneFormatado = preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
                                            echo $telefoneFormatado;
                                            ?>
                                        </td>
                                        <td><?php echo 'Padrinho: ' . $apadrinhado['nome_padrinho']; ?></td>
                                        <td><?php switch ($apadrinhado['status_voluntario']) {
                                                case 'nenhum':
                                                    echo 'Não';
                                                    break;
                                                case 'junior':
                                                    echo 'Voluntário Junior';
                                                    break;
                                                case 'oficial':
                                                    echo 'Voluntário Oficial';
                                                    break;
                                                default:
                                                    echo 'Não informado';
                                                    break;
                                            } ?></td>
                                        <td>
                                            <?php if ($_SESSION['status'] == 'administrador') { ?>
                                                <a href="editar_apadrinhado.php?id=<?php echo $apadrinhado['id_apadrinhado']; ?>" class="btn btn-outline-secondaryBlue me-5"><i class="bi bi-pencil-square"></i></a>
                                                <button data-bs-toggle="modal" data-bs-target="#modal" data-id="<?php echo $apadrinhado['id_apadrinhado']; ?>" class="btn btn-outline-secondaryBrown"><i class="bi bi-trash"></i></button>
                                            <?php } else if ($_SESSION['id_padrinho'] == $apadrinhado['id_padrinho']) { ?>
                                                <a href="editar_apadrinhado.php?id=<?php echo $apadrinhado['id_apadrinhado']; ?>" class="btn btn-outline-secondaryBlue me-5"><i class="bi bi-pencil-square"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Excluir Apadrinhado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que quer fazer isso? Essa ação é irreversível, e ao excluir um apadrinhado, excluirá todos os seus discipulados e feedbacks.</p>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_perfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Perfil de Apadrinhado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="<?php echo $userImage; ?>" alt="Usuário" class="w-50 img-fluid mb-3">
                    <p class="mb-2"><strong>Nome:</strong> Nome do Apadrinhado</p>
                    <p class="mb-2"><strong>Telefone:</strong> Telefone do Apadrinhado</p>
                    <a class="mb-3 d-block" href="consultar_apadrinhado?id">Ver mais informações do Apadrinhado</a>
                    <input type="file" id="input-image" accept="image/*" class="form-control mt-3">
                    <div id="cropper-container" class="mt-3" style="display: none;">
                        <img id="cropper-image" alt="Imagem do Apadrinhado" class="img-fluid rounded mx-auto" style="width: 50%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" id="crop-image-btn" class="btn btn-primaryBrown" disabled>Confirmar nova Foto</button>
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
        $('#modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id_apadrinhado = button.data('id');

            var modal = $(this);
            modal.find('.modal-footer').html(`
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <a href="controller/apadrinhadoController.php?action=delete&id=${id_apadrinhado}" class="btn btn-primaryBrown">Excluir Apadrinhado</a>
            `)
        });
    </script>
    <script>
        $('#modal_perfil').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id_apadrinhado = button.data('id');
            var nome_apadrinhado = button.data('nome');
            var telefone_apadrinhado = button.data('telefone');
            var imagem_apadrinhado = button.data('imagem');
            var id_padrinho = button.data('padrinho');

            var modal = $(this);

            // Atualiza o cabeçalho do modal
            modal.find('.modal-header').html(`
            <h1 class="modal-title fs-4 fw-bold" id="exampleModalLabel">Perfil de ${nome_apadrinhado}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            `);

            // Atualiza o corpo do modal
            modal.find('.modal-body').html(`
            <img src="${imagem_apadrinhado}" alt="Usuário" class="w-50 img-fluid mb-3">
            <p class="mb-2"><strong>Nome:</strong> ${nome_apadrinhado}</p>
            <p class="mb-2"><strong>Telefone:</strong> ${telefone_apadrinhado}</p>
            <a class="mb-3 d-block" href="consultar_apadrinhado.php?id=${id_apadrinhado}">Ver mais informações do Apadrinhado</a>
            <hr>
            <p class="text-start">Para alterar a foto de perfil, envie uma nova abaixo:</p>
            <input type="file" id="input-image" accept="image/*" class="form-control mt-3">
            <div id="cropper-container" class="mt-3" style="display: none;">
                <img id="cropper-image" alt="Imagem do Apadrinhado" class="img-fluid rounded mx-auto" style="width: 50%;">
            </div>
            `);

            // Atualiza o rodapé do modal
            modal.find('.modal-footer').html(`
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="button" id="crop-image-btn" class="btn btn-primaryBrown" disabled>Confirmar nova Foto</button>
            `);

            // Inicialização do Cropper.js
            var cropper;
            $('#input-image').off('change').on('change', function(event) {
                var file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cropper-image')
                            .attr('src', e.target.result)
                            .css('display', 'block'); // Mostra a imagem após carregada
                        $('#cropper-container').css('display', 'block'); // Exibe o container do Cropper

                        if (cropper) cropper.destroy(); // Destroi o Cropper anterior

                        cropper = new Cropper(document.getElementById('cropper-image'), {
                            aspectRatio: 1,
                            viewMode: 2,
                            dragMode: 'move',
                            responsive: true,
                            autoCropArea: 1,
                            zoomable: true,
                            scalable: true,
                        });

                        $('#crop-image-btn').prop('disabled', false); // Habilita o botão de confirmar
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Por favor, selecione uma imagem válida.');
                }
            });

            // Botão para confirmar o corte
            $('#crop-image-btn').off('click').on('click', function() {
                if (cropper) {
                    var canvas = cropper.getCroppedCanvas({
                        width: 500,
                        height: 500
                    });

                    canvas.toBlob(function(blob) {
                        var formData = new FormData();
                        formData.append('image', blob);
                        formData.append('id_apadrinhado', id_apadrinhado);

                        $.ajax({
                            url: 'assets/php/upload_image_apadrinhado.php',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                window.location.href = 'apadrinhados.php';
                            },
                            error: function(xhr) {
                                window.location.href = 'apadrinhados.php';
                            },
                        });
                    }, 'image/png');
                }
            });

            // Limpeza ao fechar o modal
            $('#modal_perfil').on('hidden.bs.modal', function() {
                if (cropper) cropper.destroy();
                cropper = null;
                $('#cropper-container').css('display', 'none'); // Oculta o container
                $('#cropper-image').attr('src', ''); // Limpa a imagem
            });
        });
    </script>
</body>

</html>