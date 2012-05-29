<div class="users form">
<h1>Modificar Mis datos</h1>
<?php echo $this->Form->create('User');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label'=>'Nombres'));
		echo $this->Form->input('lastname',array('label'=>'Apellidos'));
		echo $this->Form->input('document_type_id',array('label'=>'Tipo de Documento'));
		echo $this->Form->input('document',array('label'=>'Documento'));
		echo $this->Form->input('sex',array('label'=>'Sexo'));
		echo $this->Form->input('birthday',array('label'=>'Fecha de Nacimiento'));
	?>	
	</fieldset>
<?php echo $this->Form->end(__('Modificar'));?>
<br />
<br />
<h1>Modificar Contraseña</h1>
<?php echo $this -> Form -> create('User', array('action' => 'editPassword')); ?>
	<fieldset>

		<?php echo $this -> Form -> input('id'); ?>
		<?php echo $this -> Form->input("password",array('type'=>'password','div' => 'password ', 'value' => '',"label"=>"Contraseña",'required'=>'required'));?>
		<?php echo $this -> Form->input("verify_password",array('type'=>'password','div' => 'password ', 'value' => '',"label"=>"Escribe de nuevo tu contraseña",'required'=>'required','data-equals'=>"data[User][password]"));?>			
	</fieldset>
<?php echo $this -> Form -> end(__('Modificar')); ?>
<script type="text/javascript">
	$(function(){
		// Asignar validator al form
		$('#UserEditPasswordForm').validator({ lang: 'es' });	
	});
</script>

</div>