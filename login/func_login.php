<?php
$data='';
# Possiveis valores para data
# 0: Campos em branco
# 1: Login/Senha errados
# 2: Login efetuado
# 3: Erro do servidor (mysql,bd,query)
# 4: Captcha incorreto

// Pega as configuracoes
include('config.php');

// Funcao para conectar
Function ConectaMysql(){
	$conecta = mysql_connect(M_HOST,M_USUARIO,M_SENHA) or exit();
	$banco = mysql_select_db(M_BD,$conecta) or exit();
	mysql_errno()==0 ? $r=true : $r=false;
return $r;
}

// Funcao para filtrar (Anti-SQL-Injection)
Function Filtrar($str){
	$sql = preg_replace(sql_regcase('/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/'),'',$str);
	$sql = trim($str);
	$sql = strip_tags($str);
	$sql = addslashes($str);
return $str;
}

// Pega as variaveis e checa-as
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	$usuario = Filtrar($_POST['usuario']);
	$senha = Filtrar($_POST['senha']);
	if( L_USAR_CAPTCHA == '1' ){
		include_once('extra/recaptcha.php');
		$resp = recaptcha_check_answer(PRIVATE_KEY,$_SERVER['REMOTE_ADDR'],$_POST['recaptcha_challenge_field'],$_POST['recaptcha_response_field']);
		!$resp->is_valid ? $data='4' : '';
	}
	$usuario=='' ? $data='0' : '';
	$senha=='' ? $data='0' : '';
	!isset($usuario[MIN_USUARIO-1]) || !isset($senha[MIN_SENHA-1]) ? $data='0' : '';
	isset($usuario[MAX_USUARIO]) || isset($senha[MAX_SENHA]) ? $data='0' : '';
	!ctype_alnum($usuario) ? $data='0' : '';
	!ctype_alnum($senha) ? $data='0' : '';
	if($data!='0'){
		USA_MD5 == 1 ? $senha=md5($senha) : '';
	}
	
	// Checa se o usuario existe(seguranca), efetua login
	if($data==''){
		if(ConectaMySQL()){
			$pesquisa = mysql_query("SELECT * FROM syslogin WHERE usuario='".$usuario."';");
			if($pesquisa and mysql_num_rows($pesquisa)>0 and mysql_errno()==0){
				$loga = mysql_query("SELECT * FROM syslogin WHERE usuario='".$usuario."' and senha='".$senha."';");
				if($loga and mysql_num_rows($loga)>0 and mysql_errno()==0){
					setcookie(md5('logincookie75'),md5('5ATIVADO6'),time()+3600*TEMPO_COOKIE,'/');
					$data = '2';
				}else{$data='1';}
			}else{$data='1';}
			mysql_close();
		}else{$data='3';}
	}
	
}

// Retorna a data final
echo $data;
?>