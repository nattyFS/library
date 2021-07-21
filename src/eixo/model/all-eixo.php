<?php

// realizar nossa conexão com o BD
include('../../conexao/conn.php');

// criação da variável array que receberá toda a consulta de banco de dados
$dados = array();

// Query de consulta ao banco de dados
$sql = "SELECT * FROM eixo ORDER BY nome ASC";

// Executar a querie de consulta SQL
$resultado = $pdo->query($sql);

// Verificação do retorno da consulta
if($resultado){
    while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $dados[] = array_map('utf8_encode', $row);
    }
}

// Retorno JSON para
echo json_encode($dados);