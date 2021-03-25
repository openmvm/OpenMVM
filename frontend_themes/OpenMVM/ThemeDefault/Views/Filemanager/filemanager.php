<?php echo $header; ?>
<!-- Content -->
<section class="container content min-vh-100 mt-3">
	<h1><?php echo lang('Heading.heading_filemanager', array(), $lang->getFrontEndLocale()); ?></h1>
	<div class="accordion" id="accordionFilemanager">
	  <div class="accordion-item">
	    <h2 class="accordion-header" id="headingFilemanager">
	      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilemanager" aria-expanded="true" aria-controls="collapseFilemanager">
	        <i class="fas fa-edit fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_filemanager', array(), $lang->getFrontEndLocale()); ?>
	      </button>
	    </h2>
	    <div id="collapseFilemanager" class="accordion-collapse collapse show" aria-labelledby="headingFilemanager" data-bs-parent="#accordionFilemanager">
	      <div class="accordion-body">
	      	<div id="filemanager-workspace"></div>
	      </div>
	    </div>
	  </div>
	</div>
</section>
<!-- /.content -->
<script type="text/javascript"><!--
$('#filemanager-workspace').load('<?php echo base_url('/account/filemanager/workspace/' . $user_token); ?>');
//--></script>
<?php echo $footer; ?>
