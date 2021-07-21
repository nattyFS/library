<?php

    include('../../conexao/conn.php');

    $requestData = $_REQUEST;

    if(empty($requestData['descricao'])){
        
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        
        $idtipo_usuario = isset($requestData['idtipo_usuario']) ? $requestData['idtipo_usuario'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

       
        if($operacao == 'insert'){
            // Prepara o comando INSERT para ser executado
            try{
                $stmt = $pdo->prepare('INSERT INTO tipo_usuario (descricao) VALUES (:descricao)');
                $stmt->execute(array(
                    ':descricao' => utf8_decode($requestData['descricao'])
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'tipo usuário cadastrado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o cadastro do usuario.'
                );
            }
        } else {
            
            try{
                $stmt = $pdo->prepare('UPDATE tipo_usuario SET descricao = :descricao WHERE idtipo_usuario = :id');
                $stmt->execute(array(
                    ':id' => $idtipo_usuario,
                    ':descricao' => utf8_decode($requestData['descricao'])
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