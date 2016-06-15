<?php


/**
 * 
 * Sessão é um recurso do PHP que permite que você salve valores (variáveis) 
 * para serem usados ao longo da visita do usuário. Valores salvos na sessão
 *  podem ser usados em qualquer parte do script, mesmo em outras páginas do 
 * site. São variáveis que permanecem setadas até o visitante fechar o browser
 *  ou a sessão ser destruída. 
 * http://blog.thiagobelem.net/aprendendo-a-usar-sessoes-no-php
 * 
 * Verifica se usuário está logado, se não estiver, redireciona para página de login
 */
session_start();

if(!isset($_SESSION['usuario'])){
    header("location: ../login/");
}


/**
 * require é usado para tornar o conteúdo, como variáveis 
 * e funções disponíveis para esta página.
 * 
 * O "../" serve para voltar uma pasta acima
 * Este arquivo está dentro da pasta usuários,
 * então para acessar o arquivos bd.php em utils precisamos
 * 
 * Voltar uma pasta acima "../"
 * Entrar na pasta utils "utils/"
 * indicar o arquivo que queremos importar "bd.php" 
 */
require '../utils/bd.php';

/* * *
 * $aviso é uma variável para retornar mensagens para o usuário
 * caso queira, como campos vazios, incorretos, entre outros
 */
$aviso = "";


/* * **
 * Verificamos aqui se exista a variável id no método GET
 * O método GET, exibe as informações na URL
 * 
 * Para transportar informações pelo GET, usamos o seguinte padrão
 * www.dominio.com.br/nome_do_projeto/caminho/do/arquivo/php/arquivo.php?chave1=valor1&chave2=valor2
 * 
 * Após o o nome do arquivo, adicionamos o "?" para indicar que vamos informar valores
 * Após o "?", adicionamos sem espaços, o nome da chave que queremos indicar, id por exemplo
 * Após o nome da chave, adicionamos "=" para indicar que vamos informar o valor
 * Após o "=" informamos o valor que vamos dar a chave
 * Caso queira enviar mais de uma informação, adicionamos o caracter "&"
 * 
 * Exemplo
 * localhost/aula_web/usuarios/alterar.php?id=1
 * Com esse link, podemos pegar o valor um atraves da função
 * $id = $_GET['id];
 * Assim, $id terá o valor 1
 * 
 * 
 * Na condição abaixo, verificamos se existe a chave 'id' pelo método GET
 * Se não existir, ele redireciona para a página index.php, que faz as listagens dos usuários
 */
