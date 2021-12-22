<?php
	@session_start();
	include 'connect.php';
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
<body class="bg-dark d-flex justify-content-center align-items-center" style="min-height: 100vh;">

<div class="card border-0 text-center">
	<div class="card-body mx-5 my-5">
		<h1 class="text-secondary font-weight-bold">CTC <span class="text-warning">NETWORK</span></h1>
		<div class="nav nav-tabs nav-justified mb-3 mt-5">
			<a href="#login" class="nav-link font-weight-bold active" data-toggle="tab">Log In</a>
			<a href="#signup" class="nav-link font-weight-bold" data-toggle="tab">Sign Up</a>
		</div>

		<div class="tab-content">
			<div class="tab-pane fade active show" id="login">
				<form method="post">
					<input type="text" name="l_username" class="form-control rounded-0 mb-2" placeholder="Username" required>
					<input type="password" name="l_pass" class="form-control rounded-0 mb-2" placeholder="Password" required>
					<hr>
					<button class="btn btn-warning btn-block font-weight-bold" type="submit" name="log_in">Log In</button>
				</form>
				<?php
					if (isset($_POST['log_in'])) {
						$logIn = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($_POST['l_username'])."' AND value = '".trim($_POST['l_pass'])."'");
						$data = mysqli_fetch_assoc($logIn);
						if ($data) {
							if ($data['attribute'] === 'Cleartext-Password') {
								$id = $data['id'];
								$username = $data['username'];
								$_SESSION['id'] = $data['id'];
								$_SESSION['username'] = $data['username'];

								if ($data['username'] === 'admin') {
									echo "<script>window.location.href='admin_index.php?id=$id'</script>";
								} else {
									echo "<script>window.location.href='user_index.php?id=$id'</script>";
								}
							} else {
								echo "<script>alert('This username has been suspend!')</script>";
								echo "<script>window.location.href='index.php'</script>";
							}
						} else {
							echo "<script>alert('Username or password is not correct!')</script>";
							echo "<script>window.location.href='index.php'</script>";
						}
					}
				?>
			</div>
			<div class="tab-pane fade" id="signup">
				<form method="post">
					<div class="form-row">
						<div class="col">
							<input type="text" name="s_name" class="form-control rounded-0 mb-2" placeholder="Name" required>
						</div>
						<div class="col">
							<input type="text" name="s_lastname" class="form-control rounded-0 mb-2" placeholder="Lastname" required>
						</div>
					</div>
					<input type="text" name="s_username" class="form-control rounded-0 mb-2" placeholder="Username" required>
					<input type="password" name="s_pass" class="form-control rounded-0 mb-2" placeholder="Password" required>
					<hr>
					<button class="btn btn-secondary btn-block font-weight-bold" type="submit" name="sign_up">Sign Up</button>
				</form>
				<?php
					if (isset($_POST['sign_up'])) {
						$s_name = $_POST['s_name'];
						$s_lastname = $_POST['s_lastname'];
						$s_username = $_POST['s_username'];
						$s_pass = $_POST['s_pass'];

						$checkname = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($s_username)."'");
						$checkN = mysqli_num_rows($checkname);
						if ($checkN === 1) {
							echo "<script>alert('Thais username is already exists!')</script>";
							echo "<script>window.location.href='index.php'</script>";
						} else {
							$signUp = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$s_username', 'Password', ':=', '$s_pass')");
							$signUp = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$s_username', '$s_name', '$s_lastname')");
							echo "<script>alert('Sign up successful, Please wait for approve')</script>";
							echo "<script>window.location.href='index.php'</script>";
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
	
</body>
</html>