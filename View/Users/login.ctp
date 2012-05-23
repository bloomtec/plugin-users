<div class='login'>
	<?php echo $this -> Form -> create('User', array('action' => 'login'));?>
	<legend><?php echo __('Inicio De Sesión'); ?></legend>
	<?php echo $this -> Form -> input('username', array('label' => 'Nombre De Usuario', 'required' => 'required'));?>
	<?php echo $this -> Form -> input('password', array('label' => 'Contraseña', 'type' => 'password', 'required' => 'required'));?>
	<?php echo $this -> Form -> submit('Iniciar Sesión');?>
	<div style='clear:both;'></div>
	<?php echo $this -> Form -> end();?>
</div>