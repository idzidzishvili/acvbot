<?php 
	defined('BASEPATH') or exit('No direct script access allowed'); 
	$this->load->view('templates/header'); 
?>

	<div class="container pt-3">
		<div class="card mb-3">
			<div class="card-header">
				Add filters
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-2 mb-3 px-2">
						<label for="pickup-state">Pickup state</label>
						<select id="pickup-state" class="form-control form-control-sm">
							<option value="0">-- Any --</option>
							<?php foreach($states as $state):?>
								<option value="<?=$state->abbr?>"><?=$state->state?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-2 mb-3 px-2">
						<label for="pickup-zip">Pickup zip</label>
						<input type="text" class="form-control form-control-sm" id="pickup-zip" placeholder="Pickup zip">
					</div>
					<div class="col-md-2 mb-3 px-2">
						<label for="delivery-state">Delivery state</label>
						<select id="delivery-state" class="form-control form-control-sm">
							<option value="0">-- Any --</option>
							<?php foreach($states as $state):?>
								<option value="<?=$state->abbr?>"><?=$state->state?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-2 mb-3 px-2">
						<label for="payout">Payout (At least)</label>
						<input type="number" class="form-control form-control-sm" id="payout" placeholder="Payout">
					</div>
					<div class="col-md-2 mb-3 px-2 d-flex align-items-end">
						<button type="button" class="btn btn-sm btn-primary px-4" id="add-filter">Add Filter</button>
					</div>
				</div>
			</div>			
		</div>

		<div class="card mb-3">
			<div class="card-header">
				Selected filters
			</div>
			<div class="card-body">
				<div class="row">
					<?php echo form_open(base_url('home/getData'), ['id' => 'search-form']);?>
					<div class="table-responsive">
						<table class="table table-sm">
							<thead>
								<tr>
									<th scope="col">Pickup state</th>
									<th scope="col">Pickup zip</th>
									<th scope="col">Delivery state</th>
									<th scope="col">Payout</th>
									<th scope="col">Remove</th>
								</tr>
							</thead>
							<tbody id="filters">						
							</tbody>
						</table>
						<div>
							<button type="submit" class="btn btn-sm btn-primary px-4" id="start-search">Start search</button>
						</div> 
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>

		
		<div class="card ">
			<div class="card-header">
				Filter result
			</div>
			<div class="card-body">
				<div class="row">		
					<div class="table-responsive">
						<table class="table table-sm">
							<thead id="result-head" class="d-none">
								<tr>
									<th scope="col">Pickup state</th>
									<th scope="col">Pickup zip</th>
									<th scope="col">Delivery state</th>
									<th scope="col">Payout</th>
									<th scope="col">Status</th>
								</tr>
							</thead>
							<tbody id="search-result">						
							</tbody>
						</table>
					</div>			
				</div>
			</div>
		</div>

	</div>

	<script>
		$(document).ready(function() {

			$('#add-filter').click(function() {
				let pickupState = $('#pickup-state').val();
				let deliveryState = $('#delivery-state').val();
				$('#filters')
					.append($('<tr/>', { 'class': '' })
						.append($('<td/>', { 'class': '' })
							.append($('<input/>', { 'name': 'pickupState[]', 'readonly': true, 'value': pickupState!=0?pickupState:'Any' }))
						)
						.append($('<td/>', { 'class': '' })
							.append($('<input/>', { 'name': 'pickupZip[]', 'readonly': true, 'value': $('#pickup-zip').val() }))
						)
						.append($('<td/>', { 'class': '' })
							.append($('<input/>', { 'name': 'deliveryState[]', 'readonly': true, 'value': deliveryState!=0?deliveryState:'Any' }))
						)
						.append($('<td/>', { 'class': '' })
							.append($('<input/>', { 'name': 'payout[]', 'readonly': true, 'value': $('#payout').val() }))
						)
						.append($('<td/>', { 'class': '' })
							.append($('<button/>', { 'class': 'remove-filter', 'type': 'button', 'text': 'Remove' }))
						)
					);
				$("#pickup-state").val($("#pickup-state option:first").val());
				$("#delivery-state").val($("#delivery-state option:first").val());
				$('#pickup-zip').val('')
				$('#payout').val('')
			});


			$('#filters').on('click', '.remove-filter', function(e) {
				$(e.target).closest('tr').remove();
			});

			
			let interval = null;
			$('#search-form').submit(function(e) {
				e.preventDefault();
				let form = $('#search-form');
				if(interval) clearInterval(interval);
				interval = setInterval(function() {fetchData(form); }, 10000);
			});

		});


		function fetchData(form){			
			let actionUrl = form.attr('action');
			$.ajax({
				type: form.attr('method'),
				url:  form.attr('action'),
				data: form.serialize(),
				success: function (data) {
					var response = JSON.parse(data)
					if(response.status == 'success'){
						$('#search-result').html('');
						if(response.data.length)
							$('#result-head').removeClass('d-none')
						else
							$('#result-head').addClass('d-none')
						response.data.forEach(res => {
							$('#search-result')
								.append($('<tr/>', { 'class': '' })
									.append($('<td/>').text(res.pickupState))
									.append($('<td/>').text(res.pickupZip))
									.append($('<td/>').text(res.deliveryState))
									.append($('<td/>').text(res.payout))
									.append($('<td/>').text(''))
								);
						});


					}
				},
			});
		}
	</script>

<?php 
	$this->load->view('templates/footer'); 
?>