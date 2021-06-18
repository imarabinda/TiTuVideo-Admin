<input type="hidden" name="sound_category_id" id="sound_category_id" value="<?php echo $sound_category_id; ?>">

<div class="row">
<div class="col-md-12">
<h4>Showing Sound of "<?php 
$d = $this->Sound_model->get_category_name(base64_decode($sound_category_id));
echo $d['sound_category_name'];
?>" Category</h4>
<div class="card">
<div class="card-header">
</div>


<div class="card-body">
<div class="table-responsive">
<table id="sound-by-category-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Sound Image</th>
<th>Sound</th>
<th>Sound Title</th>
<th>Duration</th>
<th>Singer</th>
<th>Added By</th>
<th>Status</th>
<th>Created Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>