<?php
session_start();
require_once('controller/connect.php');

$db = new Connect();

$connect = $db->getConnect();
if (isset($_POST['log'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $passwordhash = md5($_POST['password']);
    $query = "SELECT * FROM padrinho 
            INNER JOIN comportamento ON padrinho.id_comportamento = comportamento.id_comportamento 
            INNER JOIN temperamento ON padrinho.id_temperamento = temperamento.id_temperamento 
            INNER JOIN linguagem_amor ON padrinho.id_ling_amor = linguagem_amor.id_linguagem 
            WHERE usuario = ? AND senha = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ss", $user, $passwordhash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $fetch = $result->fetch_assoc();
        $id_padrinho = $fetch['id_padrinho'];
        $_SESSION['id_padrinho'] = $id_padrinho;
        $_SESSION['nome'] = $fetch['nome_padrinho'];
        $_SESSION['telefone'] = $fetch['telefone_padrinho'];
        $_SESSION['descricao_perfil'] = $fetch['descricao_padrinho'];
        $_SESSION['id_comportamento'] = $fetch['id_comportamento'];
        $_SESSION['id_temperamento'] = $fetch['id_temperamento'];
        $_SESSION['id_ling_amor'] = $fetch['id_ling_amor'];
        $_SESSION['comportamento'] = $fetch['nome_comportamento'];
        $_SESSION['linguagem'] = $fetch['nome_linguagem'];
        $_SESSION['temperamento'] = $fetch['nome_temperamento'];
        $_SESSION['usuario'] = $user;
        $_SESSION['status'] = $fetch['status'];

        header("location: index.php");
        exit();
    } else {
        header("location: log.php?erro=login");
    }
}

?>