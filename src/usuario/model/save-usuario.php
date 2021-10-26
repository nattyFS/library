<?php

    // Obter a nossa conexão com o banco de dados
    include('../../conexao/conn.php');

    // Obter os dados enviados do formulário via $_REQUEST
    $requestData = $_REQUEST;

    // Verificação de campo obrigatórios do formulário
    if(empty($requestData['nome'])){
        // Caso a variável venha vazia eu gero um retorno de erro do mesmo
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        // Caso não exista campo em vazio, vamos gerar a requisição
        $ID = isset($requestData['idusuario']) ? $requestData['idusuario'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verifica se é para cadastra um nvo registro
        if($operacao == 'insert'){
            // Prepara o comando INSERT para ser executado
            try{
                $stmt = $pdo->prepare('INSERT INTO usuario (nome, email, senha, tipo_usuario_idtipo_usuario, curso_idcurso) VALUES (:a, :b, :c, :d, :e)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => utf8_decode($requestData['email']),
                    ':c' => md5($requestData['senha']),
                    ':d' => $requestData['tipo_usuario_idtipo_usuario'],
                    ':e' => $requestData['curso_idcurso']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Usuário cadastrado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível efetuar o cadastro do curso.'
                );
            }
        } else {
            // Se minha variável operação estiver vazia então devo gerar os scripts de update
            try{
                $stmt = $pdo->prepare('UPDATE usuario SET nome = :a, email = :b, senha = :c, tipo_usuario_idtipo_usuario = :d, curso_idcurso = :e WHERE idusuario = :id');
                $stmt->execute(array(
                    ':id' => $ID,
                    ':a' => utf8_decode($requestData['nome']),
                    ':b' => utf8_decode($requestData['email']),
                    ':c' => md5($requestData['senha']),
                    ':d' => $requestData['tipo_usuario_idtipo_usuario'],
                    ':e' => $requestData['curso_idcurso']
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Usuário atualizado com sucesso.'
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