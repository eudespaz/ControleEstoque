<?php include('extra/cache.php'); include('config.php'); include('topo.html'); include('trancar.php'); ?>
	<script type="text/javascript" src="js/cadastro.js"></script>
	<script type="text/javascript" src="js/iframe.js"></script>
	<div id="titulo" class="box">Cadastro</div>
	<div id="texto" class="box">
		<div id="txt">Bem Vindo! Preencha os campos abaixo para se cadastrar.</div>
		<div id="txtload"></div>
		<div id="txt0" class="txt"><?php echo $msg[0]; ?></div>
		<div id="txt1" class="txt"><?php echo $msg[1][1]; ?></div>
		<div id="txt2" class="txt"><?php echo $msg[2][1]; ?> <span id="tempo"></span></div>
		<div id="txt3" class="txt"><?php echo $msg[3]; ?></div>
		<div id="txt4" class="txt"><?php echo $msg[4]; ?></div>
	</div>
	<div id="form" class="box">
		<label for="nome">Nome:</label><input type="text" name="nome" id="nome" /> *(4-32) A-Z<br/>
		<label for="usuario">Usuario:</label><input type="text" name="usuario" id="usuario" /> *(<?php echo MIN_USUARIO.'-'.MAX_USUARIO?>) A-Z 0-9<br/>
		<label for="senha">Senha:</label><input type="password" name="senha" id="senha" /> *(<?php echo MIN_SENHA.'-'.MAX_SENHA?>) A-Z 0-9<br/>
		<div id="captcha"><?php if(C_USAR_CAPTCHA=="1"){include_once('extra/recaptcha.php');echo recaptcha_get_html(PUBLIC_KEY);} ?></div>
		<input type="button" value="Cadastrar" id="submit" /><br/>
	</div>
<?php include('rodape.html'); ?>
