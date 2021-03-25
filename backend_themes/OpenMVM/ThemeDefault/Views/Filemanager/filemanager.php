<?php echo $header; ?>
<?php echo $sidemenu; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="content-wrapper min-vh-100">
	<!-- Heading Container -->
	<section class="heading-container bg-dark p-3">
		<h2 class="heading-title text-white"><i class="fas fa-images fa-fw"></i> <?php echo $heading_title; ?></h2>
		<div class="heading-lead lead text-white"><?php echo $lead; ?></div>
	</section>
  <!-- /.heading-container -->

	<!-- Breadcrumb -->
	<?php if ($breadcrumbs) { ?>
	<section id="breadcrumb" class="bg-light p-3 mb-3">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb small p-0 m-0">
		  	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		  		<?php if ($breadcrumb['active']) { ?>
		    	<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb['text']; ?></li>
	  			<?php } else { ?>
		    	<li class="breadcrumb-item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	  			<?php } ?>
		  	<?php } ?>
		  </ol>
		</nav>
  </section>
	<?php } ?>
	<!-- /.breadcrumb -->

	<!-- Notification -->
	<?php if ($success || $error) { ?>
	<section id="notification" class="notification px-3">
		<?php if ($success) { ?>
		<div class="alert alert-success alert-dismissible" role="alert">
		  <?php echo $success; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
		<?php if ($error) { ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
		  <?php echo $error; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php } ?>
  </section>
	<?php } ?>
	<!-- /.notification -->

	<!-- Content -->
	<section class="content px-3">
		<div class="accordion" id="accordionFilemanager">
		  <div class="accordion-item">
		    <h2 class="accordion-header" id="headingFilemanager">
		      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilemanager" aria-expanded="true" aria-controls="collapseFilemanager">
		        <i class="fas fa-edit fa-fw"></i>&nbsp;&nbsp;<?php echo lang('Heading.heading_filemanager', array(), $lang->getBackEndLocale()); ?>
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
$('#filemanager-workspace').load('<?php echo base_url($_SERVER['app.adminDir'] . '/filemanager/workspace/' . $administrator_token); ?>');
//--></script>
<?php echo $footer; ?>
