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
								<h4 class="font-weight-bold text-secondary">Generate User</h4>
								<small>For generate only 1 user</small>
								<hr>

								<form method="post">
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Username</span>
										</div>
										<div class="col">
											<input type="text" name="gen_username" class="form-control rounded-0" placeholder="Username">
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Name</span>
										</div>
										<div class="col">
											<div class="input-group">
												<input type="text" name="gen_name" class="form-control rounded-0" placeholder="Name">
												<input type="text" name="gen_lastname" class="form-control rounded-0" placeholder="Lastname">
											</div>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Password</span>
										</div>
										<div class="col">
											<input type="password" name="gen_pass" class="form-control rounded-0" placeholder="Password">
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Group</span>
										</div>
										<div class="col">
											<select class="form-control rounded-0" name="gen_group">
												<option value="Defult">Defult</option>
													<?php
														$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
														while ($group = mysqli_fetch_assoc($loopgroup)) { ?>
															<option value="<?php echo $group['groupname'] ?>"><?php echo $group['groupname'] ?></option>
													<?php	}	?>
											</select>
										</div>
									</div>

									<div class="text-right mt-3">
										<button class="btn btn-warning font-weight-bold px-5" type="submit" name="gen_user">Generate</button>
									</div>
									<hr width="20%" class="mt-4 mb-4">
									<h4 class="font-weight-bold text-secondary">Generate Users</h4>
									<small>For generate more 1 user</small>
									<hr>

									<form method="post">
										<div class="form-row mb-2">
											<div class="col-3">
												<span class="form-text font-weight-bold">Number of users</span>
											</div>
											<div class="col">
												<input type="text" name="gens_num" class="form-control rounded-0" placeholder="Number of users">
											</div>
										</div>
										<div class="form-row mb-2">
											<div class="col-3">
												<span class="form-text font-weight-bold">Group</span>
											</div>
											<div class="col">
												<select class="form-control rounded-0" name="gens_group">
													<option value="Defult">Defult</option>
														<?php
															$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
															while ($group = mysqli_fetch_assoc($loopgroup)) { ?>
																<option value="<?php echo $group['groupname'] ?>"><?php echo $group['groupname'] ?></option>
														<?php	}	?>
												</select>
											</div>
										</div>

										<div class="text-right mt-3 mb-3">
											<button class="btn btn-secondary font-weight-bold px-5" type="submit" name="gen_users">Generate</button>
										</div>
								</form>
							</div>
							<div class="col">
								<?php
								if (isset($_POST['gen_user'])) {
									$gen_name = $_POST['gen_name'];
									$gen_lastname = $_POST['gen_lastname'];
									$gen_username = $_POST['gen_username'];
									$gen_pass = $_POST['gen_pass'];
									$gen_group = $_POST['gen_group'];

									$checkname = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($gen_username)."'");
									$checkN = mysqli_num_rows($checkname);
									if ($checkN === 1) {
										echo "<script>alert('Thais username is already exists!')</script>";
										echo "<script>window.location.href='index.php'</script>";
									} else {
										$genUser = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$gen_username', 'Cleartext-Password', ':=', '$gen_pass')");
										$genUser = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$gen_username', '$gen_name', '$gen_lastname')");

										if ($gen_group !== 'Defult') {
											$checkUinG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$gen_username'");
											$countUinG = mysqli_num_rows($checkUinG);
											if ($countUinG !== 1) {
												$addUinG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$gen_username', '$gen_group', '1')");
											}
										} 
									}

								 ?>
									<h4 class="font-weight-bold text-secondary">User</h4>
									<hr>

									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Username</span>
										</div>
										<div class="col">
											<?php echo $gen_name; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Name</span>
										</div>
										<div class="col">
											<?php echo $gen_name; ?> <?php echo $gen_lastname; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Password</span>
										</div>
										<div class="col">
											<?php echo $gen_pass; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Group</span>
										</div>
										<div class="col">
											<?php echo $gen_group; ?>
										</div>
									</div>
										
									<form method="post" class="text-right">
										<button class="btn btn-secondary font-weight-bold px-5" type="submit" name="Refresh">Refresh</button>
									</form>
									<?php
										if (isset($_POST['Refresh'])) {
											echo "<script>window.location.href='admin_user.php?id=$id'</script>";
										}
									?>

								<?php } elseif (isset($_POST['gen_users'])) {
									$gens_num = $_POST['gens_num'];
									$gens_group = $_POST['gens_group'];
								?>
									<div class="table-responsive">
										<table class="text-center table table-bordered">
											<thead style="background-color: #eaeaea;">
												<th>Username</th>
												<th>Password</th>
												<th>Group</th>
											</thead>
											<tbody>
												<?php
													for ($i=0; $i <$gens_num ; $i++) { 
														$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
														$num = "1234567890";
														$subC = str_shuffle($char);
														$sudN = str_shuffle($num);
														$gens_username = substr($gens_group, 0, 3).substr($subC, 0, 3).substr($sudN, 0, 2);
														$gens_pass = substr($sudN, 0, 6);

														$genUsers = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$gens_username', 'Cleartext-Password', ':=', '$gens_pass')");
														$genUsers = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$gens_username', '$gens_username', '$gens_group')");

														if ($gens_group !== 'Defult') {
															$checkUinG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$gens_username'");
															$countUinG = mysqli_num_rows($checkUinG);
															if ($countUinG !== 1) {
																$addUinG = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$gens_username', '$gens_group', '1')");
															}
														}
												?>
													<tr>
														<td><?php echo $gens_username;?></td>
														<td><?php echo $gens_pass;?></td>
														<td><?php echo $gens_group;?></td>
													</tr>
												<?php	} ?>
											</tbody>
										</table>

										<form method="post" class="text-right">
										<button class="btn btn-secondary font-weight-bold px-5" type="submit" name="Refresh">Refresh</button>
									</form>
									<?php
										if (isset($_POST['Refresh'])) {
											echo "<script>window.location.href='admin_user.php?id=$id'</script>";
										}
									?>

									</div>
								<?php } else { ?>
									<div class="d-flex justify-content-center align-items-center h-100">
										<h1 class="font-weight-bold text-secondary">CTC <span class="text-warning">NETWORK</span></h1>
									</div>
								<?php }	?>
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