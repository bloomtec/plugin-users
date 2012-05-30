<div class="userAddresses form">
	<?php echo $this -> Form -> create('UserAddress'); ?>
	<fieldset>
		<legend>
			<?php echo __('Modificar Dirección'); ?>
		</legend>
		<?php
		echo $this -> Form -> input('id');
		echo $this -> Form -> input('name', array('label' => 'Nombre'));
		echo $this -> Form -> input('country', array('label' => 'País'));
		echo $this -> Form -> input('state', array('label'=>'Departamento'));
		echo $this -> Form -> input('city', array('label'=>'Ciudad'));
		echo $this -> Form -> input('phone', array('label'=>'Teléfono'));
		echo $this -> Form -> input('address', array('label'=>'Dirección'));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
</div>