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
    header("location: index.php");
}

$conteudo = mysql_fetch_array($res_busca);

$aviso = "";

if (isset($_POST['titulo'])) {

    $titulo = addslashes($_POST['titulo']);
    $descricao = addslashes($_POST['descricao']);
    $corpo = addslashes($_POST['corpo']);
    $ativo = addslashes($_POST['ativo']);
    $cat_id = addslashes($_POST['id_categoria']);
    $id_usuario = $_SESSION['usuario']['usr_id'];
    
    if (!empty($titulo) && !empty($descricao) && !empty($corpo)) {

        conecta_db();

        $query_alterar = sprintf("UPDATE con_conteudos SET con_titulo = '%s', con_descricao = '%s',"
                . " con_corpo = '%s', con_ativo = %d, cat_id = %d WHERE con_id = %d", 
                $titulo, $descricao, $corpo, $ativo, $cat_id, $con_id);
        
        $resultado_alterar = mysql_query($query_alterar);

        desconecta_db();

        if($resultado_alterar) {
            header("location: index.php?action=2");
        } else {
            $aviso = "Ocorreu algum problema ao alterar conteúdo, tente novamente: ";
        }
     
    } else {
        $aviso = "Por favor, preencha todos os campos!";
    }
}

conecta_db();
$query_categorias = sprintf("SELECT cat_id, cat_titulo FROM cat_categorias WHERE cat_ativo = 1 ORDER BY cat_titulo ASC");
$res_categorias = mysql_query($query_categorias);
desconecta_db();

?>


<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Alterar Conteúdo</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Formulário de Conteúdo
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1 col-sm-12 col-sm-offset-0">
                            <form class='form-horizontal' method="POST" action="alterar.php?id=<?=$conteudo['con_id']?>">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?></div>
                                <?php endif;?>
                                    
                                    
                                <div class="form-group">
                                    
                                    <label for='id_categoria' class="col-md-2 control-label">Categoria</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <select class="form-control" name="id_categoria">
                                            <?php while($row = mysql_fetch_array($res_categorias)):?>
                                                <option value="<?=$row['cat_id']?>" <?=($row['cat_id'] == $conteudo['cat_id']? "selected": "")?>>
                                                    <?=$row['cat_titulo']?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='titulo' class="col-md-2 control-label">Título</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="titulo" type="text" value="<?=$conteudo['con_titulo']?>">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='descricao' class="col-md-2 control-label">Descricao</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <textarea class="form-control" name="corpo" rows="5"><?=$conteudo['con_descricao']?></textarea>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='corpo' class="col-md-2 control-label">Corpo</label>
                                    <div class='col-md-9 col-sm-12'>
                                        
                                        <textarea class="form-control" name="corpo" rows="10"><?=$conteudo['con_corpo']?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for='ativo' class="col-md-2 control-label">Status</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo1" value="1" <?=($conteudo['con_ativo'] == 1? "checked": "")?>>&nbsp;Ativado
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo2" value="0" <?=($conteudo['con_ativo'] == 0? "checked": "")?>>&nbsp;Desativado
                                        </label>
                                    </div>
                                </div>
                                                               
                                <div class='clear'>&nbsp;</div>
                                <div class='form-group'>
                                    <div class='col-md-offset-2 col-md-10 col-sm-offset-0 col-sm-12'>
                                        <button type="submit" class="btn btn-success">Alterar</button>
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