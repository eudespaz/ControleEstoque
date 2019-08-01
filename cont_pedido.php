<?php include('login/trancar.php');  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Entrada de Estoque";
		require_once ("includes/header.php"); 
	?>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			 ?>
			
			<div id="principal">
					
				<?php // essa pagina faz parte do cadastro de entrada de estoque
					if($_POST['enviar']) 
					{
                        $fornecedor = $_POST['fornecedor'];
						$numeronf = $_POST['numeronf'];
						$valornf = $_POST['valornf'];
						$data = $_POST['data'];
						$data = implode("-", array_reverse(explode("-", $data)));
						$cadastra = mysql_query("INSERT INTO entra(CONTROLE,NFNR,DATA,VALORNF,FORNECEDOR) values('','$numeronf','$data','$valornf','$fornecedor')");
                     }
						$sql3= mysql_query("SELECT CONTROLE FROM entra order by CONTROLE desc");				
						$controlee = mysql_fetch_array($sql3);
						$controle = $controlee['CONTROLE'];
						$i = $_POST['nritem'];



					
				?>				
				<form method="post" action="fin_pedido.php">
					<fieldset>
						<legend class="titulo">Escolha o Produto</legend>
						<input type="hidden" name="controle" value="<?php echo $controle; ?>" />
						<input type="hidden" name="nritem" value="<?php echo $i; ?>" />
						<label>Produto</label>
						<select name="produto">
							<option>Selecione um Produto...</option>	
							<?php
								$sql= mysql_query("SELECT PRODUTO, CODPROD,CUSTO FROM produtos order by PRODUTO") or die("Erro");
								while ( $query = mysql_fetch_array($sql))
								{
									echo "<option value='".$query['CODPROD']."'>".$query['PRODUTO']."</option>";								
								}
							?>							
						</select><br />	
						<label>Quantidade</label>
						<input type="text" name="quantidade" maxlength="6" /><br />	
						<label>Custo Unit&aacute;rio</label>
						<input type="text" name="custoun" maxlength="6" /><br />
						<input class="botao" type="submit" name="add" value="Adicionar"/>	
					</fieldset>		
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php  include('includes/fimerodape.php'); ?>
			
</body>
</html>
