<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo $heading_title; ?></h1>
	<div class="card mb-3">
	  <div class="card-header">
	    <?php echo lang('Text.text_order_details', array(), $lang->getFrontEndLocale()); ?>
	  </div>
	  <div class="card-body">
	    <div class="row">
	    	<div class="col-sm-6">
	    		<div><strong><?php echo lang('Text.text_store', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $store_name; ?></div>
	    		<?php if (!empty($invoice_no)) { ?>
	    		<div><strong><?php echo lang('Text.text_invoice_no', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $invoice_no; ?></div>
	    		<?php } ?>
	    		<div><strong><?php echo lang('Text.text_order_id', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $order_id; ?></div>
	    		<div><strong><?php echo lang('Text.text_date_added', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $date_added; ?></div>
	    	</div>
	    	<div class="col-sm-6">
	    		<div><strong><?php echo lang('Text.text_payment_method', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $payment_method; ?></div>
	    		<div><strong><?php echo lang('Text.text_shipping_method', array(), $lang->getFrontEndLocale()); ?></strong>: <?php echo $shipping_method; ?></div>
	    	</div>
	    </div>
	  </div>
	</div>
  <div class="row mb-3">
  	<div class="col-sm-6">
			<div class="card">
			  <div class="card-header">
			    <?php echo lang('Text.text_payment_address', array(), $lang->getFrontEndLocale()); ?>
			  </div>
			  <div class="card-body">
			  	<?php echo $payment_address; ?>
			  </div>
			</div>	  		
  	</div>
  	<div class="col-sm-6">
			<div class="card">
			  <div class="card-header">
			    <?php echo lang('Text.text_shipping_address', array(), $lang->getFrontEndLocale()); ?>
			  </div>
			  <div class="card-body">
			  	<?php echo $shipping_address; ?>
			  </div>
			</div>	  		
  	</div>
  </div>
	<?php if ($products) { ?>
	<div class="card card-body table-responsive mb-3">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th scope="col"><?php echo lang('Column.column_product_name', array(), $lang->getFrontEndLocale()); ?></th>
		      <th scope="col"><?php echo lang('Column.column_model', array(), $lang->getFrontEndLocale()); ?></th>
		      <th scope="col"><?php echo lang('Column.column_quantity', array(), $lang->getFrontEndLocale()); ?></th>
		      <th scope="col"><?php echo lang('Column.column_price', array(), $lang->getFrontEndLocale()); ?></th>
		      <th scope="col" class="text-end"><?php echo lang('Column.column_total', array(), $lang->getFrontEndLocale()); ?></th>
		      <th scope="col"></th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach ($products as $product) { ?>
		    <tr>
		      <td><?php echo $product['name']; ?></th>
		      <td><?php echo $product['model']; ?></td>
		      <td><?php echo $product['quantity']; ?></td>
		      <td><?php echo $product['price']; ?></td>
		      <td class="text-end"><?php echo $product['total']; ?></td>
		      <td></td>
		    </tr>
		  	<?php } ?>
		  	<?php foreach ($totals as $total) { ?>
		    <tr>
		      <td colspan="3"></th>
		      <td class="text-end"><strong><?php echo $total['title']; ?></strong></td>
		      <td class="text-end"><?php echo $total['text']; ?></td>
		      <td></td>
		    </tr>
		  	<?php } ?>
		  </tbody>
		</table>
	</div>
  <?php } ?>
  <?php if ($histories) { ?>
	<div class="card card-body table-responsive mb-3">
    <h3><?php echo lang('Text.text_order_histories', array(), $lang->getFrontEndLocale()); ?></h3>
    <table class="table table-hover">
      <thead>
        <tr>
          <td><?php echo lang('Column.column_date_added', array(), $lang->getFrontEndLocale()); ?></td>
          <td><?php echo lang('Column.column_status', array(), $lang->getFrontEndLocale()); ?></td>
          <td><?php echo lang('Column.column_comment', array(), $lang->getFrontEndLocale()); ?></td>
        </tr>
      </thead>
      <tbody>
      <?php if ($histories) { ?>
	      <?php foreach ($histories as $history) { ?>
	      <tr>
	        <td><?php echo $history['date_added']; ?></td>
	        <td><?php echo $history['status']; ?></td>
	        <td><?php echo $history['comment']; ?></td>
	      </tr>
	      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="3" class="text-center"><?php echo lang('Text.text_no_results', array(), $lang->getFrontEndLocale()); ?></td>
      </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
  <?php } ?>

</section>
<!-- /.content -->
<?php echo $footer; ?>
