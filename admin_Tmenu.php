<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="navbar navbar-dark bg-dark navbar-expand-lg d-block">
		<div class="container-fluid">
			<a href="<?php echo "admin_index.php?id=$id" ?>" class="navbar-brand font-weight-bold d-md-none">CTC <span class="text-warning">NETWORK</span></a>
			<button class="navbar-toggler d-block d-md-none" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="menu">
				<div class="d-lg-none">
					<a class="nav-link disabled font-weight-bold text-warning">Manage</a>
					<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
					<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
					<a class="nav-link disabled font-weight-bold text-warning">Generate</a>
					<a href="<?php echo "admin_gengroup.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Group</a>
					<a href="<?php echo "admin_genuser.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Users</a>
					<a class="nav-link disabled font-weight-bold text-warning">Report</a>
					<a href="<?php echo "admin_network.php?id=$id" ?>" class="nav-link text-light ml-3">Network & Time</a>
					<hr width="100%" class="border-secondary">
					<button class="btn btn-block btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log out</button>
				</div>
			</div>
			<div class="ml-auto d-none d-md-block">
				<button class="btn btn-sm px-3 btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log out</button>
			</div>
		</div>
	</div>

	<div class="modal fade" id="logout">
		<div class="modal-dialog modal-sm modal-dialog-centered">
			<div class="modal-content">
				<form method="post">
					<div class="modal-body text-center">
						<div class="m-2">
							<h5 class="text-center">Log out</h5>
							<span class="card-text">Do you want to Logout?</span>
						</div>
						<hr>
						<div class="row">
							<div class="col" style="padding-right: 0;">
								<button class="btn btn-sm btn-danger btn-block font-weight-bold" type="submit" name="log_out">Yes, log out</button>
							</div>
							<div class="col" style="padding-left: 1px;">
								<button class="btn btn-sm btn-light btn-block" type="button" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</form>
				<?php
					if (isset($_POST['log_out'])) {
						session_destroy();
						echo "<script>window.location.href='index.php'</script>";
					}
				?>
			</div>
		</div>
	</div>

</body>
</html>