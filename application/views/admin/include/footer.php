
</section>


</div>
<footer class="main-footer">
<div class="footer-left">
<small class="font-15">Made With <i class="fa fa-heart cl-danger"></i> In India</small>
</div>
<div class="footer-right">
</div>
</footer>
</div>
</div>

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="myModalLabel1"></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body videodiv">
<video width="450" height="450" controls>
<source src="" type="video/mp4">
</video>
</div>
<div class="modal-footer bg-whitesmoke br">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-adminprofile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title adminprofiletitle">Edit Details</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='adminprofile' name="adminprofile" method="post" enctype="multipart/form-data">
<input type="hidden" name="admin_id" id="admin_id" value="1">
<div class="form-group">
<label for="inputName" class="col-sm-2 control-label">Name</label>
<div class="col-sm-10">
<input type="text" class="form-control" placeholder="Name" id="admin_name" name="admin_name" value="<?php echo $this->session->userdata('admin_name'); ?>">
</div>
</div>
<div class="form-group">
<label for="inputEmail" class="col-sm-2 control-label">Email</label>
<div class="col-sm-10">
<input type="text" class="form-control" id="admin_email" name="admin_email" placeholder="Email" value="<?php echo $this->session->userdata('admin_email'); ?>">
</div>
</div>
<div class="form-group">
<label for="inputName" class="col-sm-2 control-label">Password</label>
<div class="col-sm-10">
<input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Password" value="">
</div>
</div>
<div class="form-group">
<label for="profile">Profile</label>
<input type="file" class="form-control-file" id="profile_image" name="profile_image">
<label id="profile_image-error" class="error image_error" for="profile_image"></label>
<input type="hidden" name="hdn_profile_image" id="hdn_profile_image" value="<?php echo $this->session->userdata('admin_profile'); ?>">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger admin_profile_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-hashtag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title hashtagtitle">Edit Explore Hash Tag Image</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='explore_image' name="explore_image" method="post" enctype="multipart/form-data">
<input type="hidden" name="hash_tag_id" id="hdn_hash_tag_id" value="">

<div class="form-group">
<div class="section-title">Explore Hash Tag Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="hash_tag_profile" name="hash_tag_profile">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="hash_tag_profile-error" class="error image_error" for="hash_tag_profile"></label>
</div>



<div class="form-group preview_hashtagimg">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger hashtag_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-soundcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title soundcattitle">Add Sound Category</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='sound_category_form' name="sound_category_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="sound_category_id" id="hdn_sound_category_id" value="">
<div class="form-group">
<label for="categoryname">Sound Category Name</label>
<input type="text" class="form-control" id="sound_category_name" name="sound_category_name" placeholder="Enter Category Name">
</div>

<div class="form-group">
<div class="section-title">Sound Category Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input image" id="sound_category_profile" name="sound_category_profile">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="sound_category_profile-error" class="error image_error" for="sound_category_profile"></label>
</div>


<div class="form-group preview_soundcatimg">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger sound_category_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>

<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-sound" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title soundtitle">Add Sound</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='sound_form' name="sound_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="sound_id" id="sound_id" value="">
<div class="form-group">
<label for="categoryname">Sound Category</label>
<select class="custom-select" id="sound_category_id" name="sound_category_id">
<option value="">Select Category</option>
</select>
</div>
<div class="form-group">
<label for="categoryname">Sound Title</label>
<input type="text" class="form-control" id="sound_title" name="sound_title" placeholder="Sound Title">
</div>
<div class="form-group">
<label for="categoryname">Singer</label>
<input type="text" class="form-control" id="singer" name="singer" placeholder="Singer">
</div>
<div class="form-group">
<label for="categoryname">Duration</label>
<input type="text" class="form-control" id="duration" name="duration" placeholder="Duration">
</div>


<div class="form-group">
<div class="section-title">Sound</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="sound" name="sound">
                      <label class="custom-file-label" for="customFile">Choose sound</label>
</div>
<label id="sound-error" class="error sound_error" for="sound"></label>
</div>


<div class="form-group preview_soundimg">
</div>


