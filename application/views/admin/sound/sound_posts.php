
<input type="hidden" name="sound_id" id="sound_id" value="<?php echo $sound_id; ?>">

<div class="row page-titles">
<div class="col-md-12 align-self-center">
<h4 class="theme-cl">Showing Videos using sound <b>"<?php 
$d = $this->Sound_model->get_sound_name(base64_decode($sound_id));
echo $d['sound_title'];
?>"</b></h4>
</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table id="sound-post-table" class="table table-striped" style="width: 100%">
<thead class="thead-inverse">
<tr>
<th>Video</th>
<th>Video Image</th>
<th>User Name</th>
<th>Video Description</th>
<th>Video Hashtag</th>
<th>Total Reports</th>
<th>Total View</th>
<th>Total Likes</th>
<th>Trending</th>
<th>Status</th>
<th>Created Date</th>
<th>Make trending?</th>
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