<?php
if (empty($this->session->userdata('is_login_verify'))) {
    redirect('/admin');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo APP_NAME; ?> - Admin</title>

<link href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="<?= base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href="<?= base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css">

<link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet">

<link href="<?= base_url(); ?>assets/plugins/morris.js/morris.css" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/sweetalert/css/sweetalert.css">

<link href="<?= base_url(); ?>assets/dist/css/animate.css" rel="stylesheet">
<link href="<?= base_url(); ?>assets/bundles/prism/prism.css" rel="stylesheet">

<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/daterangepicker/daterangepicker-bs3.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datepicker/datepicker3.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/select2.min.css">

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/components.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/jquery.toast.css" type="text/css">
<script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
</head>
<body>
<div class="loader"></div>
<div id="app">
<div class="main-wrapper main-wrapper-1">
<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
<div class="form-inline mr-auto">
<ul class="navbar-nav mr-3">
<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
<li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
<i data-feather="maximize"></i>
</a></li>
</ul>
</div>
<ul class="navbar-nav navbar-right">
<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
<img src="<?php echo base_url().'uploads/'.$this->session->userdata('admin_profile')?>" alt="user-img" class="user-img-radious-style admin_profile">
<span class="d-sm-none d-lg-inline-block"></span></a>
<div class="dropdown-menu dropdown-menu-right pullDown">
<div class="dropdown-title">Hello <?php echo $this->session->userdata('admin_full_name')?></div>
<a class="dropdown-item" href="<?= base_url(); ?>admin/profile" class="dropdown-item has-icon"><i class="ti-user"></i> My Profile</a>
<div class="dropdown-divider"></div>
<a href="<?= base_url(); ?>admin/Login/jadminlogout" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
Logout
</a>
</div>
</li>
</ul>
</nav>
<div class="main-sidebar sidebar-style-2">
<aside id="sidebar-wrapper">
<div class="sidebar-brand">
<a href="<?= base_url(); ?>admin/dashboard"> <img alt="image" src="<?= base_url(); ?>assets/dist/img/logo-impilo.png" class="header-logo" />
</a>
</div>
<ul class="sidebar-menu">
<?php
$arrays = array(
	'main'=>array(
		'dashboard'=>array(
			'icon'=>'monitor'
		)
		),
	'pages'=>array(
		'banners'=>array(
			'icon'=>'image'
		),'hash-tags'=>array(
			'icon'=>'tag'
		),'users'=>array(
			'icon'=>'users'
		),'profile-categories'=>array(
			'icon'=>'user-plus'
		),'videos'=>array(
			'icon'=>'video'
		),'sound-categories'=>array(
			'icon'=>'file-text'
		),'sounds'=>array(
			'icon'=>'music'
		),'notifications'=>array(
			'icon'=>'bell'
		),'comments'=>array(
			'icon'=>'message-square'
		),'verification-requests'=>array(
			'icon'=>'check-square'
		),'reports'=>array(
			'icon'=>'file-text'
		),'coin-rate'=>array(
			'icon'=>'dollar-sign'
		),'coin-plans'=>array(
			'icon'=>'list'
		),'rewarding-actions'=>array(
			'icon'=>'award'
		),'redeem-requests'=>array(
			'icon'=>'share'
		),'configs'=>array(
			'icon'=>'sliders'
		),
	)
);

foreach($arrays as $key=>$values){
	echo '<li class="menu-header">'.ucfirst($key).'</li>';
	if(is_array($values)){

		foreach($values as $k=>$value){
			$active = '';
			if($this->uri->segment(2) == $k){
				$active = 'active';
			}
			echo '<li class="dropdown '.$active.'">
<a href="'.base_url().'admin/'.$k.'" class="nav-link"><i data-feather="'.$value['icon'].'"></i><span>'.ucwords(str_replace("-"," ",$k)).'</span></a>
</li>';
		}
	}
}

?>
</ul>
</aside>
</div>

<div class="main-content">
<section class="section">

