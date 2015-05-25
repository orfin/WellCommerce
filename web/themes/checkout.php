<?PHP include('header_checkout.php'); ?>

<section id="content" class="checkout-wrap">
	<div class="container">
<!-- 		<?php include('breadcrumbs.php'); ?> -->
		
		<ul class="breadcrumbs">
			<li>Step 1. Address</li>
			<li><a href="category.php">Checkout</a></li>
		</ul>

		<div class="row mtp40">
			<div class="col-lg-9">
				<div class="row">
					<div class="col-lg-5">
						<div class="well-form">
							<h3>I have an account</h3>
							
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
									<a href="#" class="btn btn-link light nopadding notransform">Forgot password</a>
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
					<div class="col-lg-7">
						<div class="well-form">
							<h3>It's my first order<small>Buy as a guest or sign up</small></h3>
							
							<h4>Order address<small>*Requested fields</small></h4>
							
							<form>
								<div class="form-group" id="client-type">
									<label class="block">Client type</label>
									
									<label class="radio-inline">
										<input type="radio" name="clientType" value="1" checked="checked">
										Person
									</label>
							
									<label class="radio-inline">
										<input type="radio" name="clientType" value="2">
										Company
									</label>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">First name</label>
											<input type="text" class="form-control" />
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">Last name</label>
											<input type="text" class="form-control" />
										</div>
									</div>
								</div>
								
								<div id="company-wrap">
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Company name</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Tax ID</label>
												<input type="text" class="form-control" />
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">Street name</label>
											<input type="text" class="form-control" />
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group requested">
											<label for="">Building no</label>
											<input type="text" class="form-control" />
										</div>
									</div>
									
									<div class="col-lg-3">
										<div class="form-group requested">
											<label for="">Place no</label>
											<input type="text" class="form-control" />
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">City</label>
											<input type="text" class="form-control" />
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group requested">
											<label for="">Post code</label>
											<input type="text" class="form-control" />
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">Country</label>
											<select class="form-control">
												<option>USA</option>
												<option>UK</option>
												<option>Australia</option>
											</select>
										</div>
									</div>
								</div>
								
								<div class="checkbox mtp30 mbt0">
									<label>
										<input type="checkbox" id="shipping-collapse">
										Delivery address is other than billing address
									</label>
								</div>
								
								<div class="collapse" id="shipping-wrap">
									<h4>Delivery address</h4>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">First name</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Last name</label>
												<input type="text" class="form-control" />
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Street name</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group requested">
												<label for="">Building no</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										
										<div class="col-lg-3">
											<div class="form-group requested">
												<label for="">Place no</label>
												<input type="text" class="form-control" />
											</div>
										</div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">City</label>
												<input type="text" class="form-control" />
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group requested">
												<label for="">Post code</label>
												<input type="text" class="form-control" />
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Country</label>
												<select class="form-control">
													<option>USA</option>
													<option>UK</option>
													<option>Australia</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								
								<h4 class="mtp30">Contact data</h4>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">Phone</label>
											<input type="tel" class="form-control" />
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="">Additional Phone</label>
											<input type="tel" class="form-control" />
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group requested">
											<label for="">E-mail</label>
											<input type="email" class="form-control" />
										</div>
									</div>
								</div>
								
								<div class="checkbox mtp30 mbt0">
									<label>
										<input type="checkbox" id="password-collapse" checked="">
										I want to sign up
									</label>
								</div>
								
								<div class="collapse in" id="password-wrap">
									<h4>Account password</h4>
									
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group requested">
												<label for="">Password</label>
												<input type="password" class="form-control" />
											</div>
											
											<div class="form-group requested">
												<label for="">Repeat password</label>
												<input type="password" class="form-control" />
											</div>
										</div>
										
										<div class="col-lg-6">
											<div class="alert alert-sm alert-password">
												<strong>Benefits of opening an account</strong>
		
												<ul>
													<li>Current status of your shipment</li>
													<li>Discounts for regular customers</li>
												</ul>
											</div>
										</div>
									</div>
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
							</form>
						</div>				
					</div>
				</div>
				
				<div class="clearfix mtp60">
					<a href="#" class="btn btn-link light btn-lg notransform nopadding">Back to shopping</a>
					<button class="btn btn-primary btn-lg pull-right">Place an order</button>
				</div>
				
			</div>
			
			<div class="col-lg-3"><?PHP include('sidebarcontact.php'); ?></div>
		</div>
		
	</div>
</section>

<script>
$(document).ready(function(){
	$('#company-wrap').find('input').attr('tabindex', -1);
	$('#client-type').unbind('change').bind('change', function(){
		$('#company-wrap').collapse($(this).val() == 2 ? 'show' : 'hide');
		if($(this).val() == 2){
			$('#company-wrap').find('input').removeAttr('tabindex');
		}else{
			$('#company-wrap').find('input').attr('tabindex', -1);
		}
	});
	
	$('#shipping-collapse').unbind('change').bind('change', function(){
		$('#shipping-wrap').collapse($(this).is(':checked') ? 'show' : 'hide');
	});
	
	$('#password-collapse').unbind('change').bind('change', function(){
		$('#password-wrap').collapse($(this).is(':checked') ? 'show' : 'hide');
	});
});
</script>

<?PHP include('footer.php'); ?>