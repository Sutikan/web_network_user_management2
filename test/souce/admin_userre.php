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
							<h4 class="font-weight-bold text-secondary">Users Report</h4>
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
												<td>
													<button class="btn btn-sm px-3 btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#edit<?php echo $show['id'] ?>">Update</button>
													<button class="btn btn-sm px-3 btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#del<?php echo $show['id'] ?>">Delete</button>
												</td>
											</tr>
											<div class="modal fade" id="edit<?php echo $show['id'] ?>">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">
														<form method="post">
															<div class="modal-body">
																<button class="close" data-dismiss="modal" type="button">&times;</button>
																<div class="my-4 mx-3 flex-column">
																	<h6>Are you sure, want to update this user? <small>Please check</small></h6>
																	<hr>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Username</span>
																		</div>
																		<div class="col">
																			<input type="text" class="form-control rounded-0 mb-2" placeholder="Username" value="<?php echo $show['username'] ?>" required disabled>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">Name</span>
																		</div>
																		<div class="col">
																			<div class="input-group">
																				<input type="text" name="uup_name" class="form-control rounded-0 mb-2" placeholder="Name" value="<?php echo $show['m_name'] ?>" required>
																				<input type="text" name="uup_lastname" class="form-control rounded-0 mb-2" placeholder="Lastname" value="<?php echo $show['m_lastname'] ?>" required>
																			</div>
																		</div>
																	</div>
																	<div class="form-row">
																		<div class="col-3">
																			<span class="text-secondary font-weight-bold form-text">group</span>
																		</div>
																		<div class="col">
																			<select class="form-control rounded-0" name="uup_group">
																				<?php
																					if ($countSgroup === 1) { ?>
																						<option value="<?php echo $showG['groupname'] ?>"><?php echo $showG['groupname'] ?></option>
																					<?php } ?>
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
																	<input type="hidden" name="uup_username" value="<?php echo $show['username'] ?>">
																	<button class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal" type="button">Cancel</button>
																	<button class="btn btn-sm btn-warning font-weight-bold" type="submit" name="btn_up">Update</button>
																</div>
															</div>
														</form>
														<?php
															if (isset($_POST['btn_up'])) {
																$uup_username = $_POST['uup_username'];
																$uup_name = $_POST['uup_name'];
																$uup_lastname = $_POST['uup_lastname'];
																$uup_group = $_POST['uup_group'];

																$upUser = mysqli_query($con, "UPDATE member SET m_name = '$uup_name', m_lastname = '$uup_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$uup_username'");
																if ($uup_group === 'Defult') {
																	echo "<script>alert('Update user successful')</script>";
																	echo "<script>window.location.href='admin_userre.php?id=$id'</script>";
																} else {
																	$checkUinG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$uup_username'");
																	$countUinG = mysqli_num_rows($checkUinG);
																	if ($countUinG === 1) {
																		$addUinG = mysqli_query($con, "UPDATE radusergroup SET groupname = '$uup_group' WHERE username = '$uup_username'");
																		echo "<script>alert('Update user successful')</script>";
																		echo "<script>window.location.href='admin_userre.php?id=$id'</script>";
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
																<button class="close" data-dismiss="modal" type="button">&times;</button>
																<div class="mb-3 mt-4 mx-3 d-flex flex-column">
																	<span class="mb-4">Are you sure, you want to delete users?</span>
																	<div class="text-right">
																		<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																		<button class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal" type="button">Cancel</button>
																		<button class="btn btn-sm btn-danger font-weight-bold" type="submit" name="del_user">Delete</button>
																	</div>
																</div>
															</div>
														</form>
														<?php
															if (isset($_POST['del_user'])) {
																$del_user = $_POST['del_user'];

																$delUser = mysqli_query($con, "DELETE FROM radcheck");
																echo "<script>window.location.href='index.php'</script>";
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
	
</body>
</html>

<?php } ?>