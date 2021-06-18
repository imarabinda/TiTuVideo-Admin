<div class="content-wrapper">
	<div class="container-fluid">

		<!-- Title & Breadcrumbs-->
		<div class="row page-titles">
			<div class="col-md-12 align-self-center">
				<h4 class="theme-cl">Add Security</h4>
			</div>
		</div>
		<!-- Title & Breadcrumbs-->

		<!-- row -->
		<div class="row">
			<div class="col-md-12 col-sm-12">

				<?php
					$admin_id = $this->session->userdata('admin_id');
                    $admin_data = get_row_data('tbl_admin',array('admin_id'=>$admin_id));
                    if(empty($admin_data['twofa_secret'])) {
                        $twofa_secret = set_google_secret();
                    } else {
                        $twofa_secret = $admin_data['twofa_secret'];
                    }
                ?>	

			<h4 class="box-title m-t-40">2-step Google Verification
				<?php
				if($admin_data['is_twofa'] == 0)
				{
					?>
					<label class="badge badge-danger">Disable</label>
					<?php
				}
				else
				{
					?>
					<label class="badge badge-success">Enable</label>
					<?php
				}
				?>
			</h4>
				<p>Protect Your wallet from unauthorized access by enabling 2-Step Verification By Google Authenticator.You can choose to use a free app or your mobile phone number to secure your wallet.
				</p>
			</div>
									
			<div class="col-md-6 col-sm-6">
				<div class="card card-inverse bg-primary mb-3 text-center">
					<div class="card-block">
						<blockquote class="card-blockquote">

						<h3 class="text-center text-white"><b>Scan</b></h3>
						  <p>Open your two-factor authentication app and scan the code with the camera on your phone.</p>
						  <p>
						  	 <img src="<?php echo get_qr_code($admin_data['admin_email'],$twofa_secret);?>" width="200px"/>

						  </p>
						  <footer>
							 <cite title="Source Title">ManualKey: <?php echo $twofa_secret;?></cite></footer>
						</blockquote>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6">
				<div class="card card-inverse bg-primary mb-3 text-center">
					<div class="card-block">
						<blockquote class="card-blockquote">
						<h3 class="text-center text-white"><b>Confirm</b></h3>
						  <p>Enter the password and verification code generated by your two-factor authentication app.</p>
						  <p>
						  	<form id="manage_2fa" name="manage_2fa" method="POST" enctype="multipart/form-data" novalidate="novalidate">

								<div class="form-group">
									<div class="row">
									  <label for="" class="col-3 col-form-label">Password</label>
									  <div class="col-9">
										<input class="form-control" type="text" placeholder="Please enter password" value="" id="password" name="password">
									  </div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
									  <label for="" class="col-3 col-form-label">2-F Code</label>
									  <div class="col-9">
										<input class="form-control" placeholder="Enter 6 digit google authentication code" type="text" value="" id="two_fa_code" name="two_fa_code">
									  </div>
									</div>
								</div>

								<div class="form-group">				
									<div class="row">
										<div class="col-md-12">
											<?php
											if($admin_data['is_twofa']  == 0)
											{
												?>
												<input type="hidden" name="type" id="type" value="enable">
												<button type="submit" class="btn btn-success mr-3">Enable</button>
												<?php
											}
											else
											{
												?>
												<input type="hidden" name="type" id="type" value="disable">
												<button type="submit" class="btn btn-danger mr-3">Disable</button>
												<?php
											}
											?>
										</div>
									</div>
								</div>

							</form>
						  </p>
						  <!-- <footer>Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
						</blockquote>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->


	</div>
	<!-- /.content-wrapper-->