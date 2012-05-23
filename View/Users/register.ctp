<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php echo __('Registro De Usuario'); ?></legend>
	<?php
		echo $this->Form->input('username', array('label' => 'Nombre De Usuario', 'required' => 'required'));
		echo $this->Form->input('email', array('label' => 'Correo Electrónico', 'type' => 'email', 'required' => 'required'));
		echo $this->Form->input('verify_email', array('label' => 'Correo Electrónico', 'type' => 'email', 'required' => 'required', 'data-equals' => 'data[User][email]'));
		echo $this->Form->input('name', array('label' => 'Nombre', 'required' => 'required'));
		echo $this->Form->input('lastname', array('label' => 'Apellido', 'required' => 'required'));
		echo $this->Form->input('password', array('label' => 'Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required'));
		echo $this->Form->input('verify_password', array('label' => 'Confirmar Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required', 'data-equals' => 'data[User][password]'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Registrar'));?>
</div>