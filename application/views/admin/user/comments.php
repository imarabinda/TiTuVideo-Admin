<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>"/>

<div class="row">
<div class="col-md-12">
<h4>Comments of "<?php 
$d = useridtodata(base64_decode($user_id));
echo $d['full_name'];
?>"</h4>
<div class="card">
<div class="card-header">
</div>


<div class="card-body">
<div class="table-responsive">
<table id="user-comments-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Video </th>
<th>Comment</th>
<th>Status</th>
<th>Time</th>
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