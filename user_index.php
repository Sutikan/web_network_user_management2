<?php
	@session_start();
	include 'connect.php';
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];

	if (!isset($_SESSION['id'])) {
		header('index.php');
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
			
			<div class="col-auto col-sm-auto col-md-auto bg-dark d-none d-md-block"><?php include 'user_menu.php'; ?></div>
			<div class="col col-sm col-md" style="padding: 0;">
				<?php include 'user_Tmenu.php'; ?>

				<div class="container-fluid">

					<div class="card border-0 mt-3">
						<div class="card-body">
							<div class="container-fluid">
								<div class="row">
									<div class="col border-right">
										<h3 class="text-warning">Welcome <small class="text-secondary"><?php echo $username ?></small></h3>
										<small>We glad to see you again, Hope you enjoy with Internet</small>
									</div>
									<div class="col">
										<div class="nav nav-pills nav-justified mt-3">
											<a href="#network" class="nav-link font-weight-bold active" data-toggle="pill">Network</a>
											<a href="#time" class="nav-link font-weight-bold" data-toggle="pill">Time</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card border-0 mt-3">
						<div class="card-body">
							<div class="container-fluid">

								<div class="tab-content">

									<div class="tab-pane fade active show" id="network">
										<h4 class="font-weight-bold">Network <small class="font-weight-light">Report</small></h4>
										<hr>
										<div class="table-responsive">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Group</th>
													<th>IP Address</th>
													<th>Start</th>
													<th>Stop</th>
													<th>Note</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member, radacct WHERE radcheck.username = member.username AND radcheck.username = radacct.username AND attribute = 'Cleartext-Password' AND radcheck.username='$username'");
														while ($show = mysqli_fetch_assoc($showdata)) { 
															$show_username = $show['username']; ?>
															<tr>
																<td><?php echo $show['id']; ?></td>
																<td><?php echo $show['username']; ?></td>
																<td><?php echo $show['m_name']; ?></td>
																<td><?php echo $show['m_lastname']; ?></td>
																<td><?php 
																	$showgroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
																	$showG = mysqli_fetch_assoc($showgroup);
																	if ($showG) {
																		echo $showG['groupname'];
																	} else {
																		echo " - ";
																	}
																 ?></td>
																<td><?php echo $show['framedipaddress']; ?></td>
																<td><?php echo $show['acctstarttime']; ?></td>
																<td><?php echo $show['acctstoptime']; ?></td>
																<td><?php echo $show['acctterminatecause']; ?></td>
															</tr>
													<?php	} ?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="tab-pane fade" id="time">
										<h4 class="font-weight-bold">Time <small class="font-weight-light">Report</small></h4>
										<hr>
										<div class="table-responsive">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Group</th>
													<th>Start</th>
													<th>Stop</th>
													<th>Update</th>
													<th>Update By</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member, radacct WHERE radcheck.username = member.username AND radcheck.username = radacct.username AND attribute = 'Cleartext-Password' AND radcheck.username='$username'");
														while ($show = mysqli_fetch_assoc($showdata)) {
														$show_username = $show['username']; ?>
															<tr>
																<td><?php echo $show['id']; ?></td>
																<td><?php echo $show['username']; ?></td>
																<td><?php echo $show['m_name']; ?></td>
																<td><?php echo $show['m_lastname']; ?></td>
																<td><?php 
																	$showgroup = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
																	$showG = mysqli_fetch_assoc($showgroup);
																	if ($showG) {
																		echo $showG['groupname'];
																	} else {
																		echo " - ";
																	}
																 ?></td>
																<td><?php echo $show['acctstarttime']; ?></td>
																<td><?php echo $show['acctstoptime']; ?></td>
																<td><?php echo $show['m_update']; ?></td>
																<td><?php echo $show['m_who']; ?></td>
															</tr>
													<?php	} ?>
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

		</div>
	</div>
	
</body>
</html>
<?php } ?>