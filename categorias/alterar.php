<?php


//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}

$cat_id = 0;

if(!isset($_GET['id'])){
    header("location: index.php");
}

$cat_id = intval($_GET['id']);

require '../utils/bd.php';

conecta_db();

$query_busca = sprintf("SELECT cat_id, cat_titulo, cat_ativo FROM cat_categorias WHERE cat_id = %d", $cat_id);
$res_busca = mysql_query($query_busca);

if(mysql_num_rows($res_busca) < 1){
    header("location: index.php");
}

$categoria = mysql_fetch_array($res_busca);

$aviso = "";

if (isset($_POST['titulo'])) {

    $titulo = addslashes($_POST['titulo']);
    $ativo = addslashes($_POST['ativo']);
    
    if (!empty($titulo)) {

        $query_alterar = sprintf("UPDATE cat_categorias SET cat_titulo = '%s', cat_ativo = %d WHERE cat_id = '%d'", 
                $titulo, $ativo, $cat_id);
        
        $resultado_alterar = mysql_query($query_alterar);

        desconecta_db();

        if($resultado_alterar) {
            header("location: index.php?action=2");
        } else {
            $aviso = "Ocorreu algum problema ao alterar categoria, tente novamente!";
        }
     
    } else {
        $aviso = "Por favor, preencha todos os campos!";
    }
}

desconecta_db();
?>


<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Alterar Categoria</h1>
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
                            <form class='form-horizontal' method="POST" action="alterar.php?id=<?=$categoria['cat_id']?>">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?></div>
                                <?php endif;?>
                                <div class="form-group">
                                    
                                    <label for='titulo' class="col-md-2 control-label">Título</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="titulo" type="text" value="<?=$categoria['cat_titulo']?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for='ativo' class="col-md-2 control-label">Status</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo1" value="1" 
                                                <?=($categoria['cat_ativo'] == 1? "checked": "")?>>&nbsp;Ativo
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo2" value="0" 
                                                   <?=($categoria['cat_ativo'] == 0? "checked": "")?>>&nbsp;Desativada
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