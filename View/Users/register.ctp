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
				echo $this -> Form -> input('verify_email', array('label' => 'Confirmar Correo Electrónico', 'type' => 'email', 'required' => 'required', 'data-equals' => 'data[User][email]'));
				echo $this -> Form -> input('name', array('label' => 'Nombre', 'required' => 'required'));
				echo $this -> Form -> input('lastname', array('label' => 'Apellido', 'required' => 'required'));
				echo $this -> Form -> input('password', array('label' => 'Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required'));
				echo $this -> Form -> input('verify_password', array('label' => 'Confirmar Contraseña', 'type' => 'password', 'value' => '', 'required' => 'required', 'data-equals' => 'data[User][password]'));
				?>
			</div>
			<div class="captcha">
				<div id="recaptcha_div">
				</div>
			</div>
		</fieldset>
		<div class="submit">
			<input id="SubmitButton" type="button" value="<?php echo __('Registrar'); ?>">
		</div>
		<?php echo $this -> Form -> input('captcha_error', array('value' => $error, 'div' => false, 'label' => false, 'style' => 'visibility:hidden;')); ?>
	</form>
</div>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<?php echo $this -> Html -> script('jquery.min'); ?>
<?php echo $this -> Html -> script('jquery.tools.min'); ?>
<?php echo $this -> Html -> script('common'); ?>
<script type="text/javascript">
	$(function(){
		// Asignar validator al form
		$('#UserRegisterForm').validator({ lang: 'es' });
		
		Recaptcha.create("<?php echo $public_key; ?>", 'recaptcha_div', {
			theme : "white",
			lang : 'es',
			callback : function() {
				if($('#UserCaptchaError').val() != '') {
					$('#recaptcha_div').removeClass('recaptcha_nothad_incorrect_sol');
					$('#recaptcha_instructions_image').remove();
					$('#recaptcha_div').addClass($('#UserCaptchaError').val());
				}
			}
		});
		
		/* Manejar el submit */
		$('#SubmitButton').click(function() {
			$('#UserRegisterForm').submit();
		});
	});
</script>