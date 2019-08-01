<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Grupos";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			 ?>
			
			<div id="principal">
				<?php
						$tabela = 'grupos';
						$res_codigo = 'CODGRUP';
						$res_nome = 'GRUPO';
						$_SESSION['tabela'] = $tabela;	
						include ('includes/search.php');	
				?>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>