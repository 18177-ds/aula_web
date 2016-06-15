<?php

//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(isset($_SESSION['usuario'])){
    header("location: ../dashboard/");
}

//incluir arquivo de conexão ao banco
require '../utils/bd.php';

//gravar mensagens para exibir para o usuário
$aviso_erro = "";
$aviso_sucesso = "";

//se o formulário for enviado
if (isset($_POST['login'])) {

    //pegar dados do form e adicionar um \ onde ouves aspas
    $login = addslashes($_POST['login']);
    $senha = addslashes($_POST['senha']);
    
    //verificar se o formulário não está vazio
    if (!empty($login) && !empty($senha)) {

        //conectar ao banco
        conecta_db();

        //buscar usuário pelo email no banco
        $query_busca = sprintf("SELECT * FROM usr_usuarios WHERE usr_login LIKE '%s' AND usr_password LIKE '%s' AND usr_ativo = 1", 
                $login, md5($senha));
        $array_usuarios = mysql_query($query_busca);
        
        //desconecta do banco
        desconecta_db();

        //se retornar resultados
        if (mysql_num_rows($array_usuarios) == 1) {
            //salvar os dados do usuário logado em uma sessão para manter logado
            $usuario = mysql_fetch_array($array_usuarios);
            $_SESSION['usuario'] = $usuario;
            header("location: ../dashboard/");
        } else {
            $aviso_erro = "Login ou senha inválidos!";
        }

    } else {
        $aviso_erro = "Por favor, preencha todos os campos!";
    }
//verifica se redirecionou de um logout
}else if(isset($_GET['l'])){
    $aviso_sucesso = "Usuário deslogado com sucesso!"; 
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WEB CMS - Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="../res/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../res/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../res/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../res/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Painel de Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="index.php" method="POST">
                            <fieldset>
                                
                                <?php if(!empty($aviso_erro)):?>
                                    <div class="alert alert-danger"><?=$aviso_erro?></div>
                                <?php elseif(!empty($aviso_sucesso)):?>
                                    <div class="alert alert-success"><?=$aviso_sucesso?></div>
                                <?php endif;?>
                                    
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="login" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Senha" name="senha" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type = "submit" class="btn btn-lg btn-success" value="Login"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../res/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../res/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../res/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../res/dist/js/sb-admin-2.js"></script>

</body>

</html>
