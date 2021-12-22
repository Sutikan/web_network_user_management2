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
										<h4 class="font-weight-bold">Generate Group</h4>
										<hr>
										<form method="post">
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Group name</span>
												</div>
												<div class="col">
													<input name="gen_gname" class="form-control rounded-0" placeholder="Group name" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Simultaneous Use</span>
												</div>
												<div class="col">
													<input name="gen_use" class="form-control rounded-0" placeholder="Simultaneous Use" required>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Idle Timeout</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input name="gen_idle" class="form-control rounded-0" placeholder="Idle Timeout" required>
														<div class="input-group-prepend">
															<span class="input-group-text">Seconds</span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Session Timeout</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input name="gen_session" class="form-control rounded-0" placeholder="Session Timeout" required>
														<div class="input-group-prepend">
															<span class="input-group-text">Seconds</span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Download</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input name="gen_down" class="form-control rounded-0" placeholder="Download" required>
														<div class="input-group-prepend">
															<span class="input-group-text">Kb/s</span>
														</div>
													</div>
												</div>
											</div>
											<div class="form-row mb-2">
												<div class="col-3">
													<span class="text-secondary font-weight-bold form-text">Upload</span>
												</div>
												<div class="col">
													<div class="input-group">
														<input name="gen_up" class="form-control rounded-0" placeholder="Upload" required>
														<div class="input-group-prepend">
															<span class="input-group-text">Kb/s</span>
														</div>
													</div>
												</div>
											</div>
											<div class="text-right mt-3">
												<button class="btn btn-warning btn-sm px-5 font-weight-bold" type="submit" name="gen_group">Generate</button>
											</div>
										</form>
									</div>
									<div class="col">
										<?php
											if (isset($_POST['gen_group'])) {
												$gen_gname = $_POST['gen_gname'];
												$gen_use = $_POST['gen_use'];
												$gen_idle = $_POST['gen_idle'];
												$gen_session = $_POST['gen_session'];
												$gen_down = $_POST['gen_down'];
												$gen_up = $_POST['gen_up'];

												$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$gen_gname', 'Auth-Type', ':=', 'Accept')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$gen_gname', 'Simultaneous-Use', ':=', '$gen_use')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gen_gname', 'Acct-Interim-Interval', ':=', '60')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gen_gname', 'Idle-Timeout', ':=', '$gen_idle')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gen_gname', 'Session-Timeout', ':=', '$gen_session')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gen_gname', 'WISPr-Bandwidth-Max-Down', ':=', '$gen_down')");
												$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gen_gname', 'WISPr-Bandwidth-Max-Up', ':=', '$gen_up')"); ?>

												<h4 class="font-weight-bold">Group</h4>
												<hr>

												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Group name</span>
													</div>
													<div class="col">
														<?php echo $gen_gname ?>
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Simultaneous Use</span>
													</div>
													<div class="col">
														<?php echo $gen_use ?>
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Idle Timeout</span>
													</div>
													<div class="col">
														<?php echo $gen_idle ?> Seconds
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Session Timeout</span>
													</div>
													<div class="col">
														<?php echo $gen_session ?> Seconds
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Download</span>
													</div>
													<div class="col">
														<?php echo $gen_down ?> Kb/s
													</div>
												</div>
												<div class="form-row mb-2">
													<div class="col-3">
														<span class="text-warning font-weight-bold form-text">Upload</span>
													</div>
													<div class="col">
														<?php echo $gen_up ?> Kb/s
													</div>
												</div>

												<form method="post">
													<div class="text-right mt-3">
														<button class="btn btn-secondary btn-sm px-5 font-weight-bold" type="submit" name="refresh">Refresh</button>
													</div>
												</form>
												<?php
													if (isset($_POST['refresh'])) {
														echo "<script>window.location.href='admin_gengroup.php?id=$id'</script>";
													}
												?>

											<?php } else { ?>
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