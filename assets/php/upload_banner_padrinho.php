<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o ID do usuário está na sessão
    if (isset($_SESSION['id_padrinho'])) {
        $userId = $_SESSION['id_padrinho'];
    } else {
        die("Erro: ID do usuário não encontrado na sessão.");
    }

    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];

        // Configurações básicas
        $uploadDir = '../uploadsPadrinhos/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Gera o nome do arquivo usando o ID do usuário
        $fileName = "banner_user_{$userId}.png";
        $targetFilePath = $uploadDir . $fileName;

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }
}

