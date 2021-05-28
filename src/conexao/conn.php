<?php

//declarando as variáveis necessárias
    $hostname = "fdb29.awardspace.net";
    $dbname = "3800532_library";
    $username = "3800532_libraryds";
    $password = "nocontrol20";

    try{
        $pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname,$username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        echo"conexao realizada com sucesso";
    } catch (PDOException $e){
        echo "ERROR:".$e-> getMessage();
    }

