<?php

    // Realizar nossa conexão com o banco de dados
    include('../../conexao/conn.php');

    $nome = $_REQUEST['nome'];

    $dados = array();

    $sql = "SELECT * FROM eixo WHERE nome LIKE '%$nome%' ORDER BY nome ASC";

    $resultado = $pdo->query($sql);

    if($resultado){
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
            $dados[] = array_map('utf8_encode', $row);
        }
    }

    echo json_encode($dados);