<div class="userMailConfigs form">
	<?php echo $this -> Form -> create('UserMailConfig'); ?>
	<fieldset>
		<legend>
			<?php echo __('Modificar Configuración'); ?>
		</legend>
		<?php
		echo $this -> Form -> input('id');
		echo $this -> Form -> input('mailchimp_api_key', array('label' => __('Llave API MailChimp', true)));
		echo $this -> Form -> input('is_mailchimp_active', array('label' => __('MailChimp Activo', true)));
		?>
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
</div>
