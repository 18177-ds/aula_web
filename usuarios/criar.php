<?php


//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}

require '../utils/bd.php';

$aviso = "";

if (isset($_POST['nome_completo'])) {

    $nome_completo = addslashes($_POST['nome_completo']);
    $nome_usuario = addslashes($_POST['nome_usuario']);
    $senha = addslashes($_POST['senha']);
    $conf_senha = addslashes($_POST['conf_senha']);
    $ativo = addslashes($_POST['ativo']);

    if (!empty($nome_completo) && !empty($nome_usuario) && !empty($senha) && !empty($conf_senha)) {

        if ($senha == $conf_senha) {

            conecta_db();

            $query_busca = sprintf("SELECT * FROM usr_usuarios WHERE usr_login LIKE '%s'", $nome_usuario);
            $array_usuarios = mysql_query($query_busca);

            if (mysql_num_rows($array_usuarios) == 0) {

                $query_inserir = sprintf("INSERT INTO usr_usuarios VALUES (NULL, '%s', '%s', md5('%s'), %d, NOW(), NULL)", 
                        $nome_completo, $nome_usuario, $senha, $ativo);

                $resultado_inserir = mysql_query($query_inserir);

                desconecta_db();

                if ($resultado_inserir) {
                    header("location: index.php?action=1");
                } else {
                    $aviso = "Ocorreu algum problema ao criar usuário, tente novamente".$query_inserir;
                }
            } else {
                $aviso = "Nome de usuário já existe";
            }
        } else {
            $aviso = "As senhas não conferem";
        }
    } else {
        $aviso = "Por favor, preencha todos os campos!";
    }
}
?>

<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Adicionar Usuário</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Formulário de Usuário
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1 col-sm-12 col-sm-offset-0">
                            <form class='form-horizontal' method="POST" action="criar.php">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?></div>
                                <?php endif;?>
                                    
                                <div class="form-group">
                                    
                                    <label for='nome_completo' class="col-md-2 control-label">Nome Completo</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="nome_completo" type="text">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='nome_usuario' class="col-md-2 control-label">Nome de Usuário</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="nome_usuario" type="text">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='senha' class="col-md-2 control-label">Senha</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="senha" type="password">
                                    </div>
                                </div>
                                    
                                    
                                <div class="form-group">
                                    
                                    <label for='conf_senha' class="col-md-2 control-label">Confirme a Senha</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="conf_senha" type="password">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for='ativo' class="col-md-2 control-label">Status</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo1" value="1">&nbsp;Ativado
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo2" value="0" checked>&nbsp;Desativado
                                        </label>
                                    </div>
                                </div>
                                   
                                                               
                                <div class='clear'>&nbsp;</div>
                                <div class='form-group'>
                                    <div class='col-md-offset-2 col-md-10 col-sm-offset-0 col-sm-12'>
                                        <button type="submit" class="btn btn-success">Cadastrar</button>
                                        <button type="reset" class="btn btn-info">Limpar os Dados</button>
                                     </div>
                                </div>
                            </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

    <?php include '../layout/_footer.php'; ?>

