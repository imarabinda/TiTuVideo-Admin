<input type="hidden" id="user_id" value="<?php echo $user_id; ?>"/>

<div class="row">
<div class="col-md-12">
<h4 class="theme-cl">Reports of <?php $full = useridtodata(base64_decode($user_id));
echo $full['full_name'];
?>
</h4>

<div class="card">
<div class="card-header">
</div>
<div class="card-body">
<div class="table-responsive">
<table id="user-reports-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Reported By</th>
<th>Reason</th>
<th>Description</th>
<th>Contact Info</th>
<th>Created Date</th>
<th>Status</th>
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