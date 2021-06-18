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
<table id="user-notifications-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Sender Name</th>
<th>Type</th>
<th>Message</th>
<th>Time</th>
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