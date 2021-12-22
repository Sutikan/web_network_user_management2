<?php
	@session_start();
	include 'connect.php';
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];

	if (!isset($_SESSION['id'])) {
		echo "<script>window.location.href='index.php'</script>";
	} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CTC NETWORK</title>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.6.1-dist/css/bootstrap.css">
	<script type="text/javascript" src="jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.6.1-dist/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #eaeaea;">

<div class="container-fluid h-100">
	<div class="row h-100">
		
		<div class="col-auto col-sm-auto col-md-auto bg-dark d-none d-md-block"><?php include 'admin_menu.php'; ?></div>

		<div class="col col-sm col-md" style="padding: 0;">
			<?php include 'admin_Tmenu.php'; ?>

			<div class="card border-0 mt-3 mx-3">
				<div class="card-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col border-right">
								<h2 class="font-weight-bold text-warning">Welcome <small class="text-secondary"><?php echo $username; ?></small></h2>
								<small>Welcome back, We have many user wait for appove</small>
							</div>
							<div class="col">
								<div class="nav nav-pills nav-justified mt-3">
									<a href="#appove" class="nav-link font-weight-bold active" data-toggle="pill">Approval</a>
									<a href="#suspend" class="nav-link font-weight-bold" data-toggle="pill">Suspended</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0 mt-3 mx-3">
				<div class="card-body">
					<div class="tab-content">

						<div class="tab-pane fade active show" id="appove">
							<h4 class="font-weight-bold text-secondary">Approve Users</h4>
							<hr>
							<div class="table-responsive">
								<table class="table table-bordered text-center">
									<thead style="background-color: #eaeaea;">
										<th>ID</th>
										<th>Username</th>
										<th>Name</th>
										<th>Lastname</th>
										<th>Manage</th>
									</thead>
									<tbody>
										<?php
										$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND radcheck.username != '$username' AND attribute != 'Cleartext-Password'");
										while ($show = mysqli_fetch_assoc($showdata)) { ?>
											<tr>
												<td><?php echo $show['id']; ?></td>
												<td><?php echo $show['username']; ?></td>
												<td><?php echo $show['m_name']; ?></td>
												<td><?php echo $show['m_lastname']; ?></td>
												<td><button class="btn btn-sm btn-block btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#appove<?php echo $show['id'] ?>">Approve</button></td>
											</tr>
											<div class="modal fade" id="appove<?php echo $show['id'] ?>">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<form method="post">
															<div class="modal-body">
																<button class="close" data-dismiss="modal" type="button">&times;</button>
																<div class="my-4 mx-3 flex-column">
																	<h6>Are you sure, want to approve this user? <small>Please check</small></h6>
																	<hr>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Username</span>
																		</div>
																		<div class="col">
																			<input type="text" name="s_username" class="form-control rounded-0 mb-2" placeholder="Username" value="<?php echo $show['username'] ?>" required disabled>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Name</span>
																		</div>
																		<div class="col">
																			<div class="input-group">
																				<input type="text" name="s_name" class="form-control rounded-0 mb-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required disabled>
																				<input type="text" name="s_lastname" class="form-control rounded-0 mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required disabled>
																			</div>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">group</span>
																		</div>
																		<div class="col">
																			<select class="form-control rounded-0" name="app_group">
																				<option value="Defult">Defult</option>
																				<?php
																				$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																				while ($group = mysqli_fetch_assoc($loopgroup)) { ?>
																					<option value="<?php echo $group['groupname'] ?>"><?php echo $group['groupname'] ?></option>
																				<?php	}	?>
																			</select>
																		</div>
																	</div>
																</div>
																<div class="text-right">
																	<input type="hidden" name="app_username" value="<?php echo $show['username'] ?>">
																	<button class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal" type="button">Cancel</button>
																	<button class="btn btn-sm btn-warning font-weight-bold" type="submit" name="btn_appove">Approve</button>
																</div>
															</div>
														</form>
														<?php
															if (isset($_POST['btn_appove'])) {
																$app_username = $_POST['app_username'];
																$app_group = $_POST['app_group'];

																$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Cleartext-Password' WHERE username = '$app_username'");
																if ($app_group === 'Defult') {
																	echo "<script>alert('Approval successful')</script>";
																	echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																} else {
																	$checkUinG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$app_username'");
																	$countUinG = mysqli_num_rows($checkUinG);
																	if ($countUinG !== 1) {
																		$addUinG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$app_username', '$app_group', '1')");
																		echo "<script>alert('Approval successful')</script>";
																		echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																	}
																}
															}
														?>
													</div>
												</div>
											</div>
										<?php	}	?>
									</tbody>
								</table>
							</div>
						</div>

						<div class="tab-pane fade" id="suspend">
							<h4 class="font-weight-bold text-secondary">Suspend Users</h4>
							<hr>
							<div class="table-responsive">
								<table class="table table-bordered text-center">
									<thead style="background-color: #eaeaea;">
										<th>ID</th>
										<th>Username</th>
										<th>Name</th>
										<th>Lastname</th>
										<th>Group</th>
										<th>Manage</th>
									</thead>
									<tbody>
										<?php
										$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND radcheck.username != '$username' AND attribute = 'Cleartext-Password'");
										while ($show = mysqli_fetch_assoc($showdata)) {
										$show_username = $show['username']; ?>
											<tr>
												<td><?php echo $show['id']; ?></td>
												<td><?php echo $show_username; ?></td>
												<td><?php echo $show['m_name']; ?></td>
												<td><?php echo $show['m_lastname']; ?></td>
												<td><?php 
													$showgroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
													$showG = mysqli_fetch_assoc($showgroup);
													$countSgroup = mysqli_num_rows($showgroup);
													if ($countSgroup === 1) {
													 	echo $showG['groupname'];
													 } else {
													 	echo " - ";
													 } ?></td>
												<td><button class="btn btn-sm btn-block btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#sus<?php echo $show['id'] ?>">Approve</button></td>
											</tr>
											<div class="modal fade" id="sus<?php echo $show['id'] ?>">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<form method="post">
															<div class="modal-body">
																<button class="close" data-dismiss="modal" type="button">&times;</button>
																<div class="my-4 mx-3 flex-column">
																	<h6>Are you sure, want to suspend this user? <small>Please check</small></h6>
																	<hr>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Username</span>
																		</div>
																		<div class="col">
																			<input type="text" name="s_username" class="form-control rounded-0 mb-2" placeholder="Username" value="<?php echo $show['username'] ?>" required disabled>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Name</span>
																		</div>
																		<div class="col">
																			<div class="input-group">
																				<input type="text" name="s_name" class="form-control rounded-0 mb-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required disabled>
																				<input type="text" name="s_lastname" class="form-control rounded-0 mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required disabled>
																			</div>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">group</span>
																		</div>
																		<div class="col">
																			<?php if ($countSgroup === 1) { ?>
																			 	<input type="text" name="s_username" class="form-control rounded-0 mb-2" placeholder="Username" value="<?php echo $showG['groupname']; ?>" required disabled>
																			<?php } else { ?>
																			 	<input type="text" name="s_username" class="form-control rounded-0 mb-2" placeholder="Username" value=" - " required disabled>
																			<?php } ?>
																		</div>
																	</div>
																</div>
																<div class="text-right">
																	<input type="hidden" name="sus_username" value="<?php echo $show['username'] ?>">
																	<button class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal" type="button">Cancel</button>
																	<button class="btn btn-sm btn-secondary font-weight-bold" type="submit" name="btn_suspend">Suspen</button>
																</div>
															</div>
														</form>
														<?php
															if (isset($_POST['btn_suspend'])) {
																$sus_username = $_POST['sus_username'];

																$suspendUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Password' WHERE username = '$sus_username'");
																echo "<script>alert('Suspended successful')</script>";
																echo "<script>window.location.href='admin_index.php?id=$id'</script>";
															}
														?>
													</div>
												</div>
											</div>
										<?php	}	?>
									</tbody>
								</table>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

	</div>
</div>
	
</body>
</html>

<?php } ?>