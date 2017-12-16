$(function () {
	$('#btnNuevo').on('click', function(event) {
		event.preventDefault();
		
	});

	$('#btnViewList').on('click', function(event) {
		event.preventDefault();
		$('#pnlForm').fadeOut(400, function() {
			$('#pnlListado').fadeIn(400, function() {
				
			});
		});
	});

	$('#btnBack').on('click', function(event) {
		event.preventDefault();
		$('#pnlListado').fadeOut(400, function() {
			$('#pnlForm').fadeIn(400, function() {
				
			});
		});
	});
});