<div class="form-group">
<div class="section-title">Sound Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="sound_image" name="sound_image">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="sound_image-error" class="error image_error" for="sound_image"></label>
</div>


<div class="form-group preview_soundcatimg">
</div>

<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger sound_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>




<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title notificationtitle">Send Notification</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='notification_form' name="notification_form" method="post" enctype="multipart/form-data">

<div class="form-group">
<label for="notification_title">Notification Title</label>
<input type="text" class="form-control" id="notification_title" name="notification_title" placeholder="Notification Title">
</div>
<div class="form-group">
<label for="categoryname">Notification Body</label>
<input type="text" class="form-control" id="notification_body" name="notification_body" placeholder="Notification Body">
</div>

<div class="form-group preview_notification_icon">
</div>


<div class="form-group">
<div class="section-title">Notification Icon</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="notification_icon" name="notification_icon">
                      <label class="custom-file-label" for="customFile">Choose icon</label>
</div>
<label id="notification_icon-error" class="error image_error" for="notification_icon"></label>
</div>


<div class="form-group preview_notification_img">
</div>




<div class="form-group">
<div class="section-title">Notification Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="notification_image" name="notification_image">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="notification_image-error" class="error image_error" for="notification_image"></label>
</div>



<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger notification_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>


<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-banner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title bannertitle">Add Banner</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='banner_form' name="banner_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="banner_id" id="banner_id" value="">
<div class="form-group">
<label for="bannername">Banner Action</label>
<select class="form-control" id="banner_action" name="banner_action">
<option value="">Select Action</option>
<?php if(!empty($banner_options)){
   foreach($banner_options as $value){
      echo '<option value="'.$value['banner_action'].'">'.$value['banner_action_name'].'</option>';
   }
}
?>
</select>
</div>

<div class="form-group">
<label for="categoryname">Banner Action Value</label>
<input type="text" class="form-control" id="banner_action_value" name="banner_action_value" placeholder="Banner Action Value">
</div>



<div class="form-group">
<div class="section-title">Banner Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="banner_image" name="banner_image">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="banner_image-error" class="error image_error" for="banner_image"></label>
</div>



<div class="form-group preview_bannerimg">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger banner_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>


<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-rewarding_action" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title">Edit Rewarding Action</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='rewarding_action_form' name="rewarding_action_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="rewarding_action_id" id="rewarding_action_id" value="">
<div class="form-group">
<label for="categoryname">Action Name</label>
<input type="text" class="form-control" id="action_name" value="" name="action_name" placeholder="Action Name">
</div>
<div class="form-group">
<label for="categoryname">Coin</label>
<input type="text" class="form-control" id="coin" value="" name="coin" placeholder="Coin">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger rewarding_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-coin-plan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title coinplantitle">Add Coin Plan</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='coin_plan_form' name="coin_plan_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="coin_plan_id" id="coin_plan_id" value="">
<div class="form-group">
<label for="categoryname">Coin Plan Name</label>
<input type="text" class="form-control" id="coin_plan_name" name="coin_plan_name" placeholder="Coin Plan Name">
</div>
<div class="form-group">
<label for="categoryname">Coin Plan Description</label>
<input type="text" class="form-control" id="coin_plan_description" name="coin_plan_description" placeholder="Coin Plan Description">
</div>
<div class="form-group">
<label for="categoryname">Coin Plan Price</label>
<input type="text" class="form-control" id="coin_plan_price" name="coin_plan_price" placeholder="Coin Plan Price">
</div>
<div class="form-group">
<label for="categoryname">Coin amount</label>
<input type="text" class="form-control" id="coin_amount" name="coin_amount" placeholder="Coin amount">
</div>
<div class="form-group">
<label for="categoryname">Playstore Product Id</label>
<input type="text" class="form-control" id="playstore_product_id" name="playstore_product_id" placeholder="Playstore Product Id">
</div>
<div class="form-group">
<label for="categoryname">Appstore Product Id</label>
<input type="text" class="form-control" id="appstore_product_id" name="appstore_product_id" placeholder="Appstore Product Id">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger coin_plan_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>
<div tabindex="-1" role="dialog" class="modal fade slide-right" id="modal-profilecategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" modal-animation="true">
<div class="modal-dialog modal-md">
<div class="modal-content" uib-modal-transclude="">
<div class="modal-header">
<div class="position-relative title-content w-100">
<h4 class="modal-title profilecattitle">Add Profile Category</h4>
<button type="button" class="pointer action-button close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
</div>
<div class="modal-body clearfix">
<form class="edit-detail-content" id='profile_category_form' name="profile_category_form" method="post" enctype="multipart/form-data">
<input type="hidden" name="profile_category_id" id="profile_category_id" value="">
<div class="form-group">
<label for="categoryname">Profile Category Name</label>
<input type="text" class="form-control" id="profile_category_name" name="profile_category_name" placeholder="Enter Category Name">
</div>

