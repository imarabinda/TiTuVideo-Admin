
<div class="row justify-content-md-center">
<div class="col col-lg-2">
</div>
<div class="col-md-8">
<h4>Edit Coin Rate</h4>
<div class="card">
<div class="card-header">
</div>
<div class="card-body">
<form id='coin_rate_form' name="coin_rate_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="coin_rate_id" id="rewarding_action_id" value="<?php echo $coin_rate_id; ?>">
<div class="form-group">
<label for="categoryname">INR Rate</label>
<input type="text" class="form-control" id="usd_rate" value="<?php echo $usd_rate; ?>" name="usd_rate" placeholder="Enter INR Rate">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>
<div class="col col-lg-2">
</div>

</div>
</div>