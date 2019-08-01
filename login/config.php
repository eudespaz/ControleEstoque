<?php
# Configure diante de sua vontade
# Leia os comentarios atentamente
# O reCAPTCHA agora e XHTML Valido
# Uso do reCAPTCHA nao aconselhado no login
# Ha configuracoes que so podem ser colocadas uma vez:
# USA_MD5, MIN_.
# Caso troque-as mais de uma vez, pode causar erros no servidor.

// MySQL
define('M_USUARIO','eudespaz');		// Usuario do MySQL
define('M_SENHA','pazeds1234');	// Senha do MySQL
define('M_HOST','localhost');	// Host do MySQL
define('M_BD','controle');		// Nome do banco de dados

// Configuracoes Login
define('USA_MD5','1');			// Usar encriptacao MD5 (0=NAO) (1=SIM)
define('TEMPO_COOKIE','24');	// Tempo de duracao do cookie (1=UMA HORA)
define('L_USAR_CAPTCHA','0');	// Usar checagem de letras (0=NAO) (1=SIM)
define('P_INDEX','../index.php');	// Pagina protegida que sera acessada apos o login

// Configuracoes Cadastro
define('MIN_USUARIO',3);		// Minimo de caracteres
define('MAX_USUARIO',32);		// Maximo de caracteres (MAX=32)
define('MIN_SENHA',3);			// Minimo de caracteres
define('MAX_SENHA',32);			// Maximo de caracteres (MAX=32)
define('C_USAR_CAPTCHA','0');	// Usar checagem de letras (0=NAO) (1=SIM)

// Configuracoes Captcha
define('PUBLIC_KEY','6LePWwQAAAAAAJ_zwfE0zGyIhjMptUgI3CNXGnph');	// Public Key dado na ReCaptcha
define('PRIVATE_KEY','6LePWwQAAAAAALB6vmvx413jk3uSV_C0tX3psFPn');	// Private Key dado na ReCaptcha

// Mensagens
$msg[0] = 'Preencha todos os campos.';					// Campos nulos 		(Login,Cadastro)
$msg[1][0] = 'Usu&aacute;rio ou senha n&atilde;o correspondem.';		// Erro nas informacoes (Login)
$msg[1][1] = 'Esse usu&aacute;rio j&aacute; existe, escolha outro.';	// Erro nas informacoes (Cadastro)
$msg[2][0] = 'Login efetuado! Aguarde';					// Sucesso 				(Login)
$msg[2][1] = 'Cadastro efetuado! Aguarde';				// Sucesso 				(Cadastro)
$msg[3] = 'Erro do sistema, tente outra hora.';			// Erro (MySQL,Query) 	(Login,Cadastro)
$msg[4] = 'Campo de verifica&ccedil;&atilde;o incorreto.';			// reCAPTCHA incorreto	(Login,Cadastro)

?>