<div class="form-group">
<div class="section-title">Profile Category Image</div>
<div class="custom-file">
                      <input type="file" class="custom-file-input" id="profile_category_image" name="profile_category_image">
                      <label class="custom-file-label" for="customFile">Choose image</label>
</div>
<label id="profile_category_image-error" class="error image_error" for="profile_category_image"></label>
</div>


<div class="form-group preview_profilecatimg">
</div>
<div class="form-group form-action text-right m-t-10">
<a style="color: #fff" class="btn btn-danger btn-md bg-danger profile_category_cancel">Cancel</a>
<button type="submit" class="btn btn-primary btn-md m-l-10">Submit</button>
</div>
</form>
</div>
</div>
</div>
</div>

<div class="w3-sidebar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="rightMenu">
<div class="rightMenu-scroll">
<button onclick="closeRightMenu()" class="w3-bar-item w3-button w3-large theme-bg">Setting Pannel <i class="ti-close"></i></button>
<div class="right-sidebar" id="side-scroll">
<div class="user-box">
<div class="profile-img">


<div class="notify setp"> <span class="heartbit"></span> <span class="point"></span> </div>
</div>
<div class="profile-text">
<h4>name</h4>
<a href="" class="bg-info-light"><i class="ti-settings"></i></a>
<a href="" class="bg-danger-light"><i class="ti-power-off"></i></a>
</div>
<div class="tabbable-line">
<ul class="nav nav-tabs ">
</ul>
<div class="tab-content">
</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    var base_url = '<?= base_url(); ?>';

</script>

<a class="scroll-to-top rounded cl-white theme-bg" href="#page-top">
<i class="ti-angle-double-up"></i>
</a>
<script src="<?= base_url(); ?>assets/js/app.min.js"></script>

<script src="<?= base_url(); ?>assets/bundles/datatables/datatables.min.js"></script>
<script src="<?= base_url(); ?>assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/bundles/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jquery.validate.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jquery.validate.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/sweetalert/js/sweetalert.js"></script>

<script src="<?= base_url(); ?>assets/bundles/prism/prism.js"></script>
<script src="<?= base_url(); ?>assets/bundles/apexcharts/apexcharts.min.js"></script>
<script src="<?= base_url(); ?>assets/js/page/index.js"></script>

<script src="<?= base_url(); ?>assets/js/scripts.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jQuery.style.switcher.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/jquery.toast.js"></script>
<script src="<?= base_url(); ?>assets/dist/js/custom.js"></script>

<script>

    $(".loading").hide();


    var readURL = function (input, cl) {
      console.log(input.files);  
      if (input.files && input.files[0]) {
           
         $(input).next().html(input.files[0]['name']);
         
         var image = /(\image)$/i;
         
         var audio = /(\audio)$/i;

         if(image.exec(input.files[0].type)){
            image_ex(input,cl);
         }
           
        }
    }

    function image_ex(input,cl){
       $('.image_error').text("");
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (!allowedExtensions.exec(input.value)) {
                $('.image_error').show();
                $('.image_error').text('Please upload file having extensions .jpeg/.jpg/.png only.');
                input.value = '';
                return false;
            } else {
                $('.image_error').text('');
                
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.' + cl).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
    }

    $(".custom-file-input").on('change', function () {
        readURL(this, 'displayimg');
    });


    document.addEventListener('play', function(e){
      var audios = document.getElementsByTagName('audio');
      for(var i = 0, len = audios.length; i < len;i++){
          if(audios[i] != e.target){
              audios[i].pause();
          }
      }
  }, true);

    var htmlPlayer = document.getElementsByTagName('video');

    function pausePlayer() {
      for(var i = 0; i < htmlPlayer.length; i++){
        htmlPlayer[i].pause();
      }
    }

</script>
<script>
    function openRightMenu() {
        document.getElementById("rightMenu").style.display = "block";
    }
    function closeRightMenu() {
        document.getElementById("rightMenu").style.display = "none";
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#styleOptions').styleSwitcher();
    });
