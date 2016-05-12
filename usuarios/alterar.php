<?php

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
    
    /***
     * $aviso é uma variável para retornar mensagens para o usuário
     * caso queira, como campos vazios, incorretos, entre outros
     */
    $aviso = "";
    
    
    /****
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
    if(!isset($_GET['id'])){
        header("location: index.php");
    }else{
        
        /***
         * Para saber qual usuário vamos trabalhar, 
         * pegamos o valor do id que está na URL
         */
        $id = $_GET['id'];
        
        //Conectamos ao banco de Dados para ter acesso à ele
        conectaDB();

        /***
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
        $query_busca = sprintf("SELECT * FROM usuarios WHERE id = '%d'", $id);
        $array_usuarios = mysql_query($query_busca);
        $usuario = mysql_fetch_array($array_usuarios);
        
        
        /***
         * Verificaremos aqui se o formulário foi enviado, 
         * para podermos fazer todos os tratamentos, validações e
         * se não houver nenhum problema, alterarmos os dados do usuário
         * 
         */
        if(isset($_POST['nome_completo'])){

            /**
             * Armazenamos em variáveis os dados enviados pelo formulário
             * Para facilitar o trabalho e identificação
             */
            
            $nome_completo = $_POST['nome_completo'];
            $nome_usuario = $_POST['nome_usuario'];
            $senha_atual = $_POST['senha_atual'];
            $senha = $_POST['senha'];
            $conf_senha = $_POST['conf_senha'];
            
            
            /***
             * empty é utilizado para verificar se a variável não está vazia
             * o caracter !, significa não para leitura
             * 
             * No caso verificamos se as variaveis obrigatorias não estao vazias para 
             * prosseguirmos com a alteração do usuário
             */

            if(!empty($nome_completo) && !empty($nome_usuario) && !empty($senha_atual)){

                /****
                 * md5() é uma função que criptografa um texto tornando o indecifravel
                 * Para maior segurança salvamos a senha no banco de dados criptografada
                 * 
                 * Não é possivel descriptografar uma hash md5, então para comparamos
                 * a senha informada no formulário e a que está armazenada no banco, 
                 * criptografamos a recebida pelo formulário e comparamos com a armazenada
                 *
                 * 
                 * Exemplo de hash md5
                 * md5("1234") = "ab56b4d92b40713acc5af89985d4b786"
                 */
                
                if(md5($senha_atual) == $usuario['senha']){
                    
                    /**
                     * Verificamos se a nova senha esta vazia ou se a nova senha
                     * é igual à confirmação de senha
                     */
                    if(empty($senha) || $senha == $conf_senha){
                        

                        /***
                         * O nome de usuário deve ser único, então antes de 
                         * alterar o nome de usuário, devemos verificar se não 
                         * existe um outro igual e que tenha id diferente do 
                         * usuário que estamos trabalhando
                         */
                        $query_busca = sprintf("SELECT * FROM usuarios WHERE nome_usuario LIKE '%s' AND id <> %d", 
                                    addslashes($nome_usuario), $id);

                        $array_usuarios = mysql_query($query_busca);

                        /****
                         * mysql_num_rows($array) retorna o número de registros
                         * da consulta realizada
                         * 
                         * Nesse caso, se for 0, podemos prosseguir com a 
                         * alteração dos dados do usuário
                         */
                        if(mysql_num_rows($array_usuarios) == 0){

                            $query_alterar  ="";
                            
                            /****
                             * Caso o usuário tenha informado uma nova senha, 
                             * vamos atualizar ela, caso não, montamos uma 
                             * query com atualizaçao do nome de usuario e nome
                             * completo somente
                             */
                            
                            if(!empty($senha)){
                            
                                $query_alterar = sprintf("UPDATE usuarios SET nome_completo = '%s', nome_usuario = '%s', senha = md5('%s')"
                                        . " WHERE id = %d", 
                                        addslashes($nome_completo),
                                        addslashes($nome_usuario),
                                        addslashes($senha), 
                                        $id
                                    );
                            }else{
                                 $query_alterar = sprintf("UPDATE usuarios SET nome_completo = '%s', nome_usuario = '%s'"
                                        . " WHERE id = %d", 
                                        addslashes($nome_completo),
                                        addslashes($nome_usuario), 
                                        $id
                                    );
                            }

                            /***
                             * Executamos o comando para alterar os dados do 
                             * usuário e recebemos o status em uma variável, 
                             * para sabermos se houve sucesso ou não.
                             * 
                             * Depois desconectamos do DB, pois não precisamos 
                             * mais acessá-lo
                             */
                            
                            $resultado_alterar = mysql_query($query_alterar);
                            desconectaDB();

                            /**
                             * Se a query for executada com sucesso, redirecionamos
                             * para a página de listagem dos cadastros, 
                             * enviamos junto ao link, action = 2, para
                             * exibirmos na página de listagem que alteramos
                             * com sucesso o usuário
                             */
                            if($resultado_alterar){
                                header("location: index.php?action=1");
                            }else{
                                $aviso = "Ocorreu algum problema ao atualizar o usuário, tente novamente";
                            }
                        }else{
                             $aviso = "Nome de usuário já existe";
                        }
                    }else{
                       $aviso = "Senhas não conferem";
                    }
                }else{
                    $aviso = "Senha Incorreta";
                }
            }else{
                $aviso = "Por favor, preencha os campos Nome Completo, Nome de Usuário e Senha Atual!";
            }        
        }
    }
?>

<!---
Aqui está o conteúdo que será exibido no navegador para quem está acessando

