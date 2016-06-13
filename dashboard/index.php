<?php

//iniciar sessao, necessário para manter o usuário logado
session_start();

//se usuario esta logado, redireciona para a primeira página do sistema
if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}

$usuario = $_SESSION['usuario'];

include '../utils/bd.php';

conecta_db();

$query_num_cat = "SELECT COUNT(*) as total FROM cat_categorias";
$res_num_cat = mysql_query($query_num_cat);
$num_cat = mysql_fetch_array($res_num_cat)['total'];

$query_num_con = "SELECT COUNT(*) as total FROM con_conteudos";
$res_num_con = mysql_query($query_num_con);
$num_con = mysql_fetch_array($res_num_con)['total'];

$query_num_usr = "SELECT COUNT(*) as total FROM usr_usuarios";
$res_num_usr = mysql_query($query_num_usr);
$num_usr = mysql_fetch_array($res_num_usr)['total'];

$query_conteudos = "SELECT"
            . " con.con_id AS con_id,"
            . " con.con_titulo AS con_titulo,"
            . " con.con_criado_em AS con_criado_em,"
            . " con.con_alterado_em AS con_alterado_em,"
            . " cat.cat_titulo AS cat_titulo,"
            . " usr.usr_nome AS usr_nome"
        . " FROM con_conteudos AS con"
        . " INNER JOIN cat_categorias AS cat"
            . " ON cat.cat_id = con.cat_id"
        . " INNER JOIN usr_usuarios AS usr"
            . " ON usr.usr_id = con.usr_id_autor"
        . " WHERE con.con_ativo = 1"
        . " ORDER BY con.con_id DESC"
        . " LIMIT 5";


$res_conteudos = mysql_query($query_conteudos);

desconecta_db();

?>

<?php include '../layout/_header.php';?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$num_cat?></div>
                                    <div>Categorias</div>
                                </div>
                            </div>
                        </div>
                        <a href="../categorias/">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalhes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$num_con?></div>
                                    <div>Conteúdos</div>
                                </div>
                            </div>
                        </div>
                        <a href="../conteudos/">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalhes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$num_usr?></div>
                                    <div>Usuários</div>
                                </div>
                            </div>
                        </div>
                        <a href="../usuarios/">
                            <div class="panel-footer">
                                <span class="pull-left">Ver detalhes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-file-text fa-fw"></i>&nbsp;Últimos Conteúdos Publicados
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class='center'>#</th>
                                            <th class='center'>Título</th>
                                            <th class='center'>Categoria</th>
                                            <th class='center'>Autor</th>
                                            <th class='center'>Criado em</th>
                                            <th class='center'>Atualizado em<th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php if(mysql_num_rows($res_conteudos) > 0):?>
                                            <?php while($row = mysql_fetch_array($res_conteudos)):?>
                                                <tr>
                                                    <td class='center'><?=$row['con_id']?></td>
                                                    <td><?=$row['con_titulo']?></td>
                                                    <td><?=$row['cat_titulo']?></td>
                                                    <td><?=$row['usr_nome']?></td>
                                                    <td class='center'><?=date('d/m/Y H:i:s',strtotime($row['con_criado_em']))?></td>
                                                    <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['con_alterado_em'])) ?></td>
                                                </tr>
                                            <?php endwhile;?>
                                        <?php else:?>
                                                <tr>
                                                    <td colspan="4">Sem conteúdos publicados</td>
                                                </tr>
                                        <?php endif;?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

<?php include '../layout/_footer.php';?>

