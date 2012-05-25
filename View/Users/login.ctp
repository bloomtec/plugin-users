<div class='login'>
	<?php echo $this -> Form -> create('User', array('action' => 'login'));?>
	<fieldset>
		<div class="campos">
			<legend><?php echo __('Inicio De Sesión'); ?></legend>
			<?php echo $this -> Form -> input('username', array('label' => 'Nombre De Usuario', 'required' => 'required'));?>
			<?php echo $this -> Form -> input('password', array('label' => 'Contraseña', 'type' => 'password', 'required' => 'required'));?>
			</div>
		<div class="captcha">
			<div id="recaptcha_div">
			</div>
		</div>
	</fieldset>
	<div style='clear:both;'></div>
	<div class="submit">
			<input id="SubmitButton" type="button" value="<?php echo __('Iniciar Sesión'); ?>">
		</div>
		<?php echo $this -> Form -> input('captcha_error', array('value' => $error, 'div' => false, 'label' => false, 'style' => 'visibility:hidden;')); ?>
	</form>
</div>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<?php echo $this -> Html -> script('jquery.min'); ?>
<script type="text/javascript">
	$(function(){
		
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
			$('#UserLoginForm').submit();
		});
	});
</script>