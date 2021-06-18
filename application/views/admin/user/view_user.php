
<div class="row">
<div class="col-md-6">
<div class="card">
<div class="card-body padd-0 text-center">
<div class="card-avatar style-2">
<img height="150px" width="150px" src="<?php 
$logo = $user_profile ? $user_profile : 'logo.png';
echo base_url().'uploads/'.$logo; ?>" class="rounded-circle author-box-picture mb-2" alt="">
</div>
<h5 class="font-normal mrg-bot-0 font-18 card-title"><?php echo $full_name;?></h5>
<h6 class="font-normal mrg-bot-0 font-15 card-title">@<?php echo $user_name;?></h6>
<p class="card-small-text"><?php echo $user_email;?></p>
</div>
<div class="bottom">
<ul class="social-detail">
<?php if($fb_url){
?>
<li><a target="_blank" href="<?php echo $fb_url; ?>" class="fab fa-facebook-f font-20 pointer p-l-5 p-r-5"></a></li>
<?php }
if($insta_url){
?>
<li><a target="_blank" href="<?php echo $insta_url; ?>" class="fab fa-instagram font-20 pointer p-l-5 p-r-5"></a></li>

<?php
} if($youtube_url){
?>
<li><a target="_blank" href="<?php echo $youtube_url; ?>" class="fab fa-youtube font-20 pointer p-l-5 p-r-5"></a></li>

<?php 
}
?></ul>
</div>
</div>

<div class="card">
<div class="card-header">
<h4 class="box-title">About Me</h4>
</div>

<div class="card-body">
<strong><i class="fa fa-book margin-r-5"></i>Bio</strong>
<p class="text-muted italic">
<?php echo $bio;?>
</p>
<div class="card-body">
<!-- <p>
<strong> Profile Category</strong> : </p> -->
<p>
<strong> Total Followers</strong> : <?php echo $total_followers; ?> </p>
<p>
<strong> Total Following</strong> :  <?php echo $total_following; ?></p>
<p>
<strong> Total Post</strong> : <?php echo $total_post; ?> </p>
</div>
</div>

</div>

</div>
<div class="col-md-6">
<div class="card">
<div class="card-header">
<h4 class="box-title">User Wallet</h4>
</div>

<div class="row">
<div class="col-md-6">
<div class="card-body">
<p>
<strong> Total Received</strong> : <?php echo $total_received; ?> </p>
<p>
<strong> Total Send</strong> : <?php echo $total_send; ?> </p>
<p>
<strong> In Wallet</strong> : <?php echo $my_wallet; ?> </p>
</div>
</div>
<div class="col-md-6">
<div class="card-body">
<p>
<strong> Check In</strong> : <?php echo $check_in; ?> </p>
<p>
<strong> Upload Video</strong> : <?php echo $upload_video; ?> </p>
<p>
<strong> From Fans</strong> : <?php echo $from_fans; ?> </p>
<p>
<strong> Spend In App</strong> : <?php echo $spen_in_app ?> </p>
<p>
<strong> Purchased</strong> : <?php echo $purchased?> </p>
</div>
</div>
</div>
</div>
<div class="card">
<div class="card-header">
<h4 class="box-title">Send Notification</h4>
</div>

<div class="col-md-12">
<div class="col-md-12">
<div class="card-body">
<input type="hidden" name="user_id" id="user_id" value="24">
<input type="text" placeholder="Please enter message" class="form-control" name="message" id="message">
</div>
</div>
<div class="text-center mb-4">
<input type="button" class="btn btn-primary btn-md" onclick="send_perticular_noti();" value="Send Notification">
</div>
</div>

</div>
</div>


</div>