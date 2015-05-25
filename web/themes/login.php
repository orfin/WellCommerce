<?PHP include('header.php'); ?>

<section id="content">
	<div class="container">
<!-- 		<?php include('breadcrumbs.php'); ?> -->
		
		<ul class="breadcrumbs">
			<li>Login form</li>
			<li><a href="index.php">Home page</a></li>
		</ul>

		
		<div class="row">
			<div class="col-lg-4">
				<div class="well-form">
					<h4>Sign in<small>*Requested fields</small></h4>
					
					<form>
						<div class="form-group requested">
							<label for="login">E-mail</label>
							<input type="text" class="form-control" id="login" />
						</div>
						
						<div class="form-group has-error requested">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" />
						</div>
						
						<div class="clearfix">
							<a href="#" class="btn btn-link nopadding notransform">Forgot password</a>
							<button type="submit" class="btn btn-primary pull-right">Sign in</button>
						</div>
					</form>
					<div class="alert alert-sm mtp30">
						<strong>If you are our regular customer</strong>
						<ul>
							<li>You buy quickly and easily</li>
							<li>You can follow any of your orders</li>
							<li>You receive information about promotions</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="well-form">
					<h4>Sign up<small>*Requested fields</small></h4>
					
					<form>
						<div class="form-group requested">
							<label for="login">First name</label>
							<input type="text" class="form-control" />
						</div>
						
						<div class="form-group requested">
							<label for="login">Last name</label>
							<input type="text" class="form-control" />
						</div>
						
						<div class="form-group requested">
							<label for="login">Phone number</label>
							<input type="text" class="form-control" />
						</div>
						
						<div class="form-group requested">
							<label for="login">E-mail</label>
							<input type="email" class="form-control" />
						</div>
						
						<div class="form-group requested">
							<label for="login">Password</label>
							<input type="password" class="form-control" />
						</div>
						
						<div class="form-group requested">
							<label for="login">Repeat password</label>
							<input type="password" class="form-control" />
						</div>
						
						<div class="alert alert-sm mtp30">
							<strong>Benefits of opening an account</strong>
			
							<ul>
								<li>Current status of your shipment</li>
								<li>Discounts for regular customers</li>
							</ul>
	
						</div>

						
						<h4 class="mtp30">Terms and conditions</h4>
								
						<div class="checkbox">
							<label>
								<input type="checkbox">
								I accept Demo Store <a href="#">conditions</a>
							</label>
						</div>
						
						<div class="checkbox">
							<label>
								<input type="checkbox">
								I want to recive newsletter with actual promotions
							</label>
						</div>

						
						<div class="clearfix">
							<button type="submit" class="btn btn-primary pull-right">Sign up</button>
						</div>
					</form>
				</div>
			</div>
			
			<div class="col-lg-4">
				<?php include('sidebarcontact.php'); ?>
			</div>
		</div>
			
		</div>
	</div>
</section>
   
<?PHP include('footer.php'); ?>