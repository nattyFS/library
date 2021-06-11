<?php

    include('../../conexao/conn.php');

    $requestData = $_REQUEST;

    if(empty($requestData['nome'])){
        
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        
        $ideixo = isset($requestData['ideixo']) ? $requestData['ideixo'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

       
        if($operacao == 'insert'){
            // Prepara o comando INSERT para ser executado
            try{
                $stmt = $pdo->prepare('INSERT INTO eixo (nome) VALUES (:nome)');
                $stmt->execute(array(
                    ':nome' => utf8_decode($requestData['nome'])
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Eixo tecnológico cadastrado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o cadastro do eixo.'
                );
            }
        } else {
            
            try{
                $stmt = $pdo->prepare('UPDATE eixo SET nome = :nome WHERE ideixo = :id');
                $stmt->execute(array(
                    ':id' => $ideixo,
                    ':nome' => utf8_decode($requestData['nome'])
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Eixo tecnológico atualizado com sucesso.'
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o alteração do eixo.'
                );
            }
        }
    }

    // Converter um array ded dados para a representação JSON
    echo json_encode($dados);