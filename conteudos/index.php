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

$query_conteudos = "SELECT"
            . " con.con_id AS con_id,"
            . " con.con_titulo AS con_titulo,"
            . " con.con_ativo AS con_ativo,"
            . " con.con_criado_em AS con_criado_em,"
            . " con.con_alterado_em AS con_alterado_em,"
            . " cat.cat_titulo AS cat_titulo,"
            . " usr.usr_nome AS usr_nome"
        . " FROM con_conteudos AS con"
        . " INNER JOIN cat_categorias AS cat"
            . " ON cat.cat_id = con.cat_id"
        . " INNER JOIN usr_usuarios AS usr"
            . " ON usr.usr_id = con.usr_id_autor"
        . " ORDER BY con.con_id DESC";


$res_conteudos = mysql_query($query_conteudos);

desconecta_db();

$action = 0;

if(isset($_GET['action'])){
    $action = $_GET['action'];
}
?>

<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Conteúdos</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <?php if($action == 1):?>
                <div class="alert alert-success">Conteúdo cadastrado com sucesso</div>
            <?php elseif($action == 2):?>
                <div class="alert alert-success">Conteúdo alterado com sucesso</div>
            <?php elseif($action == 3):?>
                <div class="alert alert-success">Conteúdo removido com sucesso</div>
            <?php elseif($action == 4):?>
                <div class="alert alert-danger">Conteúdo não pode ser removido</div>
            <?php endif;?>
            
            <a href ="criar.php" class ="btn btn-success">Novo conteúdo</a>
            
            <div class="clearfix"/><br /></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-text fa-fw"></i>&nbsp;Conteúdos
                    
                    

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
                                    <th class='center'>Atualizado em</th>
                                    <th class="center">Status</th>
                                    <th class="center">Ação</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (mysql_num_rows($res_conteudos) > 0): ?>
                                    <?php while ($row = mysql_fetch_array($res_conteudos)): ?>
                                        <tr>
                                            <td class='center'><?= $row['con_id'] ?></td>
                                            <td><?= $row['con_titulo'] ?></td>
                                            <td><?= $row['cat_titulo'] ?></td>
                                            <td><?= $row['usr_nome'] ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['con_criado_em'])) ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['con_alterado_em'])) ?></td>
                                            <td class="center">
                                                <?= ($row['con_ativo'] == "1"? "Ativado" : "Desativado") ?>
                                            </td>
                                            <td>
                                                <a href ="alterar.php?id=<?=$row['con_id']?>" class ="btn btn-info">
                                                    <i class ="fa fa-edit"></i>&nbsp;Editar
                                                </a>
                                            
                                                <a href ="deletar.php?id=<?=$row['con_id']?>" class ="btn btn-danger">
                                                    <i class ="fa fa-trash"></i>&nbsp;Apagar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Sem conteúdos publicados</td>
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