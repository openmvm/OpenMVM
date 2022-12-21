<div id="widget-seller-dashboard-chart-<?php echo $widget; ?>" class="card shadow rounded-0 mb-3">
	<div class="card-header"><?php echo lang('Text.chart', [], $language_lib->getCurrentCode()); ?></div>
	<div class="card-body">
        <?php echo form_open('', ['id' => 'form-seller-dashboard-chart', 'class' => 'clearfix']); ?>
			<div class="float-end">
				<span class="d-inline-block"><?php echo lang('Text.data', [], $language_lib->getCurrentCode()); ?>:</span>
				<div class="form-group d-inline-block mb-3">
					<select name="data" id="input-seller-dashboard-chart-data" class="form-select">
						<option value="orders"><?php echo lang('Text.orders', [], $language_lib->getCurrentCode()); ?></option>
						<option value="revenue"><?php echo lang('Text.revenue', [], $language_lib->getCurrentCode()); ?></option>
					</select>
				</div>
				<div class="form-group d-inline-block mb-3">
					<select name="type" id="input-seller-dashboard-chart-type" class="form-select">
						<option value="day"><?php echo lang('Text.today', [], $language_lib->getCurrentCode()); ?></option>
						<option value="week"><?php echo lang('Text.this_week', [], $language_lib->getCurrentCode()); ?></option>
						<option value="month"><?php echo lang('Text.this_month', [], $language_lib->getCurrentCode()); ?></option>
						<option value="year"><?php echo lang('Text.this_year', [], $language_lib->getCurrentCode()); ?></option>
						<option value="custom"><?php echo lang('Text.custom', [], $language_lib->getCurrentCode()); ?></option>
					</select>
				</div>
				<div id="container-input-seller-dashboard-chart-year" class="form-group d-inline-block mb-3 d-none">
					<select name="year" id="input-seller-dashboard-chart-year" class="form-select">
						<option value="0"><?php echo lang('Text.select_year', [], $language_lib->getCurrentCode()); ?></option>
						<?php foreach ($years as $year) { ?>
						<option value="<?php echo $year; ?>"><?php echo $year; ?></option>
						<?php } ?>
					</select>
				</div>
				<div id="container-input-seller-dashboard-chart-month" class="form-group d-inline-block mb-3 d-none">
					<select name="month" id="input-seller-dashboard-chart-month" class="form-select"></select>
				</div>
				<div id="container-input-seller-dashboard-chart-day" class="form-group d-inline-block mb-3 d-none">
					<select name="day" id="input-seller-dashboard-chart-day" class="form-select"></select>
				</div>
			</div>
        <?php echo form_close(); ?>
		<canvas id="canvas-seller-dashboard-chart-<?php echo $widget; ?>"></canvas>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	$('body').on('change', '#input-seller-dashboard-chart-data', function() {
		getChart();
	});

	$('body').on('change', '#input-seller-dashboard-chart-type', function() {
		if ($(this).val() != 'custom') {
			$('#container-input-seller-dashboard-chart-year').addClass('d-none');
			$('#container-input-seller-dashboard-chart-month').addClass('d-none');
			$('#container-input-seller-dashboard-chart-day').addClass('d-none');

			getChart();
		} else {
			$('#container-input-seller-dashboard-chart-year').removeClass('d-none');
			$('select#input-seller-dashboard-chart-year').trigger('change');
			$('select#input-seller-dashboard-chart-month').trigger('change');
			$('select#input-seller-dashboard-chart-day').trigger('change');
		}
	});

	getChart();

	function getChart() {
		var data = $('#input-seller-dashboard-chart-data').val();

		if (data == 'orders') {
			var url = '<?php echo $url_appearance_marketplace_widget_seller_dashboard_chart_get_orders; ?>';
		} else if (data == 'revenue') {
			var url = '<?php echo $url_appearance_marketplace_widget_seller_dashboard_chart_get_revenue; ?>';
		}

		var type = $('#input-seller-dashboard-chart-type').val();
		var year = $('#input-seller-dashboard-chart-year').val();
		var month = $('#input-seller-dashboard-chart-month').val();
		var day = $('#input-seller-dashboard-chart-day').val();
	    $.ajax({
	        url: url,
            type: 'post',
	        dataType: 'json',
	        data: {
	        	type: type,
	        	year: year,
	        	month: month,
	        	day: day
	        },
	        beforeSend: function() {
	            $('#widget-seller-dashboard-chart-<?php echo $widget; ?> .card-body').addClass('position-relative');
	            $('#widget-seller-dashboard-chart-<?php echo $widget; ?> .card-body').append('<div class="mask d-flex align-items-center text-center"><div class="mx-auto" style="height: inherite;"><i class="fas fa-spinner fa-spin fa-3x"></i></div></div>');
	        },
	        complete: function() {
	            $('#widget-seller-dashboard-chart-<?php echo $widget; ?> .card-body').removeClass('position-relative');
	            $('#widget-seller-dashboard-chart-<?php echo $widget; ?> .card-body .mask').remove();
	        },
	        success: function(json) {
	            renderChart(json['results']);
	        },
	        error: function(xhr, ajaxOptions, thrownError) {
	            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	        }
	    });
	}

	var myChart = null;

	function renderChart(chartData) {
		const ctx = document.getElementById('canvas-seller-dashboard-chart-<?php echo $widget; ?>');

	    if(myChart){
	        myChart.clear();
	        myChart.destroy();
	    }

		myChart = new Chart(ctx, {
			type: 'bar',
			data: chartData,
			options: {
			  	scales: {
			    	y: {
		      			beginAtZero: true,
			            ticks: {
			                precision: 0
			            },
			            suggestedMax: 10
			    	}
			  	}
			}
		});
	}
