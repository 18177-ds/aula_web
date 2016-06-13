<?php


//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}

$con_id = 0;

if(!isset($_GET['id'])){
    header("location: index.php");
}

$con_id = intval($_GET['id']);

require '../utils/bd.php';

conecta_db();

$query_busca = sprintf("SELECT * FROM con_conteudos WHERE con_id = %d", $con_id);
$res_busca = mysql_query($query_busca);

if(mysql_num_rows($res_busca) < 1){
    header("location: index.php?action=4");
}

$query_apagar = sprintf("DELETE FROM con_conteudos WHERE con_id = '%d'", $con_id);

$resultado_apagar = mysql_query($query_apagar);

desconecta_db();

if($resultado_apagar) {
    header("location: index.php?action=3");
} else {
    header("location: index.php?action=4");
}

?>