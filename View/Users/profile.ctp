<?php echo $this -> element('left-col-big');?>
<div id="rigth-col">
	<ul class="css-tabs">
	  <li><a href="/user_control/users/data">Mis datos</a></li>
	  <li><a href="/user_control/users/edit_addresses">Mis Direcciones</a></li>
	  <li><a href="/user_control/users/orders">Mis Pedidos</a></li>
	</ul>
	 
	<!-- single pane -->
	<div class="css-panes">
	  <div style="display:block"></div>
	</div>
</div>
<div style="clear:both;"></div>
<script>
$(function(){
	$("ul.css-tabs").tabs(
      "div.css-panes > div",
      {effect: 'ajax', history: true}
    );
});
</script>