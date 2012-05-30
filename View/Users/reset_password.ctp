<div class='form black-wrapper'>
	<?php echo $this -> Form -> create('User'); ?>
	<?php echo $this -> Form -> input('email', array('label' => 'Correo Registrado', 'value' => '')); ?>
	<?php echo $this -> Form -> submit('Solicitar Nueva Contraseña'); ?>
</div>