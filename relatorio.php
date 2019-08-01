<?php include('login/trancar.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		$titulo = "Controle &raquo; Relat&oacute;rios";
		require_once ("includes/header.php");
	?>
	<script type="text/javascript" src="includes/js/data.js"></script>
	<script type="text/javascript">
		function marcar(){
    var boxes = document.getElementsByName("grupo[]");
    for(var i = 0; i < boxes.length; i++)
      boxes[i].checked = true;
  }
  
  function desmarcar(){
    var boxes = document.getElementsByName("grupo[]");
    for(var i = 0; i < boxes.length; i++)
      boxes[i].checked = false;
  }	
	</script>
</head>
<body>
			<?php
				include('includes/topoemenu.php');
				require_once('includes/db.php');
			 ?>

			<div id="principal">
				<div id="auxiliar">
					<a href="relatorio.php?id=entradas" >Ver as Entradas de Hoje</a><hr />
					<a href="relatorio.php?id=filtraent" >Entradas Acumuladas</a><hr />
					<a href="relatorio.php?id=saidas" >Ver as Saidas de Hoje</a><hr />
					<a href="relatorio.php?id=filtrasai" >Sa&iacute;das Acumuladas</a><hr />
				</div>
				<?php 
					$rel = $_GET['id'];
					$data = date("Y-m-d");
					if($rel == 'entradas')
					{
						$sql = mysql_query ("SELECT entra.DATA, produtos.CODPROD, produtos.PRODUTO as produto, produtos.UNIDADE, Sum(itensent.QUANT) AS QTDE FROM (entra INNER JOIN itensent ON entra.CONTROLE = itensent.CONTROLE) INNER JOIN produtos ON itensent.PRODUTO = produtos.CODPROD WHERE entra.DATA='$data' GROUP BY entra.DATA, produtos.CODPROD, produtos.PRODUTO, produtos.UNIDADE ") or die(mysql_error());
						$rows = mysql_num_rows($sql);
						$data = date("d-m-Y");						
						echo "<h3>Exibindo as entradas de Estoque de ".$data.", Total: ".$rows."</h3><br /><br />";
						include('includes/relatorio.php');
					}
					
					if($rel == 'saidas')
					{
						$sql = mysql_query ("SELECT saidas.DATA, produtos.CODPROD, produtos.PRODUTO as produto, produtos.UNIDADE, Sum(sitens.QUANT) AS QTDE FROM (saidas INNER JOIN sitens ON saidas.CONTRSAI = sitens.CONTRSAI) INNER JOIN produtos ON sitens.PRODUTO = produtos.CODPROD WHERE saidas.DATA='$data' AND entregar = 1 GROUP BY saidas.DATA, produtos.CODPROD, produtos.PRODUTO, produtos.UNIDADE ") or die(mysql_error());
						$rows = mysql_num_rows($sql);	
						$data = date("d-m-Y");					
						echo "<h3>Exibindo as sa&iacute;das de Estoque de ".$data.", Total: ".$rows."</h3><br /><br />";
						include('includes/relatorio.php');					
					}	
					
					if($rel == 'filtrasai')
					{
						$sql= mysql_query("SELECT * FROM grupos order by GRUPO");
						$sql2= mysql_query("SELECT * FROM destinos order by DESCRICAO");
						$sql3= mysql_query("SELECT * FROM produtos order by PRODUTO");
						$id = "saidas";
						include('includes/filtro.php');
					}
					if($rel == 'filtraent')	
					{
						$sql= mysql_query("SELECT * FROM fornec order by NOME");
						$id = "entradas";
						include('includes/filtro.php');					
					}
				?>
				
			</div> <!-- Fim da div#principal -->

			<?php include('includes/fimerodape.php'); ?>

</body>
</html>