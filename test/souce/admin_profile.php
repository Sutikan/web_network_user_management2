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

			<div class="row mt-3 mx-3">
				<div class="col">
					<div class="card border-0">
						<div class="card-body mb-3">
							<div class="container-fluid">
								<h4 class="font-weight-bold text-secondary">My Profile</h4>
								<hr>

								<form method="post">
									<div class="form-row mb-2">
										<div class="col-2">
											<span class="text-dark font-weight-bold form-text">Username</span>
										</div>
										<div class="col">
											<input type="text" name="s_username" class="form-control rounded-0" placeholder="Username" value="<?php echo $username ?>" required disabled>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-2">
											<span class="text-dark font-weight-bold form-text">Name</span>
										</div>
										<div class="col">
											<?php 
												$showProfile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
												$showP = mysqli_fetch_assoc($showProfile);
											?>
											<div class="input-group">
												<input type="text" name="p_name" class="form-control rounded-0" placeholder="Username" value="<?php echo $showP['m_name'] ?>" required>
												<input type="text" name="p_lastname" class="form-control rounded-0" placeholder="Username" value="<?php echo $showP['m_lastname'] ?>" required>
											</div>
										</div>
									</div>
									<div class="text-right mt-5">
										<button class="btn btn-warning font-weight-bold px-5" type="submit" name="up_pro">Update</button>
									</div>
								</form>
								<?php
									if (isset($_POST['up_pro'])) {
										$p_name = $_POST['p_name'];
										$p_lastname = $_POST['p_lastname'];

										$upProfile = mysqli_query($con, "UPDATE member SET m_name = '$p_name', m_lastname = '$p_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$username'");
										echo "<script>alert('Update profile successful')</script>";
										echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
									}
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="col">
					<div class="card border-0">
						<div class="card-body">
							<div class="container-fluid">
								<h4 class="font-weight-bold text-secondary">Change Password</h4>
								<hr>

								<form method="post">
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="text-dark font-weight-bold form-text">Old Password</span>
										</div>
										<div class="col">
											<input type="password" name="c_oldpass" class="form-control rounded-0" placeholder="Old Password" required>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="text-dark font-weight-bold form-text">New Password</span>
										</div>
										<div class="col">
											<input type="password" name="c_newpass" class="form-control rounded-0" placeholder="New Password" required>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="text-dark font-weight-bold form-text">Confirm Password</span>
										</div>
										<div class="col">
											<input type="password" name="c_conpass" class="form-control rounded-0" placeholder="Confirm Password" required>
										</div>
									</div>
									<div class="text-right mt-3">
										<button class="btn btn-secondary font-weight-bold px-5" type="submit" name="change_pass">Change</button>
									</div>
								</form>
								<?php
									if (isset($_POST['change_pass'])) {
										$c_oldpass = $_POST['c_oldpass'];
										$c_newpass = $_POST['c_newpass'];
										$c_conpass = $_POST['c_conpass'];

										$checkoldpass = mysqli_query($con, "SELECT * FROM radcheck WHERE value = '$c_oldpass' AND username = '$username'");
										$countoldpass = mysqli_num_rows($checkoldpass);
										if ($countoldpass === 1) {
											if ($c_newpass === $c_conpass) {
												$changePass = mysqli_query($con, "UPDATE radcheck SET value = '$c_newpass' WHERE username = '$username'");
												echo "<script>alert('Change password successful')</script>";
												echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
											} else {
												echo "<script>alert('Your password not match!')</script>";
												echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
											}
										} else {
											echo "<script>alert('Your old password is not correct!')</script>";
											echo "<script>window.location.href='admin_profile.php?id=$id'</script>";
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
	
</body>
</html>

<?php } ?>