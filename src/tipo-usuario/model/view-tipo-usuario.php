<?php

    
    include('../../conexao/conn.php');

    $idtipo_usuario = $_REQUEST['idtipo_usuario'];
    
    $sql = "SELECT * FROM tipo_usuario WHERE idtipo_usuario = $idtipo_usuario";

    $resultado = $pdo->query($sql);

    if($resultado){
        $dadosTipo = array();
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
            $dadosTipo = array_map('utf8_encode', $row);
        }
        $dados = array(
            'tipo' => 'success',
            'mensagem' => '',
            'dados' => $dadosTipo
        );
    } else {
        $dados = array(
            'tipo' => 'error',
            'mensagem' => 'Não foi possível obter o registro solicitado.',
            'dados' => array()
        );
    }

    echo json_encode($dados);