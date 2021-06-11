<?php

//declarando as variáveis necessárias
    $hostname = "localhost";
    $dbname = "id17013398_library2";
    $username = "id17013398_libraryds";
    $password = "N@control20*";

    try {
        $pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Conexão realizada com sucesso!';
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
    

