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

$query_usuarios = "SELECT * FROM usr_usuarios ORDER BY usr_id DESC";
$res_usuarios = mysql_query($query_usuarios);

desconecta_db();

?>

<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Usuários</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <a href ="criar.php" class ="btn btn-success">Novo Usuário</a>
            
            <div class="clearfix"/><br /></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-users fa-fw"></i>&nbsp;Usuários
                    
                    

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class='center'>#</th>
                                    <th class='center'>Nome</th>
                                    <th class='center'>Login</th>
                                    <th class='center'>Criado</th>
                                    <th class='center'>Atualizado em</th>
                                    <th class="center">Status</th>
                                    <th class="center">Ação</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (mysql_num_rows($res_usuarios) > 0): ?>
                                    <?php while ($row = mysql_fetch_array($res_usuarios)): ?>
                                        <tr>
                                            <td class='center'><?= $row['usr_id'] ?></td>
                                            <td><?= $row['usr_nome'] ?></td>
                                            <td><?= $row['usr_login'] ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['usr_criado_em'])) ?></td>
                                            <td class='center'><?= date('d/m/Y H:i:s', strtotime($row['usr_alterado_em'])) ?></td>
                                            <td class="center">
                                                <?= ($row['usr_ativo'] == "1"? "Ativado" : "Desativado") ?>
                                            </td>
                                            <td>
                                                <a href ="alterar.php?id=<?=$row['usr_id']?>" class ="btn btn-info">
                                                    <i class ="fa fa-edit"></i>&nbsp;Editar
                                                </a>
                                            
                                                <a href ="deletar.php?id=<?=$row['usr_id']?>" class ="btn btn-danger">
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