</script>
<script>
    $('.dropdown-toggle').dropdown()
</script>
<script>
    $(function () {
        $(".heading-compose").click(function () {
            $(".side-two").css({
                "left": "0"
            });
        });

        $(".newMessage-back").click(function () {
            $(".side-two").css({
                "left": "-100%"
            });
        });
    })
</script>
</div>

<script>

    $(function () {
        "use strict";
        var a, i = ["red-skin", "blue-skin", "green-skin", "yellow-skin", "purple-skin", "cyan-skin", "red-skin-light", "blue-skin-light", "green-skin-light", "yellow-skin-light", "purple-skin-light", "cyan-skin-light"];

        function o(e) {
            var a, o;
            return $.each(i, function (e) {
                $("body").removeClass(i[e])
            }), $("body").addClass(e), a = "skin", o = e, "undefined" != typeof Storage ? localStorage.setItem(a, o) : window.alert("Please use a modern browser to properly view this template!"), !1
        }
        (a = void("undefined" != typeof Storage || window.alert("Please use a modern browser to properly view this template!"))) && $.inArray(a, i) && o(a), $("[data-skin]").on("click", function (e) {
            $(this).hasClass("knob") || (e.preventDefault(), o($(this).data("skin")))
        })
    });
</script>
<script type="text/javascript">

   if($('#user-table').length > 0){
        var dataTable = $('#user-table').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "order": [[ 0, "desc" ]],
        //'searching': false, // Remove default Search Control
        'ajax': {
        'url':'<?= base_url(); ?>admin/User/showUsers',
        'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
        }
        }
        });
    }if($('#user-category-table').length > 0){
        var dataTable = $('#user-category-table').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "order": [[ 0, "desc" ]],
        //'searching': false, // Remove default Search Control
        'ajax': {
        'url':'<?= base_url(); ?>admin/Profile_Categories/showUsers',
        'data': function(data){
            // Read values
            var category_id = $('#category_id').val();

            // Append to data
            data.category_id = category_id;
        }
        }
        });
    }
    if($('#sound-category-table').length > 0){
      var dataTable = $('#sound-category-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Sound/showSoundCategory',
         'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
         }
      }
      });
    }
    if($('#profile-category-table').length > 0){
      var dataTable = $('#profile-category-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Profile_Categories/showProfileCategories',
         'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
         }
      }
      });
    }
    if($('#sound-table').length > 0){
      var dataTable = $('#sound-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Sound/showSound',
         'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
         }
      }
      });
    }
    
    if($('#banners-table').length > 0){
      var dataTable = $('#banners-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/SearchHeaders/showSearchHeaders',
         'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
         }
      }
      });
    }

    if($('#sound-by-category-table').length > 0){
      var dataTable = $('#sound-by-category-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Sound/showCategorySounds',
         'data': function(data){
            // Read values
            var sound_category_id = $('#sound_category_id').val();

            // Append to data
            data.sound_category_id = sound_category_id;
         }
      }
      });
    }
    if($('#sounds-by-user-table').length > 0){
      var dataTable = $('#sounds-by-user-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/User/showUserSounds',
         'data': function(data){
            // Read values
            var user_id = $('#user_id').val();

            // Append to data
            data.user_id = user_id;
         }
      }
      });
    }

    
if($('#user-notifications-table').length > 0){
      var dataTable = $('#user-notifications-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/User/showUserNotifications',
         'data': function(data){
            // Read values
            var user_id = $('#user_id').val();

            // Append to data
            data.user_id = user_id;
         }
      }
      });
    }
