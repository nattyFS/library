<?php

    // Instância do banco de dados
    include("../../conexao/conn.php");

   
    $idcurso = $_REQUEST['idcurso'];

    
    $sql = "DELETE FROM curso WHERE idcurso = $idcurso";

    
    $resultado = $pdo->query($sql);

    // testando o retorno do resultado da querie
    if($resultado){
        $dados = array(
            'tipo' => 'success',
            'mensagem' => 'Registro excluído com sucesso!'
        );
    } else {
        $dados = array(
            'tipo' => 'error',
            'mensagem' => 'Não foi possível excluir o registro'
        );
    }

    echo json_encode($dados);