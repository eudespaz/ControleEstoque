<?php
session_start();

//função anti sql injection
function anti_injection($txt)
{
        //Verifico se esta ativado magic_quotes caso esteja desativado uso a função addslashes
        $txt = get_magic_quotes_gpc() == 0 ? addslashes($txt) : $txt;
        //referencia:
        //http://www.php.net/get_magic_quotes_gpc
        //http://www.php.net/addslashes
       
        // retiro da variavel esses caracteres (--, #, *, ;)
        return preg_replace("@(--|\#|\*|;|=)@s", "", $txt);     
}

function verifica_usuario($nome, $senha)
{
        //conecto ao servidor de banco de dados passo o nome do servidor usuario e senha
        mysql_connect("localhost", "root", "");
        // seleciono o banco de dados
        mysql_select_db("estoquedse");

        /*faço uma pesquisa perguntando a quantidade de usuarios com o nome e a senha passada pelo usuario usando o count ele conta a quantidade de ocorrencias no select essa maneira é a forma mais rapida e correta desse tipo de pesquisa, muitas pessoas usam o select * from e pega com mysql_num_rows() dessa forma prejudica muito mais o acesso ao banco podendo travar se tiver muitos acessos simutaneos*/

        $re    = mysql_query("select count(*) as total from usuarios where nome = '$nome' and senha =
md5('$senha')");

        //referencia: http://www.php.net/md5 e http://www.php.net/mysql_result
        $total = mysql_result($re, 0, "total");
        mysql_close();
       
        /* se o total for diferente de 1 é porque o usuario nao esta cadastrado usando dessa forma o resultado esperado sempre sera 1 porque você precisa tbm criar um sistema de cadastros que deixe apenas um usuario ser cadastrado evitando usuarios repetidos */
        if($total != 1)
        {
        			//include('login.html');
 				 header("location:login.html");// redireciono para pagina de login
  					//exit;
        }       
        // se nao existir ja a sessao eu gravo ela
        if(!isset($_SESSION["dados"]))
        {
  $dados["nome"]     = $nome;
  $dados["senha"]    = $senha;
  //gravo a sessao por padrao o php hj ja passa o serialize automaticamente nao precisa mais passar ela
  $_SESSION["dados"] = serialize($dados);
        }       
}       

//verifico se existe a sessao e ja pego os dados que nela contem
if(isset($_SESSION["dados"]))
{
        $dados = unserialize($_SESSION["dados"]);
        $nome  = $dados["nome"];
        $senha = $dados["senha"];
        verifica_usuario($nome, $senha);
}
else
{
        //aqui eu verifico se o usuario esta vindo de um formulario e pego os valores
        $nome  = isset($_POST["nome"])  ? anti_injection($_POST["nome"])  : "";
        $senha = isset($_POST["senha"]) ? anti_injection($_POST["senha"]) : "";
        verifica_usuario($nome, $senha);
}

?>
</body>
</html>