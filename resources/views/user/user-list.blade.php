@extends("template.admin")
@section("body")
	<!-- CONTENT WRAPPER -->
	<div style="padding-left:320px">
		<div class="ec-content-wrapper">
			<div class="content">
				<div class="breadcrumb-wrapper breadcrumb-contacts">
					<div>
						<h1>User list</h1>
						<p class="breadcrumbs"><span><a href="index.html">Admin</a></span>
							<span><i class="mdi mdi-chevron-right"></i></span>> User > User list
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12">
						<div class="ec-cat-list card card-default">
							<div class="card-body">
								<div class="table-responsive">
									<table id="responsive-data-table" class="table">
										<div class="d-flex justify-content-end mb-3">
											<button class="btn btn-primary" data-bs-toggle="modal"
												data-bs-target="#addUserModal">Thêm Người Dùng</button>
										</div>

										<!-- Add User Modal -->
										<div class="modal fade" id="addUserModal" tabindex="-1"
											aria-labelledby="addUserModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<form method="POST" action="{{ route('user.store') }}">
														@csrf
														<div class="modal-header">
															<h5 class="modal-title" id="addUserModalLabel">Thêm
																Người Dùng</h5>
															<button type="button" class="btn-close" data-bs-dismiss="modal"
																aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<div class="mb-3">
																<label for="name" class="form-label">Họ và
																	Tên</label>
																<input type="text" class="form-control" id="name"
																	name="name" required>
															</div>
															<div class="mb-3">
																<label for="email_address" class="form-label">Email</label>
																<input type="text" class="form-control" id="email_address"
																	name="email_address" required>
															</div>
															<div class="mb-3">
																<label for="phone_number" class="form-label">Phone</label>
																<input type="text" class="form-control" id="phone_number"
																	name="phone_number" required>
															</div>
															<div class="mb-3">
																<label for="password" class="form-label">Mật
																	Khẩu</label>
																<input type="password" class="form-control" id="password"
																	name="password" required>
															</div>
															<div class="mb-3">
																<label for="password_confirmation" class="form-label">Xác
																	nhận mật khẩu</label>
																<input type="password" class="form-control"
																	id="password_confirmation" name="password_confirmation"
																	required>
															</div>

														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary"
																data-bs-dismiss="modal">Đóng</button>
															<button type="submit" class="btn btn-primary">Thêm</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- Add User Modal End -->

										<!-- Edit User Modal -->
										@foreach ($users as $user)
											<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
												aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<form method="POST" action="{{ route('user.update', $user->id) }}">
															@csrf
															@method('PUT')
															<input type="hidden" name="updated_at" value="{{ $user->updated_at }}">
															<div class="modal-header">
																<h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">
																	Chỉnh Sửa
																	Người Dùng</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal"
																	aria-label="Close"></button>
															</div>
															<div class="modal-body">
																<div class="mb-3">
																	<label for="name{{ $user->id }}" class="form-label">Họ và
																		Tên</label>
																	<input type="text" class="form-control"
																		id="name{{ $user->id }}" name="name"
																		value="{{ $user->name }}" required>
																</div>
																<div class="mb-3">
																	<label for="email_address{{ $user->id }}"
																		class="form-label">Email</label>
																	<input type="email" class="form-control"
																		id="email_address{{ $user->id }}" name="email_address"
																		value="{{ $user->email_address }}" required>
																</div>

																<div class="mb-3">
																	<label for="phone_number{{ $user->id }}"
																		class="form-label">Phone number</label>
																	<input type="text" class="form-control"
																		id="phone_number{{ $user->id }}" name="phone_number"
																		value="{{ $user->phone_number }}" required>
																</div>

																<div class="mb-3">
																	<label for="password{{ $user->id }}" class="form-label">Mật
																		Khẩu </label>
																	<input type="password" class="form-control"
																		id="password{{ $user->id }}" name="password">
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary"
																	data-bs-dismiss="modal">Đóng</button>
																<button type="submit" class="btn btn-primary">Cập
																	Nhật</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										@endforeach
										<!-- Edit User Modal End -->

										@if(session('success'))
											<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
												{{ session('success') }}
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
										@endif

										@if(session('error'))
											<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
												{{ session('error') }}
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
										@endif

										<thead>
											<tr>
												<th>ID</th>
												<!-- <th>Photo</th> -->
												<th>Full name</th>
												<th>Email</th>
												<th>Phone number</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>

										<tbody>
											@foreach ($users as $user)
												<tr>
													<td>{{ $user->id }}</td>
													<td>{{ $user->name }}</td>
													<td>{{ $user->email_address }}</td>
													<td>{{ $user->phone_number }}</td>
													<td><span class="badge badge-success">Active</span></td>
													<td>
														<div class="btn-group">
															<!-- <button type="button" class="btn btn-outline-success">Info</button> -->
															<button type="button"
																class="btn btn-outline-success dropdown-toggle dropdown-toggle-split"
																data-bs-toggle="dropdown" aria-haspopup="true"
																aria-expanded="false" data-display="static">
																<span class="sr-only">Info</span>
															</button>
															<div class="dropdown-menu">
																<button class="dropdown-item" data-bs-toggle="modal"
																	data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
																<form action="{{ route('user.destroy', $user->id) }}"
																	method="POST"
																	onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng có ID = {{ $user->id }} này?');">
																	@csrf
																	@method('DELETE')
																	<button type="submit"
																		class="dropdown-item text-danger">Delete</button>
																</form>
															</div>
														</div>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<div class="d-flex justify-content-center mt-4">
										{{ $users->links('pagination::bootstrap-5') }}
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End Content -->
		</div>
		<!-- End Content Wrapper -->
	</div>
@endsection
