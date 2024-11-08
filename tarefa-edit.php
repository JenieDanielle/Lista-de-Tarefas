<?php
session_start();
require_once('conexao.php');

$tarefa = [];

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
} else {

    $tarefaId = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM tarefa WHERE id = '{$tarefaId}'";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Erro" . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $tarefa = mysqli_fetch_array($query);
    } else {
        $_SESSION['message'] = "Tarefa não encontrada.";
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .gradient-bg {
            background: radial-gradient(circle, #a281f9, #845af7, #4c0c9a, indigo);
            min-height: 170vh;
        }
    </style>
</head>
<body class="gradient-bg">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Editar Tarefa <i class="bi bi-pencil-fill"></i>
                            <a href="index.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                    if ($tarefa) :
                    ?>
                    <form action="acoes.php" method="POST">
                        <input type="hidden" name="id" value="<?= $tarefa['id']?>">
                            <div class="mb-3">
                                <label for="txtNome">Nome</label>
                                <input type="text" name="txtNome" id="txtNome" value="<?=$tarefa['nome']?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="txtStatus">Status</label>
                                        <select name="txtStatus" class="form-select" aria-label="Default select example">
                                            <option selected>Status</option>
                                            <option value="0"  <?=$tarefa['status'] == 0 ? 'selected' : '' ?>>Pendente</option>
                                            <option value="1"  <?=$tarefa['status'] == 1 ? 'selected' : '' ?>>Execução</option>
                                            <option value="2"  <?=$tarefa['status'] == 2 ? 'selected' : '' ?>>Concluído</option>
                                        </select>
                            </div>
                            <div class="mb-3">
                                <?php $dataLimite = date('Y-m-d', strtotime($tarefa['data_limite'])); ?>
                                <label for="txtData">Data Limite</label>
                                <input type="date" name="txtData" id="txtData" value="<?=$tarefa['data_limite']?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" class="form-control" id="txtdescricao" rows="3"><?=$tarefa['descricao']?></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="edit_tarefa" class="btn btn-primary float-end">Salvar</button>
                            </div>
                        </form>
                        <?php
                        else:
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Tarefa não encontrada
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>