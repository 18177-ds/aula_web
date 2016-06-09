<?php
require '../utils/bd.php';

$aviso = "";

if (isset($_POST['nome_completo'])) {

    $nome_completo = $_POST['nome_completo'];
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];
    $conf_senha = $_POST['conf_senha'];

    if (!empty($nome_completo) && !empty($nome_usuario) && !empty($senha) && !empty($conf_senha)) {

        if ($senha == $conf_senha) {

            conectaDB();

            $query_busca = sprintf("SELECT * FROM usuarios WHERE nome_usuario LIKE '%s'", addslashes($nome_usuario));
            $array_usuarios = mysql_query($query_busca);

            if (mysql_num_rows($array_usuarios) == 0) {


                $query_inserir = sprintf("INSERT INTO usuarios VALUES (NULL, '%s', '%s', md5('%s'))", addslashes($nome_completo), addslashes($nome_usuario), addslashes($senha)
                );

                $resultado_inserir = mysql_query($query_inserir);

                desconectaDB();

                if ($resultado_inserir) {
                    header("location: index.php?action=2");
                } else {
                    $aviso = "Ocorreu algum problema ao criar usuário, tente novamente";
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


<html>
    <head>
        <title>Novo Usuário</title>
    </head>

    <body>
        <a href = "index.php">Ir para Lista</a>
        <br />
        <hr />

        <?php if ($aviso != ""): ?>
            <h5><?php echo $aviso ?></h5>
            <hr />
        <?php endif; ?>

        <form method ="POST" action="criar.php">
            <label for="nome_completo">Nome Completo</label>
            <input type="text" name="nome_completo"/>
            <br />

            <label for="nome_usuario">Nome de Usuário</label>
            <input type="text" name="nome_usuario"/>
            <br />

            <label for="senha">Senha</label>
            <input type="password" name="senha"/>
            <br />

            <label for="conf_senha">Confirme a Senha</label>
            <input type="password" name="conf_senha"/>
            <br />

            <input type ="reset" value="Limpar os Dados"/>
            <input type="submit" value ="Criar Usuário" />
        </form>

    </body>
</html>

