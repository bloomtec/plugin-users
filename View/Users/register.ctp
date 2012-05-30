<?php echo $this -> Html -> css('datepicker'); ?>
<div class="black-wrapper form registro">
	<h1>CREA UNA CUENTA</h1>
	<h2 class='rosa'>Nuevos Clientes PriceShoes</h2>
		<p>Compartiendo tus datos básicos con nosotros, no sólo te actualizaremos con lo último de <span>Price Shoes</span> sino que seras uno de los primero en enterarte de una gran variedad de ofertas y promociones, ademas al crear una cuenta en nuestra tienda, podrás moverse a través del proceso de pago más rápido, registrar tus direcciones para envíos, guardar, ver y comparar tus favoritos.</p>
		<?php echo $this -> Form->create("User",array("action"=>"register","controller"=>"users"));?>
			<?php echo $this -> Form -> input('email', array('label' => 'Dirección E-mail<br>(Este será tu usuario en <span>PriceShoes.com.co</span>)', 'type' => 'email', 'required' => 'required')); ?>
			<?php echo $this -> Form -> input('verify_email', array('label' => '<br />Escribe de nuevo tu dirección E-mail', 'type' => 'email', 'required' => 'required', 'data-equals' => 'data[User][email]')); ?>
			<?php echo $this -> Form -> input('password',array('type'=>'password','div' => 'password ',"label"=>"Contraseña",'required'=>'required'));?>
			<?php echo $this -> Form -> input('verify_password',array('type'=>'password','div' => 'password ',"label"=>"Escribe de nuevo tu contraseña",'required'=>'required','data-equals'=>"data[User][password]"));?>
			<?php echo $this -> Form -> input('name',array('div' => 'input',"label"=>"Escribe tu (s) Nombre (s)",'required'=>'required'));?>
			<?php echo $this -> Form -> input('lastname',array('div' => 'input',"label"=>"Escribe tu (s) Apellido (s)",'required'=>'required'));?>
			<div class="input">
				<?php echo $this -> Form -> radio('document_type_id', $documentTypes, array('value' => 1, 'legend' => 'Tipo De Identificación')); ?>
		    	<div style="clear:both"></div>
		    	<?php echo $this -> Form->input('document', array("label"=>false,'required'=>'required'));?>
	    	</div>
    		<div class="input sexo">
			<br />
    		<?php echo $this -> Form->input('sex', array("div"=>false,'label'=>'Sexo','required'=>'required','options' => array('F'=>'Femenino','M'=>'Masculino'))); ?>
			</div>
			<div class="input calendario">
				<br />
				<label>Fecha De Nacimiento</label>
				<input class="date" type="date" name="data[User][birthday]">					
				<div style="clear:both"></div>
			</div>
			<h2 class='rosa' style='clear:both; margin-bottom:20px;'>Direccion Principal</h2>
			<?php echo $this -> Form->input("UserAddress.country",array("label"=>"País",'required'=>'required'));?>
			<?php echo $this -> Form->input("UserAddress.state",array("label"=>"Departamento",'required'=>'required'));?>
			<?php echo $this -> Form->input("UserAddress.city",array("label"=>"Ciudad",'required'=>'required'));?>
			<?php echo $this -> Form->input("UserAddress.phone",array("label"=>"Teléfono"));?>
			<div style="clear:both"></div>
			<?php echo $this -> Form->input("UserAddress.address",array("label"=>"Dirección",'required'=>'required', 'type' => 'textarea', 'style' => 'min-width:345px;'));?>
			<div style="clear:both"></div>
			<p>Al hacer click en el botón “Crear mi cuenta” a continuación, certifico que he leído y que acepto las <span> <?php echo $this -> Html->link("Condiciones de Servicio y Políticas de Privacidad de PriceShoes.com.co",array("controller"=>"pages","action"=>"view","condiciones"),array("target"=>"_BLANK",'class'=>'rosa'));?></span>, aceptando recibir comunicaciones electrónicas procedentes de <span><?php echo $this -> Html->link("PriceShoes.com.co","/",array("target"=>"_BLANK",'class'=>'rosa'));?></span>, relacionadas con mi cuenta.</p>
			<div class="captcha">
				<div id="recaptcha_div">
				</div>
				<style>#recaptcha_response_field {max-height:45%; max-width:98%;}</style>
			</div>
		
			<?php echo $this -> Form->submit(__('Crear mi cueta', true),array('class'=>'big-button'));?>
			<?php echo $this -> Form -> input('captcha_error', array('value' => $error, 'div' => false, 'label' => false, 'style' => 'visibility:hidden;')); ?>
			<?php echo $this -> Form -> end();?>
		<!--</fieldset>-->
	<div style="clear:both;"></div>
</div>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
	$(function(){
		
		// Asignar validator al form
		$('#UserRegisterForm').validator({ lang: 'es', position:"bottom left"});
		
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
		
		$(":date").dateinput({
			lang: 'es',
			trigger: true, 
			yearRange: [-90,-10] ,
			format: 'yyyy-mm-dd',	// the format displayed for the user
			selectors: true,             	// whether month/year dropdowns are shown
			offset: [0, 0],            	// tweak the position of the calendar
			speed: 'fast',               	// calendar reveal speed
			firstDay: 1                  	// which day starts a week. 0 = sunday, 1 = monday etc..
	    });
	
	});
</script>