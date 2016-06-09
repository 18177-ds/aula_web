<?php

require '../utils/bd.php';

if (!isset($_GET['id'])) {
    header("location: index.php");
} else {

    conectaDB();

    $id = $_GET['id'];

    $query_remover = sprintf("DELETE FROM usuarios WHERE id = '%d'", $id);
    $resultado_remover = mysql_query($query_remover);

    desconectaDB();

    if ($resultado_remover) {
        header("location: index.php?action=3&status=1");
    } else {
        header("location: index.php?action=3&status=0");
    }
}
?>