<?php
// Pega as configuracoes
include('config.php');

// Checa se o usuario esta logado
if(isset($_COOKIE[md5('logincookie75')])){
	if($_COOKIE[md5('logincookie75')]==md5('5ATIVADO6')){
		setcookie(md5('logincookie75'),'',time()-3600*TEMPO_COOKIE,'/');
		echo "
			<script type='text/javascript'>
				window.location='login.php';
			</script>
		";
	}
}else{
	echo "
	<script type='text/javascript'>
		window.location='login.php';
	</script>
	";
}

?>