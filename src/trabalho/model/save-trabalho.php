
<?php
/******
 * Upload de imagens
 ******/

//  echo $_FILES[ 'archive' ][ 'name' ];

// verifica se foi enviado um arquivo
if ( isset( $_FILES[ 'ARQUIVO' ][ 'name' ] ) && $_FILES[ 'ARQUIVO' ][ 'error' ] == 0 ) {
    // echo 'Você enviou o arquivo: <strong>' . $_FILES[ 'archive' ][ 'name' ] . '</strong><br />';
    // echo 'Este arquivo é do tipo: <strong > ' . $_FILES[ 'archive' ][ 'type' ] . ' </strong ><br />';
    // echo 'Temporáriamente foi salvo em: <strong>' . $_FILES[ 'archive' ][ 'tmp_name' ] . '</strong><br />';
    // echo 'Seu tamanho é: <strong>' . $_FILES[ 'archive' ][ 'size' ] . '</strong> Bytes<br /><br />';

    $arquivo_tmp = $_FILES[ 'ARQUIVO' ][ 'tmp_name' ];
    $nome = $_FILES[ 'ARQUIVO' ][ 'name' ];

    // Pega a extensão
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );

    // Converte a extensão para minúsculo
    $extensao = strtolower ( $extensao );

    // Somente imagens, .jpg;.jpeg;.gif;.png
    // Aqui eu enfileiro as extensões permitidas e separo por ';'
    // Isso serve apenas para eu poder pesquisar dentro desta String
    if ( strstr ( '.pdf', $extensao ) ) {
        // Cria um nome único para esta imagem
        // Evita que duplique as imagens no servidor.
        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
        $novoNome = uniqid ( time () ) . '.' . $extensao;

        // Concatena a pasta com o nome
        $destino = 'arquivos/' . $novoNome;

        // tenta mover o arquivo para o destino
        if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
            $retorno = array ('mensagem' => 'Arquivo salvo com sucesso em : ' . $destino);
            // include '../conexao.php';
            // $documents = utf8_decode($_POST['nameDocuments']);
            // $sqlInsert = mysqli_query($conecta, "INSERT INTO lions_documents (nameDocuments, fileDocuments) VALUES ('".$documents."', '".$novoNome."')");
            // header('Location: ../../sistema/returnSuccess.php');
                // Scripts de persistência no banco de dados .....
                // Obter a nossa conexão com o banco de dados
                include('../../conexao/conn.php');

                // Obter os dados enviados do formulário via $_REQUEST
                $requestData = $_REQUEST;

                // Verificação de campo obrigatórios do formulário
                if(empty($requestData['TITULO'])){
                    // Caso a variável venha vazia eu gero um retorno de erro do mesmo
                    $dados = array(
                        "tipo" => 'error',
                        "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
                    );
                } else {
                    // Caso não exista campo em vazio, vamos gerar a requisição
                    $ID = isset($requestData['idtrabalho']) ? $requestData['idtrabalho'] : '';
                    $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

                    // Verifica se é para cadastra um nvo registro
                    if($operacao == 'insert'){
                        // Prepara o comando INSERT para ser executado
                        try{
                            $stmt = $pdo->prepare('INSERT INTO trabalho (titulo, ano, nropaginas, resumo, orientador, coorientador, arquivo) VALUES (:a, :b, :c, :d, :e, :f, :g)');
                            $stmt->execute(array(
                                ':a' => utf8_decode($requestData['titulo']),
                                ':b' => $requestData['ano'],
                                ':c' => $requestData['nropaginas'],
                                ':d' => utf8_decode($requestData['resumo']),
                                ':e' => utf8_decode($requestData['orientador']),
                                ':f' => utf8_decode($requestData['coorientador']),
                                ':g' => $novoNome
                            ));
                            $sql = $pdo->query("SELECT * FROM trabalho ORDER BY idtrabalho DESC LIMIT 1");
                            while ($resultado = $sql->fetch(PDO ::FETCH_ASSOC)){
                                    $idtrabalho = $resultado['idtrabalho'];
                            }
                            $indice = count(array_filter($requestData['AUTOR']));
                            for($i=0; $i <$indice; $i++){
                                $stmt = $pdo ->prepare('INSERT INTO AUTOR (trabalho_idtrabalho, usuario_idusuario) VALUES (:a, :b)');
                                $stmt->execute(array(
                                    ':a' =>$idtrabalho,
                                    ':b' =>$requestData['autor'][$i]
                                ));
                            }
                            $retorno = array(
                                "tipo" => 'success',
                                "mensagem" => 'Trabalho cadastrado com sucesso.'
                            );
                        } catch(PDOException $e) {
                            $retorno = array(
                                "tipo" => 'error',
                                "mensagem" => 'Não foi possível efetuar o cadastro do trabalho.'
                            );
                        }
                    } else {
                        // Se minha variável operação estiver vazia então devo gerar os scripts de update
                        try{
                            $stmt = $pdo->prepare('UPDATE trabalho SET titulo = :a, ano = :b, nropaginas = :c, resumo = :d, orientador = :e, coorientador = :f, arquivo = :g WHERE idtrabalho = :id');
                            $stmt->execute(array(
                                ':id' => $ID,
                                ':a' => utf8_decode($requestData['titulo']),
                                ':b' => $requestData['ano'],
                                ':c' => $requestData['nropaginas'],
                                ':d' => utf8_decode($requestData['resumo']),
                                ':e' => utf8_decode($requestData['orientador']),
                                ':f' => utf8_decode($requestData['coorientador']),
                                ':g' => $requestData['arquivo']
                            ));
                            $retorno = array(
                                "tipo" => 'success',
                                "mensagem" => 'Trabalho atualizado com sucesso.'
                            );
                        } catch (PDOException $e) {
                            $retorno = array(
                                "tipo" => 'error',
                                "mensagem" => 'Não foi possível efetuar o alteração do trabalho.'
                            );
                        }
                    }
                }

        }
        else
            $retorno = array ('mensagem' => 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.');
    }
    else
        $retorno = array ('mensagem' => 'Você poderá enviar apenas arquivos "*.PDF"');
}
else
    $retorno = array ('mensagem' => 'Você não enviou nenhum arquivo!');


echo json_encode($retorno);