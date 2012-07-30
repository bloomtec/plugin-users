<div class='form black-wrapper'>
	<?php echo $this -> Form -> create('User'); ?>
	<?php echo $this -> Form -> input('requestedEmail', array('label' => 'Correo Registrado', 'value' => '')); ?>
	<div id="ResetPasswordSubmitDiv" class="submit">
		<br />
		<br />
		<input id="ResetPasswordSubmit" type="submit" value="Solicitar Nueva Contraseña">
	</div>
</div>
<style>
	div#ResetPasswordSubmitDiv {
		
	}
	input#ResetPasswordSubmit {
		min-width: 200px;
	}
</style>