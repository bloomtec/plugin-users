<div class='form black-wrapper login'>
		<h1>INICIA SESIÓN O CREA UNA CUENTA</h1>
		<div class="izquierda">
			<h2 class='rosa'>Nuevos Clientes PriceShoes</h2>
			<p>
				Al crear una cuenta en nuestra tienda, usted podrá agilizar su proceso de pago, guardar múltiples direcciones para sus envíos, ver y guardar tus productos favoritos y más.
			</p>
			<div class="cuadro-formularios">
				<?php echo $this -> Html->link('Crear',array("controller"=>"users","action"=>"register"), array("class"=>"button"));?>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div class="derecha">
			<h2 class='rosa'>Clientes PriceShoes</h2>
			<?php echo $this -> Form->create("User",array("action"=>"login","controller"=>"users"));?>
			<p>Sí ya dispones de una cuenta con nosotros por favor ingresa tus datos.</p>
				<?php echo $this -> Form->input("username",array('div' => 'email-login',"label"=>"Dirección E-mail", 'value' => ''));?>
				<?php echo $this -> Form->input("password",array('div' => 'password-login',"label"=>"Contraseña", 'value'=>''));?>
				<div style="clear:both"></div>
				<div class="captcha">
					<div id="recaptcha_div">
					</div>
					<div style="clear:both;"></div>
				</div>
				 <div style="clear:both;"></div>
				<div class="cuadro-formularios">
	            <?php echo $this -> Html->link('¿Olvidó su contraseña?',array('plugin'=>'user_control', "controller"=>"users","action"=>"resetPassword"), array("class"=>"rosa"));?>  
	            <?php echo $this -> Form -> submit(__('Ingresar', true));?> 
	            <div style="clear:both;"></div>
				</div>
				<?php 
					//$login_attempts=4;
					if($login_attempts > 3) {
						echo $this -> Form -> input('captcha_error', array('value' => $error, 'div' => false, 'label' => false, 'style' => 'visibility:hidden;'));
					}
				?>
				<div style="clear:both;"></div>
				<?php echo $this -> Form -> end(); ?>				
		</div>
		<div style="clear:both;"></div>
</div>
<?php if($login_attempts > 3) : ?>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
	$(function(){	
		Recaptcha.create("<?php echo $public_key; ?>", 'recaptcha_div', {
			theme : "white",
			lang : 'es',
			callback : function() {
				if($('#UserCaptchaError').val() != '') {
					$('#recaptcha_instructions_image').remove();
					$('#recaptcha_div').removeClass('recaptcha_nothad_incorrect_sol');
					$('#recaptcha_div').addClass($('#UserCaptchaError').val());
				}
			}
		});
	});
</script>
<?php endif;?>