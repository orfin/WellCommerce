<?PHP include('header.php'); ?>

<section id="content">
	<div class="container">
		<!-- <?php include('breadcrumbs.php'); ?> -->
		
		<ul class="breadcrumbs">
			<li>Cart</li>
		</ul>
		
		<div class="row">
			<div class="col-lg-9">
				<div class="cart">
					<div class="clearfix">
						<a href="#" class="btn btn-link light btn-lg notransform nopadding">Back to shopping</a>
						<a href="#" class="btn btn-primary btn-lg pull-right">Place an order</a>
					</div>
					<div class="alert alert-info mtp30">
						<strong>Fulfill the following conditions, and you get a discount 5%</strong><br />
						Choose payment method: Bank transfer
					</div>
					
					<div class="table-responsive">
						<table class="table products-table mbt60">
							<thead>
								<tr>
									<th class="text-center" colspan="2">Product</th>
									<th class="text-center">Price</th>
									<th class="text-center">Quantity</th>
									<th class="text-center">Value</th>
									<th></th>
								</tr>
							</thead>
							
							<tbody>
								<tr>
									<td><img src="assets/prod/prod1.jpg" /></td>
									<td><a href="product.php">New Apple TV® - black</a></td>
									<td class="text-center">
										<span class="price promo">
											<small class="block">$549.00</small>
											$499.00
										</span>
									</td>
									<td class="text-center">
										<input type="text" class="form-control" value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$499.00</strong>
										</span>
									</td>
									<td class="text-center">
										<a href="#" class="btn btn-link light btn-remove"><img src="assets/img/ico-remove.png" /></a>
									</td>
								</tr>
								
								<tr>
									<td><img src="assets/prod/prod2.jpg" /></td>
									<td><a href="product.php">Fitbit Flex Wireless Wristband - Black</a></td>
									<td class="text-center">
										<span class="price">
											$359.00
										</span>
									</td>
									<td class="text-center">
										<input type="text" class="form-control" value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$359.00</strong>
										</span>
									</td>
									<td class="text-center">
										<a href="#" class="btn btn-link btn-remove"><img src="assets/img/ico-remove.png" /></a>
									</td>
								</tr>
								
								<tr>
									<td><img src="assets/prod/prod11.jpg" /></td>
									<td><a href="product.php">Martian Notifier Smart Watch - Assorted Colors</a></td>
									<td class="text-center">
										<span class="price">
											$129.00
										</span>
									</td>
									<td class="text-center">
										<input type="text" class="form-control" value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$129.00</strong>
										</span>
									</td>
									<td class="text-center">
										<a href="#" class="btn btn-link btn-remove"><img src="assets/img/ico-remove.png" /></a>
									</td>
								</tr>
							</tbody>							
						</table>	
					</div>
					
					<div class="methods">				
						<div class="row mbt60">
							<div class="col-lg-7">
								<div class="coupon">
									<h4>Coupon code</h4>
									
									<div class="form-group">
										<div class="input-group">
											<input type="text" class="form-control">
											<div class="input-group-addon"><button type="submit" class="btn btn-primary btn-sm">Accept</button></div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-5">
								<div class="row">
									<div class="col-lg-6 text-right">
										<h4><br/><br/>Discount</h4>
									</div>
									<div class="col-lg-6">
										<h4><strong><br/><br/>$0.00</strong></h4>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-7">
								<div class="row mbt30">
									<div class="col-lg-6">
										<h4>Choose country</h4>
										<div class="row">				
											<div class="col-lg-10">								
												<select class="form-control">
													<option>USA</option>
													<option>UK</option>
													<option>Australia</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<h4>Choose delivery</h4>
										
										<div class="row">				
											<div class="col-lg-10">								
												<div class="radio">
													<label class="block">
														<input type="radio" name="delivery" value="">
														On delivery <strong class="pull-right">$0.00</strong>
													</label>											
												</div>
												
												<div class="radio">	
													<label class="block">
														<input type="radio" name="delivery" value="" checked="checked">
														FedEx <strong class="pull-right">$9.00</strong>
													</label>
												</div>												
											</div>
										</div>
									</div>
								</div>
								<div class="row mbt30">
									<div class="col-lg-6">
										<h4>Choose payment</h4>

										<div class="radio">
											<label>
												<input type="radio" name="payment" value="" checked="checked">
												Bank transfer
											</label>
										</div>
										
										<div class="radio">	
											<label>
												<input type="radio" name="payment" value="">
												PayPal
											</label>											
										</div>
									</div>
								</div>
							</div>	
							
							<div class="col-lg-5">
								<div class="row">
									<div class="col-lg-6 text-right">
										<h4><br/><br/>Cost of delivery</h4>
									</div>
									<div class="col-lg-6">
										<h4><strong><br/><br/>$9.00</strong></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="summary mbt60">
						<div class="row">
							<div class="col-lg-10 col-lg-offset-2">
								<div class="col-lg-9 text-right">
									<span class="text">Summary<small>Payment method: bank transfer</small></span>
								</div>
								<div class="col-lg-3">
									<span class="value">$2125.00</span>
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix">
						<a href="#" class="btn btn-link light btn-lg notransform nopadding">Back to shopping</a>
						<a href="#" class="btn btn-primary btn-lg pull-right">Place an order</a>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<?php include('verticalpromotions.php'); ?>
				<div class="mtp60 mbt60"></div>
				<?PHP include('sidebarcontact.php'); ?>				
			</div>
		</div>
	</div>
</section>

<?PHP include('footer.php'); ?>