<?php
session_start();
require_once 'conexao.php';

$sql = "SELECT * FROM tarefa";
$tarefas = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .gradient-bg {
            background: radial-gradient(circle, #a281f9, #845af7, #4c0c9a, #153e8f);
            min-height: 170vh;
        }
    </style>
</head>
<body class="gradient-bg">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            Lista de Tarefas <i class="bi bi-card-checklist"></i>
                            <a href="tarefa-create.php" class="btn btn-dark mb-3 float-end">Nova Tarefa</a>
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php include('mensagem.php'); ?>
                        <div class="row">
                                <tbody>
                                    <?php foreach ($tarefas as $tarefa): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card shadow-sm">
                                                <div class="card-body bg-light">

                                                <a href="tarefa-edit.php?id=<?=$tarefa['id'] ?>" class="btn btn-outline-primary btn-sm float-end ms-1"><i class="bi bi-pencil-fill"></i></a>
                                                    <form action="acoes.php" method="POST" class="d-inline">
                                                        <button onclick="return confirm('Tem certeza que deseja excluir?')" name="delete_tarefa" type="submit" value="<?=$tarefa['id']?>" class="btn btn-danger btn-sm float-end"><i class="bi bi-trash-fill"></i></button>
                                                    </form>

                                                    <h4 class="card-title"><?=htmlspecialchars($tarefa['nome'])?></h4>
                                                    <p class="card-text">
                                                        <button class="btn" data-bs-toggle="collapse" data-bs-target="#descricao-<?= $tarefa['id'] ?>" aria-expanded="false" aria-constrols="descricao-<?= $tarefa['id']?>">
                                                            Ver descrição <i class="bi bi-chevron-down"></i>
                                                        </button>
                                                        <div class="collapse" id="descricao-<?= $tarefa['id']?>">
                                                            <strong>Descrição: </strong> <?= $tarefa['descricao']?>
                                                        </div>
                                                    </p>
                                                    <p>
                                                    <?php 
                                                    if ($tarefa['status'] == 0) {
                                                        echo '<i class="bi bi-hourglass-split"></i>' . " Pendente...";
                                                    } elseif ($tarefa['status'] == 1) {
                                                        echo '<i class="bi bi-arrow-repeat"></i>' . " Em execução...";
                                                    } elseif ($tarefa['status'] == 2) {
                                                        echo '<i class="bi bi-clipboard2-check"></i>' . " Concluído!";
                                                    } else {
                                                        echo "Indefinido";
                                                    }
                                                    ?>
                                                    </p>
                                                    <?php $dataLimite = date('d/m/Y', strtotime($tarefa['data_limite']));?>
                                                    <p>Data Limite: <?= $dataLimite?></p>    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html