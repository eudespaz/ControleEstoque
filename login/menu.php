<?php
# Gera dois tipos de menu:
# Deslogado - ( Login | Cadastro )
# Cadastro - ( Logout )

if(isset($_COOKIE[md5('logincookie75')])){
	if($_COOKIE[md5('logincookie75')]==md5('5ATIVADO6')){
		// Menu logado
		echo "( <a href='logout.php'>Sair</a> )";
	}
}else{
	// Menu deslogado
	//echo "( <a href='cadastro.php'>Cadastro</a> | <a href='login.php'>Login</a> )";
}
?>