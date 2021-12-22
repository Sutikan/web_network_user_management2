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
										<h4 class="font-weight-bold">My Profile</h4>
										<hr>
										<?php
											$showpro = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
											$pro = mysqli_fetch_assoc($showpro);
										?>
										<form method="post">
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Username</span>
												</div>
												<div class="col">
													<input class="form-control rounded-0" value="<?php echo $username ?>" disabled>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-2">
													<span class="text-secondary font-weight-bold form-text">Name</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input type="text" name="p_name" class="form-control rounded-0" placeholder="Name" value="<?php echo $pro['m_name'] ?>" required>
														<input type="text" name="p_lastname" class="form-control rounded-0" placeholder="Lastname" value="<?php echo $pro['m_lastname'] ?>" required>
													</div>
												</div>
											</div>
											<div class="text-right mt-3">
												<button class="btn btn-warning btn-sm px-5 font-weight-bold" type="submit" name="up_pro">Update</button>
											</div>
										</form>
										<?php
											if (isset($_POST['up_pro'])) {
												$p_name = $_POST['p_name'];
												$p_lastname = $_POST['p_lastname'];

												$upUser = mysqli_query($con, "UPDATE member SET m_name = '$p_name', m_lastname = '$p_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$username'");
												echo "<script>alert('Update profile successful!')</script>";
												echo "<script>window.location.href='user_profile.php?id=$id'</script>";
											}
										?>
									</div>
									<div class="col">
										<h4 class="font-weight-bold">Change Password</h4>
										<hr>
										<form method="post">
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Old Password</span>
												</div>
												<div class="col">
													<input type="password" name="c_oldpass" class="form-control rounded-0" placeholder="Old Password" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">New Password</span>
												</div>
												<div class="col">
													<input type="password" name="c_newpass" class="form-control rounded-0" placeholder="New Password" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Confirm Password</span>
												</div>
												<div class="col">
													<input type="password" name="c_conpass" class="form-control rounded-0" placeholder="Confirm Password" required>
												</div>
											</div>
											<div class="text-right mt-3">
												<button class="btn btn-secondary btn-sm px-5 font-weight-bold" type="submit" name="up_pass">Change</button>
											</div>
										</form>
										<?php
											if (isset($_POST['up_pass'])) {
												$c_oldpass = $_POST['c_oldpass'];
												$c_newpass = $_POST['c_newpass'];
												$c_conpass = $_POST['c_conpass'];

												$checkop = mysqli_query($con, "SELECT * FROM radcheck WHERE value = '$c_oldpass' AND username = '$username'");
												$checkold = mysqli_num_rows($checkop);
												if ($checkold === 1) {
													if ($c_newpass === $c_conpass) {
														$upPass = mysqli_query($con, "UPDATE radcheck SET value = '$c_newpass' WHERE username = '$username'");
														$upPass = mysqli_query($con, "UPDATE member SET m_update = NOW(), m_who = '$username' WHERE username = '$username'");
														echo "<script>alert('Update password successful')</script>";
														echo "<script>window.location.href='user_profile.php?id=$id'</script>";
													} else {
														echo "<script>alert('Password is not match!')</script>";
														echo "<script>window.location.href='user_profile.php?id=$id'</script>";
													}
												} else {
													echo "<script>alert('Your old password is not correct!')</script>";
													echo "<script>window.location.href='user_profile.php?id=$id'</script>";
												}

											}
										?>
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