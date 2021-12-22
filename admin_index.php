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
			
			<div class="col-auto col-sm-auto col-md-auto bg-dark d-none d-md-block"><?php include 'admin_menu.php'; ?></div>
			<div class="col col-sm col-md" style="padding: 0;">
				<?php include 'admin_Tmenu.php'; ?>

				<div class="container-fluid">

					<div class="card border-0 mt-3">
						<div class="card-body">
							<div class="container-fluid">
								<div class="row">
									<div class="col border-right">
										<h3 class="text-warning">Welcome <small class="text-secondary"><?php echo $username ?></small></h3>
										<small>We have many user for approve</small>
									</div>
									<div class="col">
										<div class="nav nav-pills nav-justified mt-2">
											 <a href="#suspend" class="nav-link font-weight-bold active" data-toggle="pill">Suspended</a>
											 <a href="#approve" class="nav-link font-weight-bold" data-toggle="pill">Approved</a>
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

									<div class="tab-pane fade active show" id="suspend">
										<h4 class="font-weight-bold">Suspended Users <small class="font-weight-light">They wait for approve</small></h4>
										<hr>
										<div class="table-responsive">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Approval</th>
													<th>Manage</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute != 'Cleartext-Password' AND radcheck.username!='$username'");
														while ($show = mysqli_fetch_assoc($showdata)) { ?>
															<tr>
																<td><?php echo $show['id']; ?></td>
																<td><?php echo $show['username']; ?></td>
																<td><?php echo $show['m_name']; ?></td>
																<td><?php echo $show['m_lastname']; ?></td>
																<td><button class="btn btn-sm btn-block btn-info font-weight-bold" type="button" data-toggle="modal" data-target="#approve<?php echo $show['id'] ?>">Approve</button></td>
																<td><div class="btn-group btn-group-sm btn-block">
																	<button class="btn btn-sm btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#edit<?php echo $show['id'] ?>">Edit</button>
																	<button class="btn btn-sm btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#del<?php echo $show['id'] ?>">Delete</button>
																</div></td>
															</tr>
															<div class="modal fade" id="approve<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to approve this user? <small>Please Check</small></span>
																					<hr>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Username</span>
																						</div>
																						<div class="col">
																							<input type="text" value="<?php echo $show['username'] ?>" class="form-control rounded-0" disabled>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Name</span>
																						</div>
																						<div class="col">
																							<div class="input-group">
																								<input type="text" value="<?php echo $show['m_name'] ?>" class="form-control rounded-0" disabled>
																								<input type="text" value="<?php echo $show['m_lastname'] ?>" class="form-control rounded-0" disabled>
																							</div>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Group</span>
																						</div>
																						<div class="col">
																							<select class="form-control rounded-0" id="app_group">
																								<option value="Defualt">Defualt</option>
																								<?php
																								$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																								while ($loopG = mysqli_fetch_assoc($loopgroup)) { ?>
																									<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
																								<?php	}	?>
																							</select>
																						</div>
																					</div>
																					<div class="text-right mt-3">
																						<input type="hidden" name="app_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-info font-weight-bold" type="submit" name="app_rove">Approve</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['app_rove'])) {
																				$app_username = $_POST['app_username'];
																				$app_group = $_POST['app_group'];

																				$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Cleartext-Password' WHERE username = '$app_username'");
																				if ($app_group === 'Defualt') {
																					echo "<script>alert('Approval successful!')</script>";
																					echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																				} else {
																					$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$app_username'");
																					$checkUIG = mysqli_num_rows($checkUG);
																					if ($checkUIG !== 1) {
																						$addUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$app_username', '$app_group', '1')");
																						echo "<script>alert('Approval successful!')</script>";
																						echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																					}
																				}
																			}
																		?>
																	</div>
																</div>
															</div>
															<div class="modal fade" id="edit<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to edit this user? <small>Please Check</small></span>
																					<hr>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Username</span>
																						</div>
																						<div class="col">
																							<input type="text" value="<?php echo $show['username'] ?>" class="form-control rounded-0" disabled>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Name</span>
																						</div>
																						<div class="col">
																							<div class="input-group">
																								<input type="text" value="<?php echo $show['m_name'] ?>" class="form-control rounded-0" name="up_name" placeholder="Name" required>
																								<input type="text" value="<?php echo $show['m_lastname'] ?>" class="form-control rounded-0" name="up_lastname" placeholder="Lastname" required>
																							</div>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Group</span>
																						</div>
																						<div class="col">
																							<select class="form-control rounded-0" name="up_group">
																								<option value="Defualt">Defualt</option>
																								<?php
																								$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																								while ($loopG = mysqli_fetch_assoc($loopgroup)) { ?>
																									<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
																								<?php	}	?>
																							</select>
																						</div>
																					</div>
																					<div class="text-right mt-3">
																						<input type="hidden" name="up_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-warning font-weight-bold" type="submit" name="Up_date">Update</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['Up_date'])) {
																				$up_username = $_POST['up_username'];
																				$up_name = $_POST['up_name'];
																				$up_lastname = $_POST['up_lastname'];
																				$up_group = $_POST['up_group'];

																				$upUser = mysqli_query($con, "UPDATE member SET m_name = '$up_name', m_lastname = '$up_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$up_username'");
																				if ($up_group === 'Defualt') {
																					echo "<script>alert('Update user successful!')</script>";
																					echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																				} else {
																					$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$up_username'");
																					$checkUIG = mysqli_num_rows($checkUG);
																					if ($checkUIG === 1) {
																						$upUIG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$up_group' WHERE username = '$up_username'");
																						echo "<script>alert('Update user successful!')</script>";
																						echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																					} else {
																						$addUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$up_username', '$up_group', '1')");
																						echo "<script>alert('Update user successful!')</script>";
																						echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																					}
																				}
																			}
																		?>
																	</div>
																</div>
															</div>
															<div class="modal fade" id="del<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to delete <span class="font-weight-bold"><?php echo $show['username']; ?></span>?</span>
																					<div class="text-right mt-3">
																						<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-danger font-weight-bold" type="submit" name="del_ete">Delete</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['del_ete'])) {
																				$del_username = $_POST['del_username'];

																				$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$del_username'");
																				echo "<script>alert('Delete user successful!')</script>";
																				echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																			}
																		?>
																	</div>
																</div>
															</div>
													<?php	} ?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="tab-pane fade" id="approve">
										<h4 class="font-weight-bold">Approved Users <small class="font-weight-light">Who do you will suspend</small></h4>
										<hr>
										<div class="table-responsive">
											<table class="table table-bordered text-center">
												<thead class="table-secondary">
													<th>ID</th>
													<th>Username</th>
													<th>Name</th>
													<th>Lastname</th>
													<th>Group</th>
													<th>Approval</th>
													<th>Manage</th>
												</thead>
												<tbody>
													<?php
														$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND attribute = 'Cleartext-Password' AND radcheck.username!='$username'");
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
																<td><button class="btn btn-sm btn-block btn-dark font-weight-bold" type="button" data-toggle="modal" data-target="#suspend<?php echo $show['id'] ?>">Suspend</button></td>
																<td><div class="btn-group btn-group-sm btn-block">
																	<button class="btn btn-sm btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#edit<?php echo $show['id'] ?>">Edit</button>
																	<button class="btn btn-sm btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#del<?php echo $show['id'] ?>">Delete</button>
																</div></td>
															</tr>
															<div class="modal fade" id="suspend<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to suspend this user? <small>Please Check</small></span>
																					<hr>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Username</span>
																						</div>
																						<div class="col">
																							<input type="text" value="<?php echo $show['username'] ?>" class="form-control rounded-0" disabled>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Name</span>
																						</div>
																						<div class="col">
																							<div class="input-group">
																								<input type="text" value="<?php echo $show['m_name'] ?>" class="form-control rounded-0" disabled>
																								<input type="text" value="<?php echo $show['m_lastname'] ?>" class="form-control rounded-0" disabled>
																							</div>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Group</span>
																						</div>
																						<div class="col">
																							<select class="form-control rounded-0" disabled>
																								<?php
																								if ($showG) {
																								 ?>
																									<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
																								<?php	}	?>
																								<option value="Defualt">Defualt</option>
																							</select>
																						</div>
																					</div>
																					<div class="text-right mt-3">
																						<input type="hidden" name="sus_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-dark font-weight-bold" type="submit" name="sus_pend">Suspend</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['sus_pend'])) {
																				$sus_username = $_POST['sus_username'];

																				$approveUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Password' WHERE username = '$sus_username'");
																				echo "<script>alert('Suspended successful!')</script>";
																				echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																			}
																		?>
																	</div>
																</div>
															</div>
															<div class="modal fade" id="edit<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to edit this user? <small>Please Check</small></span>
																					<hr>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Username</span>
																						</div>
																						<div class="col">
																							<input type="text" value="<?php echo $show['username'] ?>" class="form-control rounded-0" disabled>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Name</span>
																						</div>
																						<div class="col">
																							<div class="input-group">
																								<input type="text" value="<?php echo $show['m_name'] ?>" class="form-control rounded-0" name="up_name" placeholder="Name" required>
																								<input type="text" value="<?php echo $show['m_lastname'] ?>" class="form-control rounded-0" name="up_lastname" placeholder="Lastname" required>
																							</div>
																						</div>
																					</div>
																					<div class="form-row mb-3">
																						<div class="col-3">
																							<span class="text-secondary font-weight-bold form-text">Group</span>
																						</div>
																						<div class="col">
																							<select class="form-control rounded-0" id="up_group">
																								<option value="Defualt">Defualt</option>
																								<?php
																								$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																								while ($loopG = mysqli_fetch_assoc($loopgroup)) { ?>
																									<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
																								<?php	}	?>
																							</select>
																						</div>
																					</div>
																					<div class="text-right mt-3">
																						<input type="hidden" name="up_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-warning font-weight-bold" type="submit" name="Up_date">Update</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['Up_date'])) {
																				$up_username = $_POST['up_username'];
																				$up_name = $_POST['up_name'];
																				$up_lastname = $_POST['up_lastname'];
																				$up_group = $_POST['up_group'];

																				$upUser = mysqli_query($con, "UPDATE member SET m_name = '$up_name', m_lastname = '$up_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$up_username'");
																				if ($up_group === 'Defualt') {
																					echo "<script>alert('Update user successful!')</script>";
																					echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																				} else {
																					$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$up_username'");
																					$checkUIG = mysqli_num_rows($checkUG);
																					if ($checkUIG === 1) {
																						$upUIG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$up_group' WHERE username = '$up_username'");
																						echo "<script>alert('Update user successful!')</script>";
																						echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																					} else {
																						$addUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$up_username', '$up_group', '1')");
																						echo "<script>alert('Update user successful!')</script>";
																						echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																					}
																				}
																			}
																		?>
																	</div>
																</div>
															</div>
															<div class="modal fade" id="del<?php echo $show['id'] ?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<form method="post">
																			<div class="modal-body">
																				<button class="close" data-dismiss="modal" type="button">&times;</button><br>
																				<div class="m-2">
																					<span>Do you want to delete <span class="font-weight-bold"><?php echo $show['username']; ?></span>?</span>
																					<div class="text-right mt-3">
																						<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																						<button class="btn btn-sm btn-light" data-dismiss="modal" type="button">Cancel</button>
																						<button class="btn btn-sm btn-danger font-weight-bold" type="submit" name="del_ete">Delete</button>
																					</div>
																				</div>
																			</div>
																		</form>
																		<?php
																			if (isset($_POST['del_ete'])) {
																				$del_username = $_POST['del_username'];

																				$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radacct WHERE username = '$del_username'");
																				$delUser = mysqli_query($con, "DELETE FROM radpostauth WHERE username = '$del_username'");
																				echo "<script>alert('Delete user successful!')</script>";
																				echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																			}
																		?>
																	</div>
																</div>
															</div>
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