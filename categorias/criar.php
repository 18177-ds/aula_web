<?php


//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}

require '../utils/bd.php';

$aviso = "";

if (isset($_POST['titulo'])) {

    $titulo = addslashes($_POST['titulo']);
    $ativo = addslashes($_POST['ativo']);
    $id_usuario = $_SESSION['usuario']['usr_id'];
    
    if (!empty($titulo)) {

        conecta_db();

        $query_inserir = sprintf("INSERT INTO cat_categorias VALUES (NULL, '%s', %d, NOW(), NULL, %d)", 
                $titulo, $ativo, $id_usuario);
        
        $resultado_inserir = mysql_query($query_inserir);

        desconecta_db();

        if($resultado_inserir) {
            header("location: index.php?action=1");
        } else {
            $aviso = "Ocorreu algum problema ao criar categoria, tente novamente: ".$query_inserir;
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
            <h1 class="page-header">Adicionar Categoria</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Formulário de Categoria
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1 col-sm-12 col-sm-offset-0">
                            <form class='form-horizontal' method="POST" action="criar.php">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?></div>
                                <?php endif;?>
                                <div class="form-group">
                                    
                                    <label for='titulo' class="col-md-2 control-label">Título</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="titulo" type="text">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for='ativo' class="col-md-2 control-label">Status</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo1" value="1">&nbsp;Ativada
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo2" value="0" checked>&nbsp;Desativada
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