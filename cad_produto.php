<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Cadastrar Produto";
		require_once ("includes/header.php"); 
	?>
	 <script type="text/JavaScript">
      function mascara_data(vencimento){
              var mydata = '';
              mydata = mydata + vencimento;
              if (mydata.length == 2){
                  mydata = mydata + '/';
                  document.forms[0].vencimento.value = mydata;
              }
              if (mydata.length == 5){
                  mydata = mydata + '/';
                  document.forms[0].vencimento.value = mydata;
              }
      }
    </script>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				$sql= mysql_query("SELECT * FROM grupos order by GRUPO");
				$sql2= mysql_query("SELECT * FROM unidades order by CODUNI");
				if ($_POST)
				{
					$nome = $_POST['produto'];
					$unidade = $_POST['unidade'];
					$grupo = $_POST['grupo'];
					$custo = $_POST['custo'];
					$customed = $custo;
					$vencimento = $_POST['vencimento'];
						$D = explode("/",$vencimento);
 						$vencimento = $D[2].'/'.$D[1].'/'.$D[0];
					if ($nome == '' ||  $unidade == 'Selecione..' || $grupo == 'Selecione um Grupo' || $custo == '' || $customed == '' || $vencimento == '')
						echo "<h3>Preencha/Selecione todos os campos</h3>";
					else					
						$cad = mysql_query ("INSERT INTO produtos(CODPROD,PRODUTO,UNIDADE,GRUPO,CUSTO,CUSTOMED,ESTOQUE,VENCTO) values(NULL,'$nome','$unidade','$grupo','$custo','$customed','','$vencimento') ") or die ("ERRO");	
					if ($cad != '')
						echo "<script>alert('Cadastro foi efetuado com sucesso');</script>";			
				}
			 ?>
			
			<div id="principal">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<fieldset>
						<legend class="titulo">Cadastro de Produto &darr; </legend>
						<label>Nome</label>
						<input type="text" name="produto" /><br />
						<!-- <label>Unidade</label>
						<select name="unidade">
							<option>Selecione..</option>
							<?php
								while ( $query2 = mysql_fetch_array($sql2))
								{
							?>
									<option value="<?php echo $query2['CODUNI']; ?>"><?php echo $query2['UNIDADE']; ?></option>";								
							<?php
								}
							?> -->				
						</select><br />
						<label>Grupo</label>
						<select name="grupo">
							<option>Selecione um Grupo</option>
							<?php
								while ( $query = mysql_fetch_array($sql))
								{
								?>
									<option value="<?php echo $query['CODGRUP']; ?>"><?php echo $query['GRUPO']; ?></option>";								
							<?php
								}
							?>				
						</select><br />
						<label>Predio</label>
						<input type="text" name="custo" /><br />
						<label>Lado</label>
						<input type="text" name="vencimento" onKeyUp="mascara_data(this.value)" maxlength="10"/><br />
						<input class="botao" type="submit" name="enviar" value="Cadastrar" />
					</fieldset>				
				</form>
			</div> <!-- Fim da div#principal -->
			
			<?php include('includes/fimerodape.php'); ?>
			
</body>
</html>