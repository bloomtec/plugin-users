<?php echo $this -> Html -> css('datepicker'); ?>
<div class="users form">
	<h1>Modificar Mis Datos</h1>
	<?php echo $this -> Form -> create('User'); ?>
	<fieldset>
		<?php
		echo $this -> Form -> input('id');
		echo $this -> Form -> input('name', array('label' => 'Nombres'));
		echo $this -> Form -> input('lastname', array('label' => 'Apellidos'));
		echo $this -> Form -> input('document_type_id', array('label' => 'Tipo De Documento'));
		echo $this -> Form -> input('document', array('label' => 'Documento'));
		echo $this -> Form -> input('sex', array("div" => false, 'label' => 'Sexo', 'required' => 'required', 'options' => array('F' => 'Femenino', 'M' => 'Masculino')));
		//echo $this -> Form -> input('birthday', array('label' => 'Fecha de Nacimiento'));
		?>
		<div class="input calendario">
			<br />
			<label>Fecha De Nacimiento</label>
			<input class="date" type="date" name="data[User][birthday]">
			<div style="clear:both"></div>
		</div>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
	<br />
	<br />
	<h1>Modificar Contraseña</h1>
	<?php echo $this -> Form -> create('User', array('action' => 'editPassword')); ?>
	<fieldset>
		<?php echo $this -> Form -> input('id'); ?>
		<?php echo $this -> Form -> input("password", array('type' => 'password', 'div' => 'password ', 'value' => '', "label" => "Contraseña", 'required' => 'required')); ?>
		<?php echo $this -> Form -> input("verify_password", array('type' => 'password', 'div' => 'password ', 'value' => '', "label" => "Escribe de nuevo tu contraseña", 'required' => 'required', 'data-equals' => "data[User][password]")); ?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
	<script type="text/javascript">
		$(function() {
			
			// Asignar validator al form
			$('#UserEditPasswordForm').validator({
				lang : 'es'
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
</div>