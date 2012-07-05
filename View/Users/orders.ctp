<div class="users">
	<h2 class="rosa">
		Mis ordenes
	</h2>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae turpis eu nisi pharetra commodo. Vivamus volutpat ipsum in elit vehicula adipiscing. Pellentesque ullamcorper consectetur neque vel congue. Vestibulum nibh magna, laoreet nec tincidunt quis, rhoncus quis enim. Donec purus dolor, semper ut pulvinar ut, faucibus ut elit. Donec bibendum dignissim tristique. Vivamus convallis dui vel velit vulputate hendrerit.
	</p>
	<?php //debug($orders);?>
	<table class="orders tablas">
		
		<tr>
			<th> Fecha </th>			
			<th> Estado </th>
			<th> Comentarios </th>
			<th> Direción de entrega </th>
			<th> Opciones </th>
		</tr>
		<?php foreach( $orders as $order) :?>
		<tr class="order-info">
			<td><?php echo $order['Order']['created']?></td>
			<td><?php echo $order['OrderState']['name']?></td>
			<td><?php echo $order['Order']['comments']?></td>
			<td><?php echo  $order['UserAddress']['address'];?></td>
			<td><?php echo $this -> Html -> link('Mostrar detalles ',array('controller'=>'orders',"action"=>"view","plugin"=>false),array('class'=>'rosa','rel'=>$order['Order']['id'])); ?></td>
		</tr>
		<tr class="order-details"  rel="<?php echo $order['Order']['id']?>">
			<td colspan="5">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="tablaCarrito">
				<?php
					$subTotal=0;
				?>
				<tr class="entryTableHeader">
					<th colspan="2" align="center">Producto</th>
					<th align="center">Precio</td>
					<th width="75" align="center">Cantidad</th>
					<th align="center">Total</td>

				</tr>
				<?php
					foreach($order['OrderItem'] as $item) {
						$subTotal += $item['Product']['price'] * $item['quantity'];
				?>
				<tr class="content">
					<td width="80" align="center" class="left">
						<?php
						  echo 	$this -> Html->link(
										$this -> Html->image(
													'/img/uploads/100x100/' . $item['image'],
													array('border' => '0')
												),
												array('action' => '../products/view/'.$item['Product']['id']."/".$item['color_id']),
												array('escape' => false)
										); 
						?>
					</td>
					<td>
						<h3><?php echo $this -> Html->link( $item['Product']['name'], "/products/view/".$item['Product']['id']."/".$item['color_id']);?></h3>
						<span>Ref. <?php echo $item['Product']['reference'] ?></span>
						<span>Talla <?php echo $item['ProductSize']['name']; ?></span>
					</td>
					<td align="center" class="price">
						<?php echo "$".number_format( $item['Product']['price'], 0, ' ', '.'); ?>
					</td>
					<td width="115" align="center" class="quantity">						
						<?php echo $item['quantity']; ?>					
					</td>
					<td align="center" class="right total">
						<?php echo "$ ".number_format($item['Product']['price'] * $item['quantity'], 0, ' ', '.');?>
					</td>				
				</tr>
				<?php
						}
				?>
				<tr class="total">
					<th colspan="3"style="background:none;">
						
					</th>
					<th colspan="1"style="text-align:right;">
						Total
					</th>
					<th style="text-align:center;">
					
						<?php if (isset($subTotal)) echo "$ ".number_format($subTotal, 0, ' ', '.');?>
					</th>

				</tr>
			</table>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>
<script type="text/javascript">
	$(function(){
		$('a[rel]').click(function(e){
			e.preventDefault();
			$that=$(this);
			if($that.is('.open')){
				$that.removeClass('open');
				$('tr[rel="'+$that.attr('rel')+'"]').hide('slow',function(){
					$that.text('Mostar detalles ');
				});
			}else{
				$that.addClass('open');
				$('tr[rel="'+$that.attr('rel')+'"]').show('slow',function(){
					$that.text('Ocultar detalles');
				});				
			}
		});
	});
</script>
