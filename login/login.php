<?php include('extra/cache.php'); include('config.php'); include('topo.html'); include('trancar2.php'); ?>
	<script type="text/javascript" src="js/login.js"></script>
	<div id="titulo" class="box">&Aacute;rea Restrita | TI</div>
	<div id="texto" class="box">
		<div id="txt">Bem Vindo! Preencha os campos abaixo para efetuar login. <?php include("menu.php"); ?></div>
		<div id="txtload"></div>
		<div id="txt0" class="txt"><?php echo $msg[0]; ?></div>
		<div id="txt1" class="txt"><?php echo $msg[1][0]; ?></div>
		<div id="txt2" class="txt"><?php echo $msg[2][0]; ?> <span id="tempo"></span></div>
		<div id="txt3" class="txt"><?php echo $msg[3]; ?></div>
		<div id="txt4" class="txt"><?php echo $msg[4]; ?></div>
	</div>
	<div id="form" class="box">
		<label for="usuario">Usu&aacute;rio:</label><input type="text" name="usuario" id="usuario" /><br/>
		<label for="senha">Senha:</label><input type="password" name="senha" id="senha" /><br/>
			<div id="captcha"><?php if(L_USAR_CAPTCHA=="1"){include_once('extra/recaptcha.php');echo recaptcha_get_html(PUBLIC_KEY);} ?></div>
			<input type="hidden" value="<?php echo P_INDEX; ?>" id="p_index" />
			<input type="button" value="Entrar" id="submit" /><br/>
	</div>
<?php include('rodape.html'); ?>
