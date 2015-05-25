<?PHP include('header.php'); ?>

<section id="content" class="contact-wrap">
	<div class="container">
<!-- 		<?php include('breadcrumbs.php'); ?> -->
		
		<ul class="breadcrumbs">
			<li>Contact</li>
			<li><a href="index.php">Home page</a></li>
		</ul>

		
		<div class="row">
			<div class="col-lg-6 col-lg-offset-2">
				<div class="well-form">					
					<h4>Contact form<small>*Requested fields</small></h4>
					
					<div class="alert alert-success">
						<strong>Your message was successfully sent.</strong><br />
						Customer support will soon respond to your message.
					</div>
					
					<form>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group requested">
									<label for="login">First name</label>
									<input type="text" class="form-control" />
								</div>		
							</div>
							
							<div class="col-lg-6">
								<div class="form-group requested">
									<label for="login">Last name</label>
									<input type="text" class="form-control" />
								</div>		
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group requested">
									<label for="login">E-mail</label>
									<input type="text" class="form-control" />
								</div>		
							</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label for="login">Phone number</label>
									<input type="text" class="form-control" />
								</div>		
							</div>
						</div>

						
						<div class="form-group requested">
							<label for="login">Topic</label>
							<input type="text" class="form-control" />
						</div>
												
						<div class="form-group requested">
							<label for="login">Message</label>
							<textarea class="form-control" rows="5"></textarea>
						</div>
						
						<div class="clearfix">
							<button type="submit" class="btn btn-primary pull-right">Send message</button>
						</div>
					</form>
				</div>
			</div>			
			
			<div class="col-lg-3">
				<div class="well-form">
					<address>
						<h4>WellCommerce, Inc.</h4>
						795 Folsom Ave, Suite 600<br>
						San Francisco, CA 94107<br>
						+01 (123) 456-7890
					</address>

					<address>
						<strong>Customer Service</strong><br>
						795 Folsom Ave, Suite 600<br>
						San Francisco, CA 94107<br>
						+01 (123) 456-7890
					</address>

					<address>
						<strong>Returns & warranty</strong><br>
						795 Folsom Ave, Suite 600<br>
						San Francisco, CA 94107<br>
						+01 (123) 456-7890
					</address>

				</div>
			</div>
		</div>
	</div>
</section>
   
<?PHP include('footer.php'); ?>