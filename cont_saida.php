<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Nova Sa&iacute;da de Estoque";
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
					if($_POST['cadastrar'])
					{
						 $entregar = $_POST['entregar'];
						 if($entregar <> '')
						 	$entregar = 1;
						 else
						 	$entregar = 0;
                   $controle = $_POST['contrsaida'];
					    $coddest = $_POST['coddest'];
					    $nomedest = mysql_query("SELECT * FROM destinos WHERE CODDEST = $coddest");
					    $achadest = mysql_fetch_array($nomedest);
					    $destino = $achadest['DESCRICAO'];
					    $data = $_POST['data'];
					    $data = implode("-", array_reverse(explode("-", $data)));
					    $responsavel = $_POST['responsavel'];
				     	 $obs = $_POST['obs'];
                   $sql = mysql_query("INSERT INTO saidas(CONTRSAI,DOCUMENTO,DESTINO,NOMEDEST,DATA,RESPONSAV,OBS,ENTREGAR) values('',NULL ,'$coddest','$destino','$data','$responsavel','$obs','$entregar')");
                    }
                    $cont = mysql_query("SELECT CONTRSAI FROM saidas ORDER BY CONTRSAI desc");
                    $achacont = mysql_fetch_array($cont);
                    $controle = $achacont['CONTRSAI'];
                    
                    $i = $_POST['nrit'];
						$produtos = mysql_query("SELECT CODPROD,PRODUTO FROM produtos order by PRODUTO");

                ?>
				<form action="fin_saida.php" method="post">
					<fieldset>
						<input type="hidden" name="coddest" value="<?php echo $coddest; ?>" />
						<input type="hidden" name="contrsaida" value="<?php echo $controle; ?>" />
						<input type="hidden" name="nrit" value="<?php echo $i; ?>" />
						<label>Produto</label>						
						<select name="produto">
							<option>Selecione um Produto...</option>	
							<?php
								while ( $query = mysql_fetch_array($produtos))
								{
									echo "<option value='".$query['CODPROD']."'>".$query['PRODUTO']."</option>";								
								}
							?>							
						</select><br />	
						<label>Quantidade</label>
						<input type="text" name="quantidade" maxlength="6" /><br />
						
						<input class="botao" type="submit" name="adicionar" value="Adicionar" />
					</fieldset>						
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>
