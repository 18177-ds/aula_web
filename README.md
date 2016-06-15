<h1>Projeto de WEB</h1>

<p>Repositório para trabalhar com projeto da aula de Programação WEB I do 5º semestre do curso de Engenharia da Computação na Universidade do Vale do Paraíba </p>


<p>
    O projeto trata-se de um <i>CMS</i> (Sistema de Gerenciamento de Conteúdo) para sites, algo como <i>WordPress</i>
</p>

<p>
    O sistema está bem simples, devido ao pouco tempo para poder desenvolver, ele tem as opções de adicionar categorias e conteúdos a essas categorias
</p>

<p>
    Para demonstração, usamos dados como se fosse um blog de notícias
</p>

<p>
    Utilizamos o template SB Admin 2, disponível em https://github.com/BlackrockDigital/startbootstrap-sb-admin-2 . O SB Admin 2 é baseado no Bootstrap, 
    um framework front-end que facilita a criação da parte visual(HTML+CSS+JS) de um sistema WEB, sendo responsivo e tem um layout amigável, diminuindo 
    o tempo de desenvolvimento do layout de um sistema.
    <br />
    Baixamos os fontes do SB Admin 2 e colocamos na pasta <b>res</b>, e utilizamos as páginas de exemplo para criar as páginas que queriamos, 
    alterando para as nossas necessidades.
</p>

<p>
    Como nosso sistema possui um layout fixo para o topo da página e menu, criamos a pasta <b>layout</b> com dois arquivos:
    <ul>
        <li></i><b>_header.php: </b></i> contém os itens do head da página, como titulo, links para arquivos CSS, e no body, contém a parte do topo da página e do menu</li>
        <li></i><b>_footer.php: </b></i> contém a parte de JS do sistema, e fecha as tags html criadas no <b>_header.php</b></li>
    </ul>
</p>

<p>
    Os scripts de SQL estão na pasta <b>docs</b>, tendo um último backup do servidor mysql online e o SQL de criação do banco
</p>

<p>
    Os dados e funções de conexão e desconexão com o banco de dados, estão no arquivo <b>bd.php</b>, na pasta <b>utils</b>
</p>

<h6>Funcionamento do sistema</h6>

<p>
    O arquivo <b>index.php</b> na raiz do projeto, serve para redirecionar quem acessa para a página de login, caso não esteja logado ou para 
    a página de dashboard se já estiver logado.
</p>

<p>
    <b>login: </b> Tem dois arquivos:
    <ul>
        <li>
            <b>index.php: </b>é a página de login, recebe os dados do formulário, verifica se não estão vazios, depois verifica se existe um 
            usuário ativo com a senha e login informados, se existir, salva os dados do usuario em uma variável de sessão e redireciona para o dashboard,
            se não existir, retorna uma mensagem para a página de login
        </li>

        <li>
            <b>logout.php: </b> limpa os dados da sessão criada, proibindo o acesso ao sistema sem logar novamente
        </li>
    </ul>
<p>

<p>
    <b>dashboard: </b>Página principal do sistema, somente exibe a quantidades de dados no sistema e os 5 ultimos conteudos publicados
</p>

<p>
    <b>categorias: </b> Tem quatro arquivos:
    <ul>
        <li>
            <p>
                <b>index.php: </b> Exibe um botão para criar uma nova categoria e lista as categorias cadastradas, com botões de açao para editar e remover cada categoria 
            </p>
        </li>

        <li>
            <p>
                <b>criar.php: </b> Formulário para cadastrar uma categoria, ao enviar o formulário, ele verifica os campos, cadastra a categoria e redireciona para
                a listagem de categorias, caso não consiga cadastrar, exibe uma memnsagem de erro na página
            </p>
        </li>

        <li>
            <p>
                <b>alterar.php: </b> Formulário de uma categoria com os dados cadastrados, ao enviar o formulário, ele verifica os campos, altera a categoria e redireciona para
                a listagem de categorias, caso não consiga alterar, exibe uma mensagem de erro na página
            </p>
        </li>

        <li>
            <p>
                <b>deletar.php: </b> Açao para remover uma categoria, verifica se existe a categoria informada pelo id e apaga ela, depois redireciona para a listagem,
                caso nao exista a categoria ou não consiga remover, ele redireciona para a listagem com uma mensagem de erro. Não é possível remover uma categoria
                que tenha um conteudo vinculado a ela.
            </p>
        </li>
    </ul>
<p>

<p>
    <b>conteudos: </b> Tem quatro arquivos:
    <ul>
        <li>
            <b>index.php: </b> Exibe um botão para criar um novo conteudo e lista os conteudos cadastrados, com botões de açao para editar e remover cada conteudo 
        </li>

        <li>
            <b>criar.php: </b> Formulário para cadastrar um conteudos, ao enviar o formulário, ele verifica os campos, cadastro o conteudo e redireciona para
                a listagem de conteudos, caso não consiga cadastrar, exibe uma memnsagem de erro na página
        </li>

        <li>
            <b>alterar.php: </b> Formulário de um conteudos com os dados cadastrados, ao enviar o formulário, ele verifica os campos, altera o conteudo e redireciona para
                a listagem de conteudos, caso não consiga alterar, exibe uma mensagem de erro na página
        </li>

        <li>
            <b>deletar.php: </b> Açao para remover um conteudo, verifica se existe o conteudo informado pelo id e apaga ele, depois redireciona para a listagem,
                caso nao exista o conteudo ou não consiga remover, ele redireciona para a listagem com uma mensagem de erro
        </li>
    </ul>
<p>

<p>
    <b>usuarios: </b> Tem quatro arquivos:
    <ul>
        <li>
            <b>index.php: </b> Exibe um botão para criar um novo usuario e lista os usuarios cadastrados, com botões de açao para editar e remover cada usuario 
        </li>

        <li>
            <b>criar.php: </b> Formulário para cadastrar um usuario, ao enviar o formulário, ele verifica os campos, cadastro o usuario e redireciona para
                a listagem de usuarios, caso não consiga cadastrar, exibe uma memnsagem de erro na página
        </li>

        <li>
            <b>alterar.php: </b> Formulário de um usuario com os dados cadastrados, ao enviar o formulário, ele verifica os campos, altera o usuario e redireciona para
                a listagem de usuarios, caso não consiga alterar, exibe uma mensagem de erro na página
        </li>

        <li>
            <b>deletar.php: </b> Açao para remover um usuario, verifica se existe o usuario informado pelo id e apaga ele, depois redireciona para a listagem,
                caso nao exista o usario ou não consiga remover, ele redireciona para a listagem com uma mensagem de erro. Não é possível remover um usuário
                que seja autor de uma categoria ou conteúdo.
        </li>
    </ul>
<p>




<h1>Diretórios</h1>
<ul>
    <li><b>categorias: </b>CRUD de Categorias</li>
    <li><b>conteudos: </b>CRUD de Conteúdo</li>
    <li><b>dashboard: </b>Página do Dashboard, página inicial do sistema</li>
    <li><b>docs: </b>Scripts de criação e backup do Banco de Dados</li>
    <li><b>layout:</b>Arquivos  de cabeçalho e rodapé do sistema</li>
    <li><b>login: </b>Páginas de login e logout</li>
    <li><b>res: </b>Arquivos de CSS e JS do Sistema, baseados no Bootstrap</li>
    <li><b>usuarios: </b>CRUD de Usuários</li>
    <li><b>utils: </b>Arquivos utilitários, como conexão com BD</li>
    <li><b>index.php </b> Redireciona para o login ou dashboard se o usuário estiver logado </li>
</ul>

<code>Argel Gonçalves</code>
