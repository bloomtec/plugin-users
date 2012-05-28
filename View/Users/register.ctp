<style>
h1{
	font-size:21px;
	font-weight:normal;
	margin-bottom: 15px;
}
.form{
	padding:40px;
}
</style>
<div class="black-wrapper form registro">
	<h1>CREA UNA CUENTA</h1>
	<h2 class='rosa'>Nuevos Clientes PriceShoes</h2>
		<p>Compartiendo tus datos básicos con nosotros, no sólo te actualizaremos con lo último de <span>Price Shoes</span> sino que seras uno de los primero en enterarte de una gran variedad de ofertas y promociones, ademas al crear una cuenta en nuestra tienda, podrás moverse a través del proceso de pago más rápido, registrar tus direcciones para envíos, guardar, ver y comparar tus favoritos.</p>
		<?php echo $this -> Form->create("User",array("action"=>"register","controller"=>"users"));?>
			<div class="email">
				<label for="UserFieldEmail">Dirección E-mail<br>(Este será tu usuario en <span>PriceShoes.com.co</span>)</label>
				<input id="Correos eléctronicos" type="email" required="required" minlength="9" name="data[User][email]" id="Correos eléctronicos">
			</div>
			
			<div class="email">
				<label for="UserFieldEmail-repetir"><br>Escriba de nuevo tu dirección E-mail</label>
				<input id="UserFieldEmail-repetir" type="email" required="required" minlength="9" name="data[User][verify_email]" data-equals="data[User][email]">
			</div>
			<?php echo $this -> Form->input("password",array('type'=>'password','div' => 'password ',"label"=>"Contraseña",'required'=>'required'));?>
			<?php echo $this -> Form->input("verify_password",array('type'=>'password','div' => 'password ',"label"=>"Escribe de nuevo tu contraseña",'required'=>'required','data-equals'=>"data[User][password]"));?>
			<?php echo $this -> Form->input("name",array('div' => 'input',"label"=>"Escribe tu (s) Nombre (s)",'required'=>'required'));?>
			<?php echo $this -> Form->input("lastname",array('div' => 'input',"label"=>"Escribe tu (s) Apellido (s)",'required'=>'required'));?>
			<div class="input">
				<?php
			    	$options=array('cedula'=>'Cédula','extranjera'=>'C/Extranjería','pasaporte'=>'Pasaporte');
			    	$attributes=array('legend'=>'Identificación','default' => 'cedula');
			    	echo $this->Form->radio('tipo_identificacion',$options);
				?>
		    	<div style="clear:both"></div>
		    	<?php echo $this -> Form->input("document",array("label"=>false,'required'=>'required'));?>
	    	</div>
				<div class="sexo">
				<br />
	    		<?php echo $this -> Form->input('sex', array("div"=>false,'label'=>'Sexo','required'=>'required','options' => array('F'=>'Femenino','M'=>'Masculino'))); ?>
				</div>
				<div class="calendario">
					<br />
					<label>Fecha Nacimiento</label>
					<input class="date" type="date" min="1950-01-01" required="required" name="data[User][birthday]">
					<div style="clear:both"></div>
				</div>
			<h2 class='rosa' style='clear:both;'>Direccion Principal</h2>
			<?php echo $this -> Form->input("Address.country",array("label"=>"País de Residencia",'required'=>'required'));?>
			<?php echo $this -> Form->input("Address.department",array("label"=>"Departamento",'required'=>'required'));?>
			<?php echo $this -> Form->input("Address.city",array("label"=>"Ciudad de Residencia",'required'=>'required'));?>
			<?php echo $this -> Form->input("Address.address",array("label"=>"Dirección",'required'=>'required'));?>
			<?php echo $this -> Form->input("Address.phone",array("label"=>"Teléfono"));?>			
			<div style="clear:both"></div>
			<p>Al hacer click en el botón “Crear mi cuenta” a continuación, certifico que he leído y que acepto las <span> <?php echo $this -> Html->link("Condiciones de Servicio y Políticas de Privacidad de PriceShoes.com.co",array("controller"=>"pages","action"=>"view","condiciones"),array("target"=>"_BLANK"));?></span>, aceptando recibir comunicaciones electrónicas procedentes de <span><?php echo $this -> Html->link("PriceShoes.com.co","/",array("target"=>"_BLANK"));?></span>, relacionadas con mi cuenta.</p>
			<div class="captcha">
				<div id="recaptcha_div">
				</div>
				<style>#recaptcha_response_field {max-height: 20px;}</style>
			</div>
			<br />
			<?php echo $this -> Form->submit(__('Registrarme', true));?> 
			<?php echo $this -> Form -> input('captcha_error', array('value' => $error, 'div' => false, 'label' => false, 'style' => 'visibility:hidden;')); ?>
			<?php echo $this -> Form -> end();?>
	<div style="clear:both;"></div>
</div>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<?php echo $this -> Html -> script('common'); ?>
<script type="text/javascript">
	$(function(){
		// Asignar validator al form
		$('#UserRegisterForm').validator({ lang: 'es' });
		
		Recaptcha.create("<?php echo $public_key; ?>", 'recaptcha_div', {
			theme :"white",
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