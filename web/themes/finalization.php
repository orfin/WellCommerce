<?PHP include('header_checkout.php'); ?>

<section id="content">
	<div class="container">
		<!-- <?php include('breadcrumbs.php'); ?> -->
		
		<ul class="breadcrumbs">
			<li>Step 2. Finalization</li>
			<li><a href="category.php">Checkout</a></li>
		</ul>
		
		<div class="row">
			<div class="col-lg-9">
				<div class="cart">
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
										<input type="text" class="form-control" disabled value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$499.00</strong>
										</span>
									</td>
									<td class="text-center"></td>
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
										<input type="text" class="form-control" disabled value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$359.00</strong>
										</span>
									</td>
									<td class="text-center"></td>
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
										<input type="text" class="form-control" disabled value="1" />
									</td>
									<td class="text-center">
										<span class="price">
											<strong>$129.00</strong>
										</span>
									</td>
									<td class="text-center"></td>
								</tr>
							</tbody>							
						</table>	
					</div>
					
					<div class="methods">				
						<div class="row mbt60">
							<div class="col-lg-5">
								<div class="order-details">
									<h4 class="mbt20">Shipping and payment method</h4>
									
									<table class="table">
										<tbody>
											<tr>
												<td>Shipping</td>
												<td>FedEx</td>
											</tr>
											
											<tr>
												<td>Payment</td>
												<td>Bank Transfer</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="col-lg-5 col-lg-offset-2">
								<div class="row">
									<div class="col-lg-6 text-right">
										<h4><br/><br/><br/>Cost of delivery</h4>
									</div>
									<div class="col-lg-6">
										<h4><strong><br/><br/><br/>$9.00</strong></h4>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row mbt60">
							<div class="col-lg-12">
								<div class="client-details">
									<div class="row">
										<div class="col-lg-4">
											<h4>Delivery address <a data-toggle="modal" href="#address-change">Change</a></h4>
											
											<p>
												Tony Stark<br />
												W. Nelson 5123<br />
												67219 Chicago, Il<br />
												USA
											</p>
										</div>		
										<div class="col-lg-4">
											<h4>Contact info <a data-toggle="modal" href="#address-change">Change</a></h4>
											
											<p>
												tony.stark@stark-ind.com<br />
												+01 773 445 9886
											</p>
										</div>		
										<div class="col-lg-4">
											<h4>Billing data <a data-toggle="modal" href="#address-change">Change</a></h4>
											
											<p>
												Tony Stark<br />
												W. Nelson 5123<br />
												67219 Chicago, Il<br />
												USA
											</p>
										</div>		
									</div>
								</div>
							</div>
						</div>
						
						<div class="row mbt60">
							<div class="col-lg-12">
								<h4>Your comment to this order</h4>
								
								<textarea class="form-control" rows="5"></textarea>
							</div>
						</div>
						
					</div>
					
					<div class="summary mbt60">
						<div class="row">
							<div class="col-lg-10 col-lg-offset-2">
								<div class="col-lg-9 text-right">
									<span class="text">Summary</span>
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
				<?PHP include('sidebarcontact.php'); ?>				
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="address-change">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Change address</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">First name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">Last name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">Company name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">Street name</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">	
						<div class="form-group">
							<label class="control-label required">Place No.</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">	
						<div class="form-group">
							<label class="control-label">Apartment No.</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">City</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">	
						<div class="form-group">
							<label class="control-label required">Zip code</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">	
						<div class="form-group">
							<label class="control-label required">Country</label>
							<select class="form-control">
								<option>Poland</option>
								<option>United Kingdom</option>
								<option>France</option>
								<option>Germany</option>
								<option>United States</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<?PHP include('footer.php'); ?>