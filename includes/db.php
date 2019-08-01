<?php
$dbhost = "localhost";
$dbuname = "eudespaz";
$dbpass = "pazeds1234";
$dbname = "controle";

mysql_connect($dbhost,$dbuname,$dbpass) or die ("<br /><br /><center>Problemas ao conectar no servidor: " . mysql_error() . "</center>");
$conn = mysql_select_db($dbname) or die ("<br /><br /><center>Problemas ao selecionar a base de dados do sistema: " . mysql_error() . "</center>");

//Função de fechamendo do banco
function close($conn)
{
	mysql_close($conn);
}
?>