if (!isset($_GET['id'])) {
    header("location: index.php");
} else {

    /*     * *
     * Para saber qual usuário vamos trabalhar, 
     * pegamos o valor do id que está na URL
     */
    $id = $_GET['id'];

    //Conectamos ao banco de Dados para ter acesso à ele
    conecta_db();

    /*     * *
     * Vamos realizar uma consulta ao banco de dados para resgatar os 
     * dados do usuário ao qual estamos manipulando
     * 
     * $query_busca é o comando que usariamos diretamente no myql ou no phpmyadmin
     * para buscar o usuario com o id informado
     * 
     * A função sprintf serve para filtrar o conteúdo que o texto vai receber,
     * ele é um auxiliar para evitar SQL Injection
     * 
     * Onde usamos WHERE id = '%d', significa que ali só aceitará valores inteiros
     * Após o fim do texto, separados por virgulas, colocamos as váriaveis que
     * substituiram os %d, %s, %c, %f, etc
     * 
     * No exemplo abaixo a variavel $query_busca tera o seguinte valor
     * SELECT * FROM usuarios WHERE id = '(Valor Inteiro da váriavel $id)';
     * 
     * Supondo que $id tenha valor 1, a query ficaria
     * SELECT * FROM usuarios WHERE id = '1';
     * 
     * 
     * mysql_query($query) irá executar um comando SQL, 
     * como se estivesse direto pelo mysql e retornará os resultados
     * da consulta como um array (vetor de objetos)
     * 
     * No exemplo abaixo, executando o comando mysql_query($query_busca),
     * ele armanezará na variavel $array_busca, todos os usuários que 
     * tenham id igual ao id informado pelo GET, no exemplo, estamos
     * utilizando id = 1
     * 
     * 
     * mysql_fetch_array($array) retorna somente um cadastro do resultado da
     * consulta SQL realizada, esse cadastro, ficara armazenada na variável que
     * a recebe e poderá ser manipulada
     * 
     * Para acessarmos os dados do cadastro, usamos o seguinte modelo
     * $variavel_que_recebeu_o_cadastro['nome_da_coluna_da_tabela']
     * 
     * 
     * No exemplo abaixo, ele vai armazenar os dados de cadastro do usuário que
     * tem id = 1 na variável $usuario
     * 
     * Para acessarmos os dados do usuarios, fazemos o seguinte
     * 
     * $id_do_usuario = $usuario['id']
     * $qualquer_nome = $usuario['nome_da_coluna']
     * 
     */
    $query_busca = sprintf("SELECT * FROM usr_usuarios WHERE usr_id = '%d'", $id);
    $array_usuarios = mysql_query($query_busca);
    $usuario = mysql_fetch_array($array_usuarios);


    /*     * *
     * Verificaremos aqui se o formulário foi enviado, 
     * para podermos fazer todos os tratamentos, validações e
     * se não houver nenhum problema, alterarmos os dados do usuário
     * 
     */
    if (isset($_POST['nome_completo'])) {

        /**
         * Armazenamos em variáveis os dados enviados pelo formulário
         * Para facilitar o trabalho e identificação
         */
        $nome_completo = addslashes($_POST['nome_completo']);
        $nome_usuario = addslashes($_POST['nome_usuario']);
        $senha = addslashes($_POST['senha']);
        $conf_senha = addslashes($_POST['conf_senha']);
        $ativo = addslashes($_POST['ativo']);


        /*         * *
         * empty é utilizado para verificar se a variável não está vazia
         * o caracter !, significa não para leitura
         * 
         * No caso verificamos se as variaveis obrigatorias não estao vazias para 
         * prosseguirmos com a alteração do usuário
         */

        if (!empty($nome_completo) && !empty($nome_usuario)) {

            /**
             * Verificamos se a nova senha esta vazia ou se a nova senha
             * é igual à confirmação de senha
             */
            if (empty($senha) || $senha == $conf_senha) {

                /*                     * *
                 * O nome de usuário deve ser único, então antes de 
                 * alterar o nome de usuário, devemos verificar se não 
                 * existe um outro igual e que tenha id diferente do 
                 * usuário que estamos trabalhando
                 */
                $query_busca = sprintf("SELECT * FROM usr_usuarios WHERE usr_login LIKE '%s' AND usr_id <> %d", $nome_usuario, $id);

                $array_usuarios = mysql_query($query_busca);

                /*                     * **
                 * mysql_num_rows($array) retorna o número de registros
                 * da consulta realizada
                 * 
                 * Nesse caso, se for 0, podemos prosseguir com a 
                 * alteração dos dados do usuário
                 */
                if (mysql_num_rows($array_usuarios) == 0) {

                    $query_alterar = "";

                    /*                         * **
                     * Caso o usuário tenha informado uma nova senha, 
                     * vamos atualizar ela, caso não, montamos uma 
                     * query com atualizaçao do nome de usuario e nome
                     * completo somente
                     */

                    if (!empty($senha)) {

                        $query_alterar = sprintf("UPDATE usr_usuarios SET usr_nome = '%s', usr_login = '%s',"
                                . " usr_password = md5('%s'), usr_ativo = %d WHERE usr_id = %d",
                                $nome_completo, $nome_usuario, $senha, $ativo, $id);
                    } else {
                        $query_alterar = sprintf("UPDATE usr_usuarios SET usr_nome = '%s', usr_login = '%s',"
                                . " usr_ativo = %d WHERE id = %d", 
                                $nome_completo, $nome_usuario, $ativo, $id);
                    }

                    /*                         * *
                     * Executamos o comando para alterar os dados do 
                     * usuário e recebemos o status em uma variável, 
                     * para sabermos se houve sucesso ou não.
                     * 
                     * Depois desconectamos do DB, pois não precisamos 
                     * mais acessá-lo
                     */

                    $resultado_alterar = mysql_query($query_alterar);
                    desconecta_db();

                    /**
                     * Se a query for executada com sucesso, redirecionamos
                     * para a página de listagem dos cadastros, 
                     * enviamos junto ao link, action = 1, para
                     * exibirmos na página de listagem que alteramos
                     * com sucesso o usuário
                     */
                    if ($resultado_alterar) {
                        header("location: index.php?action=2");
                    } else {
                        $aviso = "Ocorreu algum problema ao atualizar o usuário, tente novamente";
                    }
                } else {
                    $aviso = "Nome de usuário já existe";
                }
            } else {
                $aviso = "Senha não conferem";
            }
        } else {
            $aviso = "Por favor, preencha os campos Nome Completo e Nome de Usuário";
        }
    }
}
?>


<?php include '../layout/_header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Alterar Usuário</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Formulário de Usuário
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7 col-md-offset-1 col-sm-12 col-sm-offset-0">
                            <form class='form-horizontal' method="POST" action="alterar.php?id=<?=$usuario['usr_id']?>">
                                
                                <?php if(!empty($aviso)):?>
                                    <div class="alert alert-danger"><?=$aviso?>></div>
                                <?php endif;?>
                                    
                                <div class="form-group">
                                    
                                    <label for='nome_completo' class="col-md-2 control-label">Nome Completo</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="nome_completo" type="text" value="<?=$usuario['usr_nome']?>">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='nome_usuario' class="col-md-2 control-label">Nome de Usuário</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="nome_usuario" type="text" value="<?=$usuario['usr_login']?>">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    
                                    <label for='senha' class="col-md-2 control-label">Senha</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="senha" type="password">
                                    </div>
                                </div>
                                    
                                    
                                <div class="form-group">
                                    
                                    <label for='conf_senha' class="col-md-2 control-label">Confirme a Senha</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <input class="form-control" name="conf_senha" type="password">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for='ativo' class="col-md-2 control-label">Status</label>
                                    <div class='col-md-9 col-sm-12'>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo1" value="1" <?=($usuario['usr_ativo'] == 1? "checked": "")?>>&nbsp;Ativado
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="ativo" id="ativo2" value="0" <?=($usuario['usr_ativo'] == 0? "checked": "")?>>&nbsp;Desativado
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

