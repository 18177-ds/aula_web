<?php

//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(isset($_SESSION['usuario'])){
    header("location: dashboard/");
}else{
    header("location: login/");
}
