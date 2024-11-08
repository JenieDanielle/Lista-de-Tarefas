<?php
session_start();
require_once('conexao.php');

if (isset($_POST['create_tarefa'])) {
    $nome = trim($_POST['txtNome']);
    $descricao = trim($_POST['txtDescricao']);
    $status = intval($_POST['txtStatus']);
    $dataLimite = trim($_POST['txtData']);

    $sql = "INSERT INTO tarefa (nome, descricao, status, data_limite) VALUES('$nome', '$descricao', '$status', '$dataLimite')";
    
    mysqli_query($conn, $sql);

    header('Location: index.php');
    exit();
}

if (isset($_POST['delete_tarefa'])) {
    $tarefaId = mysqli_real_escape_string($conn, $_POST['delete_tarefa']);
    $sql = "DELETE FROM tarefa WHERE id = '$tarefaId'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = '<i class="bi bi-check-circle-fill"></i>' . " Tarefa com ID {$tarefaId} excluída com sucesso!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = '<i class="bi bi-exclamation-circle-fill"></i>' . " Erro ao excluir tarefa.";
        $_SESSION['type'] = 'error';
    }

    header('Location: index.php');
    exit();
}

if (isset($_POST['edit_tarefa'])) {
    $tarefaId = intval($_POST['id']);
    $nome = mysqli_real_escape_string($conn, $_POST['txtNome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $status = intval($_POST['txtStatus']);
    $dataLimite = mysqli_real_escape_string($conn, $_POST['txtData']);

    $sql = "UPDATE tarefa SET nome = '{$nome}', status = '{$status}', data_limite = '{$dataLimite}', descricao = '$descricao'  WHERE id = '$tarefaId'";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['message'] = "Tarefa  {$tarefaId} atualizada com sucesso!";
        $_SESSION['type'] = 'success';
    } else {
        $_SESSION['message'] = "Não foi possível atualizar a tarefa.";
        $_SESSION['type'] = "error";
    }

    header("Location: index.php");
    exit;
}

?>