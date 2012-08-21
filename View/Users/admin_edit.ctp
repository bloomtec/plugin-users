<div class="users form">
	<?php echo $this -> Form -> create('User'); ?>
	<fieldset>
		<legend>
			<?php echo __('Modificar Usuario'); ?>
		</legend>
		<?php
		echo $this -> Form -> input('id');
		echo $this -> Form -> input('role_id', array('label' => __('Rol', true)));
		//echo $this -> Form -> input('username', array('label' => __('Usuario', true)));
		echo $this -> Form -> input('email', array('label' => __('Correo', true)));
		echo $this -> Form -> input('name', array('label' => __('Nombre', true)));
		echo $this -> Form -> input('lastname', array('label' => __('Apellido', true)));
		//echo $this -> Form -> input('password', array('label' => __('Contraseña', true), 'value' => ''));
		//echo $this -> Form -> input('verify_password', array('label' => __('Verificar Contraseña', true), 'type' => 'password', 'value' => ''));
		echo $this -> Form -> input('is_active', array('label' => __('Activo', true)));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
</div>