if($('#user-comments-table').length > 0){
      var dataTable = $('#user-comments-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/User/showUserComments',
         'data': function(data){
            // Read values
            var user_id = $('#user_id').val();

            // Append to data
            data.user_id = user_id;
         }
      }
      });
    }
    
    if($('#post-table').length > 0){
      var dataTable = $('#post-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Post/showPost',
         'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
         }
      }
      });
    }
    if($('#user-post-table').length > 0){
      var dataTable = $('#user-post-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/User/showUserPost',
         'data': function(data){
            // Read values
            var user_id = $('#user_id').val();

            // Append to data
            data.user_id = user_id;
         }
      }
      });
    }if($('#hash-post-table').length > 0){
      var dataTable = $('#hash-post-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Hash_Tag/showHashPosts',
         'data': function(data){
            // Read values
            var hash_tag_name = $('#hash_tag_name').val();

            // Append to data
            data.hash_tag_name = hash_tag_name;
         }
      }
      });
    }if($('#sound-post-table').length > 0){
      var dataTable = $('#sound-post-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Sound/showSoundPosts',
         'data': function(data){
            // Read values
            var sound_id = $('#sound_id').val();

            // Append to data
            data.sound_id = sound_id;
         }
      }
      });
    }
    if($('#rewarding-table').length > 0){
      var dataTable = $('#rewarding-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Rewarding/showRewardingList',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#redeem-request-table').length > 0){
      var dataTable = $('#redeem-request-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Redeem_Request/showRedeemRequest',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#redeem-request-confirm-table').length > 0){
      var dataTable = $('#redeem-request-confirm-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Redeem_Request/showRedeemRequest_confirm',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#report-table').length > 0){
      var dataTable = $('#report-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Report/showReport',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#report-table-user').length > 0){
      var dataTable = $('#report-table-user').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Report/showReportUser',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#user-reports-table').length > 0){
      var dataTable = $('#user-reports-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/User/showUserReports',
         'data': function(data){
            // Read values
            var user_id = $('#user_id').val();

            // Append to data
            data.user_id = user_id;
         }
      }
      });
    }
    if($('#video-reports-table').length > 0){
      var dataTable = $('#video-reports-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Post/showVideoReports',
         'data': function(data){
            // Read values
            var video_id = $('#video_id').val();

            // Append to data
            data.video_id = video_id;
         }
      }
      });
    }
    if($('#verification-request-table').length > 0){
      var dataTable = $('#verification-request-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Verification_Request/showVerificationRequest',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#hashtag-table').length > 0){
      var dataTable = $('#hashtag-table').DataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Hash_Tag/showHashTag',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#hashtag-table-explore').length > 0){
      var dataTable = $('#hashtag-table-explore').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Hash_Tag/showHashTagExplore',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }
    if($('#coin-plan-table').length > 0){
      var dataTable = $('#coin-plan-table').dataTable({
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      "order": [[ 0, "desc" ]],
      //'searching': false, // Remove default Search Control
      'ajax': {
         'url':'<?= base_url(); ?>admin/Coin/showCoinPlan',
         'data': function(data){
            // Read values
            // var user_id = $('#user_id').val();

            // Append to data
            // data.user_id = user_id;
         }
      }
      });
    }

    if($('#notifications-table').length > 0){
        var dataTable1 = $('#notifications-table').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "order": [[ 0, "desc" ]],
        //'searching': false, // Remove default Search Control
        'ajax': {
        'url':'<?= base_url(); ?>admin/Notifications/showNotification',
        'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
        }
        }
        });
    }
    if($('#comments-table').length > 0){
        var dataTable1 = $('#comments-table').dataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "order": [[ 0, "desc" ]],
        //'searching': false, // Remove default Search Control
        'ajax': {
        'url':'<?= base_url(); ?>admin/Comments/showComments',
        'data': function(data){
            // Read values
            // var country = $('#country').val();

            // Append to data
            // data.country = country;
        }
        }
        });
    }
  function explore_image_dis(hash_tag_id)
  {
      $("#hash_tag_id").val(hash_tag_id);
  }



// function callfun()
// {
//     dataTable.draw();
// }
</script>
</body>
</html>