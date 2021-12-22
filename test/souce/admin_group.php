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
								<h4 class="font-weight-bold text-secondary">Generate Group</h4>
								<hr>

								<form method="post">
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Group Name</span>
										</div>
										<div class="col">
											<input type="text" name="g_name" class="form-control rounded-0" placeholder="Group Name" required>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Simultaneous Use</span>
										</div>
										<div class="col">
											<input type="text" name="g_use" class="form-control rounded-0" placeholder="Simultaneous Use" required>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Idle Timeout</span>
										</div>
										<div class="col">
											<div class="input-group">
												<input type="text" name="g_idle" class="form-control rounded-0" placeholder="Idle Timeout" required>
												<div class="input-group-prepend">
													<span class="input-group-text">Seconds</span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Session Timeout</span>
										</div>
										<div class="col">
											<div class="input-group">
												<input type="text" name="g_session" class="form-control rounded-0" placeholder="Session Timeout" required>
													<div class="input-group-prepend">
														<div class="input-group-text">Seconds</div>
													</div>
											</div>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Download</span>
										</div>
										<div class="col">
											<div class="input-group">
												<input type="text" name="g_down" class="form-control rounded-0" placeholder="Download" required>
												<div class="input-group-prepend">
													<div class="input-group-text">Kb/s</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold">Upload</span>
										</div>
										<div class="col">
											<div class="input-group">
												<input type="text" name="g_up" class="form-control rounded-0" placeholder="Upload" required>
												<div class="input-group-prepend">
													<div class="input-group-text">Kb/s</div>
												</div>
											</div>
										</div>
									</div>

									<div class="text-right mt-3 mb-3">
										<button class="btn btn-warning font-weight-bold px-5" type="submit" name="gen_group">Generate</button>
									</div>
								</form>
							</div>
							<div class="col">
								<?php
								if (isset($_POST['gen_group'])) {
									$g_name = $_POST['g_name'];
									$g_use = $_POST['g_use'];
									$g_idle = $_POST['g_idle'];
									$g_session = $_POST['g_session'];
									$g_down = $_POST['g_down'];
									$g_up = $_POST['g_up'];

									$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$g_name', 'Auth-Type', ':=', 'Accept')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$g_name', 'Simultaneous-Use', ':=', '$g_use')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_name', 'Acct-Interim-Interval', ':=', '60')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_name', 'Idle-Timeout', ':=', '$g_idle')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_name', 'Session-Timeout', ':=', '$g_session')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_name', 'WISPr-Bandwidth-Max-Down', ':=', '$g_down')");
									$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$g_name', 'WISPr-Bandwidth-Max-Up', ':=', '$g_up')");

								 ?>
									<h4 class="font-weight-bold text-secondary">Group</h4>
									<hr>

									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Group Name</span>
										</div>
										<div class="col">
											<?php echo $g_name; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Simultaneous Use</span>
										</div>
										<div class="col">
											<?php echo $g_use; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Idle Timeout</span>
										</div>
										<div class="col">
											<?php echo $g_idle; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Session Timeout</span>
										</div>
										<div class="col">
											<?php echo $g_session; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Download</span>
										</div>
										<div class="col">
											<?php echo $g_down; ?>
										</div>
									</div>
									<div class="form-row mb-2">
										<div class="col-3">
											<span class="form-text font-weight-bold text-warning">Upload</span>
										</div>
										<div class="col">
											<?php echo $g_up; ?>
										</div>
									</div>
										
									<form method="post">
										<button class="btn btn-secondary font-weight-bold px-5" type="submit" name="Refresh">Refresh</button>
									</form>
									<?php
										if (isset($_POST['Refresh'])) {
											echo "<script>window.location.href='admin_group.php?id=$id'</script>";
										}
									?>

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