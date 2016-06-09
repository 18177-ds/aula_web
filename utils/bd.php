<?php

/* * *
  CREATE TABLE usuarios (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome_completo VARCHAR(255) NOT NULL,
  nome_usuario VARCHAR(100) NOT NULL,
  senha VARCHAR(64) NOT NULL,
  UNIQUE(nome_usuario)
  );
 */


global $conecta;

function conecta_db() {

    $servidor = "localhost";
    $usuario = "root";
    $senha = "root";
    $banco_dados = "projeto";

    $conecta = mysql_connect($servidor, $usuario, $senha) or print (mysql_error());
    mysql_select_db($banco_dados, $conecta) or print(mysql_error());
}

function desconecta_db() {

    mysql_close($conecta);
}

?>
