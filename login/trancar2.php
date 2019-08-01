<?php
// Trancar pagina apenas para usuarios logados
if(isset($_COOKIE[md5('logincookie75')])){
	if($_COOKIE[md5('logincookie75')]==md5('5ATIVADO6')){
		exit("
			<script type='text/javascript'>
				window.location='".P_INDEX."';
			</script>
			");
	}
}
?>