O HTML é uma abreviação de HyperText Markup Language ou seja que em português significa, 
Linguagem de marcação de Hipertexto. Os arquivos HTML são interpretados pelos navegadores (browsers), 
portanto, caso você tenha algum arquivo HTML no computador, basta pedir que o seu navegador abra ele.

O HTML trabalha com o sistema de tags (etiquetas). Esse sistema funciona da seguinte maneira.
Ex: <tag>Conteúdo da tag</tag>

Toda tag aberta, deve ser fechada, salvo raras exceções, nesses casos ela pode ser fechada da seguinte maneira:
</tag>

Uma tag HTML pode conter outra tag dentro dela, e quantas forem necessárias.
<tag>
  <outraTag>texto</outraTag>
</tag>

Read more: http://www.linhadecodigo.com.br/artigo/81/html-basico.aspx#ixzz48TIg5HOw


Para indicarmos ao navegador que temos conteudo para ele, devemos iniciar
com a tag <html> e esta deverá ser fechada somente ao fim de todo o conteúdo que
o navegador deve ler (geralmente é no fim da página)

-->
<html>
    
    <!---
    <head>...</head> contém informações que não foram ainda colocadas no nosso 
    exemplo, a mais importante destas informações é o título da página que 
    aparece na barra de títulos do navegador. Você dá um título a sua página, 
    escrevendo-o dentro da tag title, como mostrado a seguir...
    
    Read more: http://www.maujor.com/tutorial/joe/cssjoe1.php
    -->
    <head>
        <title>Novo Usuário</title>
    </head>
    
    
    <!---
    Qualquer conteúdo deve ser colocado entre o par de tags<body>...</body> para que o navegador possa renderizá-lo.
    
    Read more: http://www.maujor.com/tutorial/joe/cssjoe1.php

    -->
    <body>
        
        <!--
        Tag <a href="link_para_ir">Texto de Exibição do Link</a>
        No exemplo abaixo, o link redirecionará para a página index.php
        O texto entre as tags, será o que vai ser exibido para o navegador
        -->
        
        <a href = "index.php">Ir para Lista</a>
        
        <!--
        Tag <br /> realiza uma quebra de linha no conteúdo
        Tag <br /> realiza uma quebra de linha no conteúdo, exibindo uma linha
        -->
        <br />
        <hr />
        
        
        <!---
        Aqui temos a mistura de PHP com HTML pois o nosso conteúdo é dinamico
        Sempre que precisarmos adicionar um código PHP no conteúdo HTML, 
        devemos colocar todo o código PHP entre as tags <?php echo "<?php ?>"?>
        O conteúdo da TAG pode ocupar inúmeras linhas, sem causar problemas.
        
        Mas é recomendado deixar o conteúdo de PHP e HTML separados, 
        para facilitar a leitura do código e não bagunçar, 
        
        recomenda se usar PHP junto ao HTML somente em casos de condicionais, 
        laços e exibição de conteúdo dinâmico
        
        No exemplo abaixo, abrimos a TAG PHP para verificar sem existe algum 
        aviso para exibir no navegador
        
        $aviso já foi definido no topo do arquivo, onde faziamos as validações
        Caso tenha alguma mensagem nele, sera exibido para o navegador dentro da
        tag h5, que deixa o conteúdo com uma formatação diferente do texto normal
        
        utilizamos o caracter ":" para indicar que ali começa o conteudo do 
        if caso verdadeiro
        
        para indicarmos o fim do if, utilzamos a palavra chave endif;
        
        -->
        <?php if(!empty($aviso)):?>
            <h5><?php echo $aviso ?></h5>
            <hr />
        <?php endif;?>
            
        
        
        <!---
        A tag <form> é usada para indicarmos que dentro dela, teremos conteúdo de
        formulário
        
        São necessários alguns atributos, como o tipo de envio dos dados e para 
        onde esses dados vão, são eles:
        
        method="", podem ser usados os valores POST ou GET
        action="", arquivo para o qual serão enviados os dados e processados
        
        -->
        <form method ="POST" action="alterar.php?id=<?php echo $usuario['id']?>">
            
            <!---
            A tag <label> é usada para exibir um texto antes de um campo, 
            para dar uma descrição do campo que o segue
            O atributo for="" indica à qual campo o label pertence
            
            a tag <input> é usada para indicar um campo onde devera ser inserido
            informações, que podem ser pelo usuario ou pelo proprio sistema
            
            atributos:
            type="" 
                indica o tipo de campo que deve ser, texto(text), 
                senha(password), entre outros...
            name="" 
                indica o nome que será passado para a action no formulário, 
                o nome que poderá ser resgatado via POST ou GET
            value=""
                adicionar um valor ao campo
                
            --->
            <label for="nome_completo">Nome Completo</label>
            <input type="text" name="nome_completo" value="<?php echo $usuario['nome_completo']?>"/>
            <br />
            
            <label for="nome_usuario">Nome de Usuário</label>
            <input type="text" name="nome_usuario" value="<?php echo $usuario['nome_usuario']?>"/>
            <br />
            
            <label for="senha_atual">Senha</label>
            <input type="password" name="senha_atual"/>
            <br />
            
            <label for="senha">Nova Senha</label>
            <input type="password" name="senha"/>
            <br />
            
            <label for="conf_senha">Confirme a nova Senha</label>
            <input type="password" name="conf_senha"/>
            <br />
            
            <!--
            a tag <input type="reset"> é usada para apagar todos os campos do 
            formulário
            
            a tag <input type="submit"> é usada para enviar o formulario
            O atributo value="" é usado para indicar o texto a ser exibido
            
            -->
            
            <input type ="reset" value="Limpar os Dados"/>
            <input type="submit" value ="Alterar Usuário" />
        </form>
    </body>
</html>