</script>
<script type="text/javascript"><!--
$('body').on('change', 'select#input-seller-dashboard-chart-year', function() {
	$.ajax({
		url: '<?php echo $url_appearance_marketplace_widget_seller_dashboard_chart_get_months; ?>',
		type: 'post',
		dataType: 'json',
		data: {
			year: $('#input-seller-dashboard-chart-year').val(),
			month: $('#input-seller-dashboard-chart-month').val(),
			day: $('#input-seller-dashboard-chart-day').val()
		},
		beforeSend: function() {
			$('select#input-seller-dashboard-chart-year').prop('disabled', true);
		},
		complete: function() {
			$('select#input-seller-dashboard-chart-year').prop('disabled', false);
		},
		success: function(json) {
			html = '<option value=""><?php echo lang('Text.select_month', [], $language_lib->getCurrentCode()); ?></option>';
			
			if (json['months'] && json['months'] != '' && $('#input-seller-dashboard-chart-year').val() != 0) {
				for (i = 0; i < json['months'].length; i++) {
                    month = json['months'][i];

					html += '<option value="' + month['value'] + '">' + month['text'] + '</option>';
				}
			} else {
				html += '<option value="" selected="selected"><?php echo lang('Text.none', [], $language_lib->getCurrentCode()); ?></option>';
			}
			
			$('select#input-seller-dashboard-chart-month').html(html);
			$('#container-input-seller-dashboard-chart-month').removeClass('d-none');
			$('select#input-seller-dashboard-chart-month').trigger('change');
			$('select#input-seller-dashboard-chart-day').trigger('change');

			if ($('#input-seller-dashboard-chart-year').val() != '' && $('#input-seller-dashboard-chart-year').val() != '0') {
				getChart();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//--></script> 
<script type="text/javascript"><!--
$('body').on('change', 'select#input-seller-dashboard-chart-month', function() {
	$.ajax({
		url: '<?php echo $url_appearance_marketplace_widget_seller_dashboard_chart_get_days; ?>',
		type: 'post',
		dataType: 'json',
		data: {
			year: $('#input-seller-dashboard-chart-year').val(),
			month: $('#input-seller-dashboard-chart-month').val(),
			day: $('#input-seller-dashboard-chart-day').val()
		},
		beforeSend: function() {
			$('select#input-seller-dashboard-chart-month').prop('disabled', true);
		},
		complete: function() {
			$('select#input-seller-dashboard-chart-month').prop('disabled', false);
		},
		success: function(json) {
			html = '<option value=""><?php echo lang('Text.select_day', [], $language_lib->getCurrentCode()); ?></option>';
			
			if (json['days'] && json['days'] != '' && $('#input-seller-dashboard-chart-month').val() != 0) {
				for (i = 0; i < json['days'].length; i++) {
                    day = json['days'][i];

					html += '<option value="' + day + '">' + day + '</option>';
				}
			} else {
				html += '<option value="" selected="selected"><?php echo lang('Text.none', [], $language_lib->getCurrentCode()); ?></option>';
			}
			
			$('select#input-seller-dashboard-chart-day').html(html);
			$('#container-input-seller-dashboard-chart-day').removeClass('d-none');

			if ($('#input-seller-dashboard-chart-month').val() != '' && $('#input-seller-dashboard-chart-month').val() != '0') {
				getChart();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//--></script> 
<script type="text/javascript"><!--
$('body').on('change', 'select#input-seller-dashboard-chart-day', function() {
	$.ajax({
		url: '<?php echo $url_appearance_marketplace_widget_seller_dashboard_chart_get_days; ?>',
		type: 'post',
		dataType: 'json',
		data: {
			year: $('#input-seller-dashboard-chart-year').val(),
			month: $('#input-seller-dashboard-chart-month').val(),
			day: $('#input-seller-dashboard-chart-day').val()
		},
		beforeSend: function() {
			$('select#input-seller-dashboard-chart-day').prop('disabled', true);
		},
		complete: function() {
			$('select#input-seller-dashboard-chart-day').prop('disabled', false);
		},
		success: function(json) {
			if ($('#input-seller-dashboard-chart-day').val() != '' && $('#input-seller-dashboard-chart-day').val() != '0') {
				getChart();
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//--></script> 
	