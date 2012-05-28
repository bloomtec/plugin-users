<div class="users form">
	<?php echo $this -> Form -> create('User'); ?>
	<fieldset>
		<legend>
			<?php echo __('Modificar Contraseña'); ?>
		</legend>
		<?php echo $this -> Form -> input('id'); ?>
		<?php echo $this -> Form->input("password",array('type'=>'password','div' => 'password ', 'value' => '',"label"=>"Contraseña",'required'=>'required'));?>
		<?php echo $this -> Form->input("verify_password",array('type'=>'password','div' => 'password ', 'value' => '',"label"=>"Escribe de nuevo tu contraseña",'required'=>'required','data-equals'=>"data[User][password]"));?>			
	</fieldset>
	<?php echo $this -> Form -> end(__('Guardar')); ?>
</div>
<?php echo $this -> Html -> script('common'); ?>
<script type="text/javascript">
	$(function(){
		// Asignar validator al form
		$('#UserEditPasswordForm').validator({ lang: 'es' });	
	});
</script>