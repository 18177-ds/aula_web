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
    $descricao = addslashes($_POST['descricao']);
    $corpo = addslashes($_POST['corpo']);
    $ativo = addslashes($_POST['ativo']);
    $cat_id = addslashes($_POST['id_categoria']);
    $id_usuario = $_SESSION['usuario']['usr_id'];
    
    if (!empty($titulo) && !empty($descricao) && !empty($corpo)) {

        conecta_db();

        $query_inserir = sprintf("INSERT INTO con_conteudos VALUES (NULL, '%s', '%s', '%s', %d, NOW(), NULL, %d, %d)", 
                $titulo, $descricao, $corpo, $ativo, $id_usuario, $cat_id);
        
        $resultado_inserir = mysql_query($query_inserir);

        desconecta_db();

        if($resultado_inserir) {
            header("location: index.php?action=1");
        } else {
            $aviso = "Ocorreu algum problema ao criar conteúdo, tente novamente: ";
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
            <h1 class="page-header">Adicionar Conteúdo</h1>
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
                            <form class='form-horizontal' method="POST" action="criar.php">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?></div>
                                <?php endif;?>
                                    
                                    
                                <div class="form-group">
                                    
                                    <label for='id_categoria' class="col-md-2 control-label">Categoria</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <select class="form-control" name="id_categoria">
                                            <?php while($row = mysql_fetch_array($res_categorias)):?>
                                                <option value="<?=$row['cat_id']?>"><?=$row['cat_titulo']?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='titulo' class="col-md-2 control-label">Título</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="titulo" type="text">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='descricao' class="col-md-2 control-label">Descricao</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="descricao" type="text">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='corpo' class="col-md-2 control-label">Corpo</label>
                                    <div class='col-md-9 col-sm-12'>
                                        
                                        <textarea class="form-control" name="corpo" rows="10"></textarea>
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