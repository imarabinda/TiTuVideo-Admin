


<div class="section-body">
<div class="row">
<div class="col-md-12 col-lg-8">
<div class="card">
<div class="card-body p-5">
<a class="profile-edit-icon pointer" data-toggle="modal" data-target="#modal-adminprofile">
<i class="far fa-edit font-20"></i>
</a>
<div class="text-center">
<img height="250" width="250" alt="profile" class="rounded-circle admin_profile" src="<?php echo base_url().'uploads/'.$this->session->userdata('admin_profile'); ?>">
<h4 class="font-20 col-indigo mt-2 mb-0 admin_name"><?php echo $this->session->userdata('admin_full_name'); ?></h4>
<div class="admin_name"><?php echo $this->session->userdata('admin_name'); ?></div>
<div class="admin_email"><?php echo $this->session->userdata('admin_email'); ?></div>
</div>
</div>
</div>
</div>


</div>

