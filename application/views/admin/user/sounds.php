<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">

<div class="row">
<div class="col-md-12">
<h4>Sounds by "<?php 
$d = useridtodata(base64_decode($user_id));
echo $d['full_name'];
?>"</h4>
<div class="card">
<div class="card-header">
</div>


<div class="card-body">
<div class="table-responsive">
<table id="sounds-by-user-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Sound Image</th>
<th>Sound</th>
<th>Sound Category</th>
<th>Sound Title</th>
<th>Duration</th>
<th>Singer</th>
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