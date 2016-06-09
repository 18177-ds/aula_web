<?php

//apagar a sessão com os dados salvos
session_start();
session_destroy();
header("location: index.php?l=1");
?>

