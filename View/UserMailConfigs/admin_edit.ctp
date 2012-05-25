<div class="userMailConfigs form">
	<?php echo $this -> Form -> create('UserMailConfig'); ?>
	<fieldset>
		<?php echo $this -> Form -> input('id'); ?>
		<table id="MailServices" class="mail-services">
			<tbody>
				<caption>Configurar Servicio De Correo</caption>
				<tr>
					<td class="service">
						<?php echo $this -> Form -> input('mail_service_id', array('label' => __('Servicio', true))); ?>
					</td>
					<td class="key">
						<?php echo $this -> Form -> input('api_key', array('label' => __('Llave API', true))); ?>
					</td>
					<td class="active">
						<?php echo $this -> Form -> input('is_active', array('label' => __('Activo', true))); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table id="MailingLists" class="mailing-lists">
			<tbody>
				<caption>Configurar Listas De Correo</caption>
				<?php foreach ($this -> data['MailingList'] as $key => $mailing_list) : ?>
				<tr>
					<?php echo $this -> Form -> input("MailingList.$key.id", array('value' => $mailing_list['id'])); ?>
					<td class="list-name">
						<?php echo $this -> Form -> input("MailingList.$key.list_name", array('label' => __('Nombre De La Lista', true))); ?>
					</td>
					<td class="list-id">
						<?php echo $this -> Form -> input("MailingList.$key.list_id", array('label' => __('ID De La Lista', true), 'type' => 'text')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>		
	</fieldset>
	<?php echo $this -> Form -> end(__('Modificar')); ?>
</div>
<style>
	form#UserMailConfigAdminEditForm {margin-left:auto; margin-right:auto; max-width:640px; padding:20px;}
	table#MailServices td, table#MailingLists td {padding:5px;}
	table#MailServices td.service {}
	table#MailServices td.key {}
	table#MailServices td.key input {text-align:center; width:300px;}
	table#MailServices td.active {}
</style>