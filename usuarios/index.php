<?php

    require '../utils/bd.php';
    
    $aviso = "";
    
    if(isset($_GET['action'])){
        
        switch ($_GET['action']){
            case 1: 
                $aviso = "Usuário atualizado com sucesso!";
                break;
            case 2:
                $aviso = "Usuário criado com sucesso!";
                break;
            case 3: 
                if($_GET['status'] == 1){
                    $aviso = "Usuário removido com sucesso!";
                }else{
                    $aviso = "Usuário não pode ser removido!";
                }
                break;
                
            default :
                $aviso = $_GET['action'];
        }
    }

    conectaDB();

    $query_busca = "SELECT * FROM usuarios";
    $array_usuarios = mysql_query($query_busca);
    
    desconectaDB();

?>


<html>
    <head>
        <title>Lista de Usuários</title>
    </head>
    
    <body>
        <a href = "criar.php">Novo Usuário</a>
        <br />
        <hr />
        
         <?php if(!empty($aviso)):?>
            <h5><?php echo $aviso ?></h5>
            <hr />
        <?php endif;?>
            
            
        <table border ="1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome de Usuário</th>
                    <th>Nome Completo </th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>   
            </thead>
            <tbody>
                
                <?php if(mysql_num_rows($array_usuarios) > 0):?>
                
                    <?php while($usuario = mysql_fetch_array($array_usuarios)):?>
                        <tr>
                            <td><?php echo $usuario['id']?></td>
                            <td><?php echo $usuario['nome_usuario']?></td>
                            <td><?php echo $usuario['nome_completo']?></td>
                            <td>
                                <a href="alterar.php?id=<?php echo $usuario['id']?>">Editar</a>
                            </td>
                            <td>
                                <a href="deletar.php?id=<?php echo $usuario['id']?>">Remover</a>
                            </td>
                        </tr>   

                    <?php endwhile;?>
                        
                <?php else:?>
                    <tr>
                        <td colspan="5"><b>Sem registros!</td>
                    </tr>
                <?php endif;?>
                
            </tbody>
                
        </table>
        
    </body>
</html>

