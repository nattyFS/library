<?php

    include('../../conexao/conn.php');

    $requestData = $_REQUEST;

    if(empty($requestData['nome'])){
        
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        
        $idcurso = isset($requestData['idcurso']) ? $requestData['idcurso'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

       
        if($operacao == 'insert'){
            // Prepara o comando INSERT para ser executado
            try{
                $stmt = $pdo->prepare('INSERT INTO curso (nome, eixo_ideixo) VALUES (:a, b)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => $requestData['eixo_ideixo']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'curso tecnológico cadastrado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o cadastro do curso.'
                );
            }
        } else {
            
            try{
                $stmt = $pdo->prepare('UPDATE curso SET nome = :a , eixo_ideixo = :b WHERE idcurso = :id');
                $stmt->execute(array(
                    ':id' => $idcurso,
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => $requestData['eixo_ideixo']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'curso tecnológico atualizado com sucesso.'
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o alteração do curso.'
                );
            }
        }
    }

    // Converter um array ded dados para a representação JSON
    echo json_encode($dados);