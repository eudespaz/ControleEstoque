<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Cadastrar Fornecedor";
		require_once ("includes/header.php"); 
	?>
	<script type="text/JavaScript">
      function mascara_cep(cep)
      {
              var mydata = '';
              mydata = mydata + cep;
              if (mydata.length == 5)
              {
                  mydata = mydata + '-';
                  document.forms[0].cep.value = mydata;
              } 
      }
    </script>
</head>
<body>
			<?php 
				include('includes/topoemenu.php');
				require_once('includes/db.php');
				if ($_POST)
				{
					$nome = $_POST['produto'];
					$contato = $_POST['contato'];
					$cgc = $_POST['cnpj'];
					$ie = $_POST['ie'];
					$rua = $_POST['rua'];
					$bairro = $_POST['bairro'];
					$cidade = $_POST['cidade'];
					$estado = $_POST['uf'];
					$fonenovo = $_POST['fonenovo'];
					$fone2 = $_POST['fone2'];
					$fone3 = $_POST['fone3'];
					$fax = $_POST['fax'];
					$cep = $_POST['cep'];
					if ($nome == '' || $contato == '' || $cgc == '' || $ie == '' || $rua == '' || $bairro == '' || $cep == '' || $cidade == '' || $estado == '' || $fonenovo == '')
					{
						echo "<script>alert('Preencha todos os campos')</script>";					
					}
					else
						$cad = mysql_query ("INSERT INTO fornec(CODIGO,NOME,CONTATO,CGC,IE,RUA,BAIRRO,CIDADE,UF,CEP,FONENOVO,FONE_2,FONE_3,FAX) 
						values(NULL,'$nome','$contato','$cgc','$ie','$rua','$bairro','$cidade','$estado','$cep','$fonenovo','$fone2','$fone3','$fax') ") 
						or die (mysql_error());
						if ($cad != '')
							echo "<script>alert('Cadastro foi efetuado com sucesso');</script>";
				}
			 ?>
			 	
			<div id="principal">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<fieldset>
						<legend class="titulo">Cadastro de Fornecedor &darr; </legend>
						<label>Nome</label>
						<input type="text" name="produto" maxlength="45"  onfocus="this.style.backgroundColor='#fff';" onblur="this.style.backgroundColor='#EEE';"/><br />
						<label>Contato</label>
						<input type="text" name="contato" maxlength="30"/><br />
						<label>CNPJ</label>
						<input type="text" name="cnpj" maxlength="14" /><br />
						<label>IE</label>
						<input type="text" name="ie" maxlength="15" /><br />
						<label>Rua</label>
						<input type="text" name="rua" maxlength="45" /><br />
						<label>Bairro</label>
						<input type="text" name="bairro" maxlength="20" /><br />
						<label>Cidade</label>
						<input type="text" name="cidade" maxlength="25" /><br />
						<label>Estado</label>
						<select name="uf">
							<option>SP</option>	
							<option>PR</option>					
						</select><br />
						<label>CEP</label>
						<input class="camp" type="text" name="cep" size="9" maxlength="9" /><br />
						<label>Fone</label>
						<input type="text" name="fonenovo" maxlength="11" /> <br />
						<label>Fone 2</label>
						<input type="text" name="fone2" maxlength="10" /> * (Opcional) <br />
						<label>Fone 3</label>
						<input type="text" name="fone3" maxlength="10" /> * (Opcional) <br />
						<label>Fax</label>
						<input type="text" name="fax" maxlength="10" /> * (Opcional) <br />
						<input class="botao" type="submit" name="enviar" value="Cadastrar" /> Todos os campos sem * s&atilde;o obrigat&oacute;rios
					</fieldset>				
				</form>
			</div> <!-- Fim da div#principal -->
			<?php include('includes/fimerodape.php'); ?>
</body>
</html>