@extends("template.admin")
@section("body")
	<!-- CONTENT WRAPPER -->
	<div style="padding-left:320px">
		<div class="page-body-wrapper">

			<div class="page-body">
				<!-- Container-fluid starts-->
				<div class="container-fluid">
					<div class="page-header">
						<div class="row">
							<div class="col-lg-6">
								<div class="page-header-left">
									<h3>Infomaton User ID {{ $user->id }}</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Container-fluid Ends-->

				<!-- Container-fluid starts-->
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="card tab2-card">
								<div class="card-body">
									<ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
										<li class="nav-item"><a class="nav-link active show" id="account-tab"
												data-bs-toggle="tab" href="#account" role="tab" aria-controls="account"
												aria-selected="true" data-original-title="" title="">Account</a>
										</li>
									</ul>
									<div class="tab-content" id="myTabContent">
										<div class="tab-pane fade active show" id="account" role="tabpanel"
											aria-labelledby="account-tab">
											
											<form id="updateUserForm" method="POST"
												action="{{ route('user.update', $user->id) }}">
												@csrf
												@method('PUT')
												<h4>Account Details</h4>
												<input type="hidden" name="updated_at"
																	value="{{ $user->updated_at }}">
												<div class="form-group row">
													<label for="validationCustom0" class="col-xl-3 col-md-4">Name</label>
													<div class="col-xl-8 col-md-7">
														<input type="text" class="form-control" id="name{{ $user->id }}"
															name="name" value="{{ $user->name }}" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="validationCustom1" class="col-xl-3 col-md-4">Email
														address</label>
													<div class="col-xl-8 col-md-7">
														<input type="email" class="form-control"
															id="email_address{{ $user->id }}" name="email_address"
															value="{{ $user->email_address }}" required>
													</div>
												</div>
												<div class="form-group row">
													<label for="validationCustom2" class="col-xl-3 col-md-4">Phone
														number</label>
													<div class="col-xl-8 col-md-7">
														<input type="text" class="form-control"
															id="phone_number{{ $user->id }}" name="phone_number"
															value="{{ $user->phone_number }}" required>
													</div>
												</div>
												<!-- <div class="form-group row">
													<label for="validationCustom3" class="col-xl-3 col-md-4">Updated
														at</label>
													<div class="col-xl-8 col-md-7">
														<input type="text" class="form-control"
															id="updated_at{{ $user->id }}" name="updated_at"
															value="{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}"
															readonly>
													</div>
												</div> -->
												<div class="form-group row">
													<label for="validationCustom3" class="col-xl-3 col-md-4">Mật
														khẩu</label>
													<div class="col-xl-8 col-md-7">
														<input type="password" class="form-control"
															id="password{{ $user->id }}" name="password">
													</div>
												</div>
												<div class="pull-right">
													<button type="submit" class="btn btn-primary">Save</button>
												</div>
											</form>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Container-fluid Ends-->
			</div>

			<!-- footer start-->
			<footer class="footer">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6 footer-copyright text-start">
							<p class="mb-0">Copyright 2024 © Multikart All rights reserved.</p>
						</div>
						<div class="col-md-6 pull-right text-end">
							<p class=" mb-0">Hand crafted & made with<i class="ri-heart-line"></i></p>
						</div>
					</div>
				</div>
			</footer>
			<!-- footer end-->
		</div>
	</div>
	</div>
@endsection

