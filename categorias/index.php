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

$query_categorias = "SELECT"
            . " cat.cat_id AS cat_id,"
            . " cat.cat_titulo AS cat_titulo,"
            . " cat.cat_criado_em AS cat_criado_em,"
            . " cat.cat_alterado_em AS cat_alterado_em,"
            . " cat.cat_ativo AS cat_ativo,"
            . " usr.usr_nome AS usr_nome"
        . " FROM cat_categorias AS cat"
        . " INNER JOIN usr_usuarios AS usr"
            . " ON usr.usr_id = cat.usr_id_autor"
        . " ORDER BY cat_id DESC";

$res_categorias = mysql_query($query_categorias);

desconecta_db();

?>

<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Categorias</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <a href ="criar.php" class ="btn btn-success">Nova categoria</a>
            
            <div class="clearfix"/><br /></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list fa-fw"></i>&nbsp;Categorias
                    
                    

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class='center'>#</th>
                                    <th class='center'>Título</th>
                                    <th class="center">Autor</th>
                                    <th class='center'>Criado em</th>
                                    <th class='center'>Atualizado em</th>
                                    <th class="center">Status</th>
                                    <th class="center">Ação</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (mysql_num_rows($res_categorias) > 0): ?>
                                    <?php while ($row = mysql_fetch_array($res_categorias)): ?>
                                        <tr>
                                            <td class='center'><?= $row['cat_id'] ?></td>
                                            <td><?= $row['cat_titulo'] ?></td>
                                            <td><?= $row['usr_nome'] ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['cat_criado_em'])) ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['cat_alterado_em'])) ?></td>
                                            <td class="center">
                                                <?= ($row['cat_ativo'] == "1"? "Ativado" : "Desativado") ?>
                                            </td>
                                            <td>
                                                <a href ="alterar.php?id=<?=$row['cat_id']?>" class ="btn btn-info">
                                                    <i class ="fa fa-edit"></i>&nbsp;Editar
                                                </a>
                                            
                                                <a href ="deletar.php?id=<?=$row['cat_id']?>" class ="btn btn-danger">
                                                    <i class ="fa fa-trash"></i>&nbsp;Apagar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Sem categorias publicadas</td>
                                    </tr>
                                <?php endif; ?>

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

    <?php include '../layout/_footer.php'; ?>