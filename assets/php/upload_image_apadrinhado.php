<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $userId = $_POST['id_apadrinhado'];

    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];

        // Configurações básicas
        $uploadDir = '../uploadsApadrinhados/';

        // Cria o diretório se ele não existir
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Gera o nome do arquivo usando o ID do usuário
        $fileName = "user_{$userId}.png";
        $targetFilePath = $uploadDir . $fileName;

        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            header("Location: ../apadrinhados.php");
        }
    }
}

