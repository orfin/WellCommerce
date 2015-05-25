<?PHP include('header.php'); ?>

<section id="content">
	<div class="container">
		<ul class="breadcrumbs">
			<li>Account settings</li>
			<li><a href="category.php">Your account</a></li>
		</ul>

		
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<?php include('clientmenubox.php'); ?>
			</div>

			<div class="col-lg-7">
				<div class="well-form mbt60">
					<h4>Contact data<small>*Requested fields</small></h4>
					
					<div class="alert alert-info alert-sm">
						By changing the e-mail address will also change your user name to the store. After the change you will be logged out and will need to re-log in to the store
					</div>
					
					<form class="form-horizontal">
						<div class="form-group requested">
							<label class="col-lg-3 text-right" for="">Phone</label>
							<div class="col-lg-5">
								<input type="tel" class="form-control" />
							</div>
						</div>						
						
						<div class="form-group">
							<label class="col-lg-3 text-right" for="">Additional Phone</label>
							<div class="col-lg-5">
								<input type="tel" class="form-control" />
							</div>
						</div>
						
						<div class="form-group requested">
							<label class="col-lg-3 text-right" for="">E-mail</label>
							<div class="col-lg-5">
								<input type="e-mail" class="form-control" />
							</div>
						</div>
						
						<div class="row mtp20">
							<div class="col-lg-5 col-lg-offset-3">
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</form>
				</div>

				<div class="well-form">
					<h4>Change password<small>*Requested fields</small></h4>
					
					<form class="form-horizontal">
						<div class="form-group requested">
							<label class="col-lg-3 text-right" for="">Password</label>
							<div class="col-lg-5">
								<input type="password" class="form-control" />
							</div>
						</div>						
						
						<div class="form-group requested">
							<label class="col-lg-3 text-right" for="">Repeat password</label>
							<div class="col-lg-5">
								<input type="password" class="form-control" />
							</div>
						</div>
						
						<div class="row mtp20">
							<div class="col-lg-5 col-lg-offset-3">
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</div>
					</form>
				</div>

			</div>			
		</div>
	</div>
</section>
   
<?PHP include('footer.php'); ?>