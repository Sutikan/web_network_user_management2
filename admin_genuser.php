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
										<h4 class="font-weight-bold">Generate User</h4>
										<small>For generate only 1 user</small>
										<hr>
										<form method="post">
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Username</span>
												</div>
												<div class="col">
													<input name="g_username" type="text" class="form-control rounded-0" placeholder="Username" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Name</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input name="g_name" type="text" class="form-control rounded-0" placeholder="Name" required>
														<input name="g_lastname"  type="text"class="form-control rounded-0" placeholder="Lastame" required>
													</div>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Password</span>
												</div>
												<div class="col">
													<input name="g_pass" type="Password" class="form-control rounded-0" placeholder="Password" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Group</span>
												</div>
												<div class="col">
													<div class="input-group">
														<select class="form-control rounded-0" name="g_group">
															<option value="Defualt">Defualt</option>
															<?php
																$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																while ($loopG = mysqli_fetch_assoc($loopgroup)) { ?>
																	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
															<?php	}	?>
														</select>
													</div>
												</div>
											</div>
											<div class="text-right mt-3">
												<button class="btn btn-warning btn-sm px-5 font-weight-bold" type="submit" name="gen_user">Generate</button>
											</div>
										</form>
										<hr width="20%" class="mt-3 mb-3">
										<h4 class="font-weight-bold">Generate Users</h4>
										<small>For generate more 1 user</small>
										<hr>
										<form method="post">
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Number of users</span>
												</div>
												<div class="col">
													<input name="gen_num" class="form-control rounded-0" placeholder="Number of users" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Group</span>
												</div>
												<div class="col">
													<div class="input-group">
														<select class="form-control rounded-0" name="gen_group">
															<option value="Defualt">Defualt</option>
															<?php
																$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																while ($loopG = mysqli_fetch_assoc($loopgroup)) { ?>
																	<option value="<?php echo $loopG['groupname'] ?>"><?php echo $loopG['groupname'] ?></option>
															<?php	}	?>
														</select>
													</div>
												</div>
											</div>
											<div class="text-right mt-3">
												<button class="btn btn-secondary btn-sm px-5 font-weight-bold" type="submit" name="gen_users">Generate</button>
											</div>
										</form>
									</div>
									<div class="col">
										<?php
											if (isset($_POST['gen_user'])) {
												$g_username = $_POST['g_username'];
												$g_name = $_POST['g_name'];
												$g_lastname = $_POST['g_lastname'];
												$g_pass = $_POST['g_pass'];
												$g_group = $_POST['g_group'];

												$checkname = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($g_username)."'");
												$check = mysqli_num_rows($checkname);
												if ($check === 1) {
													echo "<script>alert('This username is already exists!')</script>";
													echo "<script>window.location.href='admin_genuser.php?id=$id'</script>";
												} else {
													$genUser = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$g_username', 'Cleartext-Password', ':=', '$g_pass')");
													$genUser = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$g_username', '$g_name', '$g_lastname')");
													if ($g_group !== 'Defualt') {
														$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$g_username'");
														$checkUIG = mysqli_num_rows($checkUIG);
														if ($checkUIG !== 1) {
															$addUIG = mysqli_query($con, "INSERT INTO (username, groupname, priority) VALUES ('$g_username', '$g_group', '1')");
														}
													}
												} ?>

												<h4 class="font-weight-bold">User</h4>
												<hr>

												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Username</span>
													</div>
													<div class="col">
														<?php echo $g_username ?>
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Name</span>
													</div>
													<div class="col">
														<?php echo $g_name ?> <?php echo $g_lastname ?>
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Group</span>
													</div>
													<div class="col">
														<?php echo $g_group ?>
													</div>
												</div>

												<form method="post">
													<div class="text-right mt-3">
														<button class="btn btn-secondary btn-sm px-5 font-weight-bold" type="submit" name="refresh">Refresh</button>
													</div>
												</form>
												<?php
													if (isset($_POST['refresh'])) {
														echo "<script>window.location.href='admin_genuser.php?id=$id'</script>";
													}
												} elseif (isset($_POST['gen_users'])) {
												$gen_num = $_POST['gen_num'];
												$gen_group = $_POST['gen_group']; ?>

												<h4 class="font-weight-bold">Users</h4>
												<hr>

												<div class="table-responsive-lg">
													<table class="table table-bordered text-center">
														<thead class="table-secondary">
															<th>Username</th>
															<th>Password</th>
															<th>Group</th>
														</thead>
														<tbody>
															<?php
																for ($i=0; $i <$gen_num ; $i++) { 
																	$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
																	$num = "1234567890";
																	$subC = str_shuffle($char);
																	$subN = str_shuffle($num);
																	$gen_username = substr($gen_group, 0, 3).substr($subC, 0, 3).substr($subN, 0, 2);
																	$gen_pass = substr($subN, 0, 6);

																	$genUsers = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$gen_username', 'Cleartext-Password', ':=', '$gen_pass')");
																	$genUsers = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$gen_username', '$gen_username', '$gen_group')");
																	if ($gen_group !== 'Defualt') {
																		$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$gen_username'");
																		$checkUIG = mysqli_num_rows($checkUG);
																		if ($checkUIG !== 1) {
																			$addUIG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$gen_username', '$gen_group', '1')");
																		}
																	} ?>
																<tr>
																	<td><?php echo $gen_username; ?></td>
																	<td><?php echo $gen_pass; ?></td>
																	<td><?php echo $gen_group; ?></td>
																</tr>
															<?php	} ?>
														</tbody>
													</table>
												</div>

												<form method="post">
													<div class="text-right mt-3">
														<button class="btn btn-secondary btn-sm px-5 font-weight-bold" type="submit" name="refresh">Refresh</button>
													</div>
												</form>
												<?php
													if (isset($_POST['refresh'])) {
														echo "<script>window.location.href='admin_genuser.php?id=$id'</script>";
													}
												 } else { ?>
												<div class="d-flex justify-content-center align-items-center h-100">
													<h1 class="text-secondary font-weight-bold">CTC <span class="text-warning">NETWORK</span></h1>
												</div>
											<?php } ?>
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