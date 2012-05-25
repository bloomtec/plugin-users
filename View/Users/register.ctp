<div class="users form">
	<?php echo $this -> Form -> create('User'); ?>
		<fieldset>
			<legend>
				<?php echo __('Registro De Usuario'); ?>
			</legend>
			<div class="campos">
				<?php
				//echo $this -> Form -> input('username', array('label' => 'Nombre De Usuario', 'required' => 'required'));
				echo $this -> Form -> input('email', array('label' => 'Correo Electrónico', 'type' => 'email', 'required' => 'required'));
				echo $this -> Form -> input('verify_email', array('label' => 'Correo Electrónico', 'type' => 'email', 'required' => 'required', 'data-equals' => 'data[User][email]'));
				echo $this -> Form -> input('name', array('label' => 'Nombre', 'required' => 'required'));
				echo $this -> Form -> input('lastname', array('label' => 'Apellido', 'required' => 'required'));
				echo $this -> Form -> input('password', array('label' => 'Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required'));
				echo $this -> Form -> input('verify_password', array('label' => 'Confirmar Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required', 'data-equals' => 'data[User][password]'));
				?>
			</div>
			<div class="captcha">	
				<!-- ReCaptcha con JS Personalizado -->
				<div id="recaptcha_div"></div>
				<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
				<!-- Wrapping the Recaptcha create method in a javascript function -->
				<?php echo $this -> Html -> script('jquery.min'); ?>
				<?php echo $this -> Html -> script('jquery.tools.min'); ?>
				<?php echo $this -> Html -> script('common'); ?>
				<script type="text/javascript">
					$(function(){
						// Asignar validator al form
						$('#UserRegisterForm').validator({
							lang: 'es'
						});
						
						Recaptcha.create("<?php echo $public_key; ?>", 'recaptcha_div', {
							theme : "clean",
							callback : Recaptcha.focus_response_field
						});
						
						/* Manejar el submit */
						$('#SubmitButton').click(function() {
							$('#UserCaptchaChallenge').val(Recaptcha.get_challenge());
							$('#UserCaptchaResponse').val(Recaptcha.get_response());
							$('#UserRegisterForm').submit();
						});
					});
				</script>
			</div>
		</fieldset>
		<div class="submit">
			<input id="SubmitButton" type="button" value="<?php echo __('Registrar'); ?>">
		</div>
		<?php
			echo $this -> Form -> input('captcha_challenge', array('label' => false, 'style' => 'visibility:hidden;'));
			echo $this -> Form -> input('captcha_response', array('label' => false, 'style' => 'visibility:hidden;'));
		?>
	</form>
</div>