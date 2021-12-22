<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="navbar navbar-expand-lg navbar-dark bg-dark d-block">
		<div class="container-fluid">
			 <a href="<?php echo "admin_index.php?id=$id" ?>" class="navbar-brand font-weight-bold d-md-none">CTC <span class="text-warning">NETWORK</span></a>
			 <button class="navbar-toggler d-block d-md-none" type="button" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			 <div class="collapse navbar-collapse" id="menu">
			 	<div class="d-lg-none">
			 		<a class="nav-link disabled font-weight-bold text-warning">Manage</a>
					<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
					<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
					<a class="nav-link disabled font-weight-bold text-warning">Generate</a>
					<a href="<?php echo "admin_group.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Group</a>
					<a href="<?php echo "admin_user.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Users</a>
					<a class="nav-link disabled font-weight-bold text-warning">Report</a>
					<a href="<?php echo "admin_network.php?id=$id" ?>" class="nav-link text-light ml-3">Network Report</a>
					<a href="<?php echo "admin_userre.php?id=$id" ?>" class="nav-link text-light ml-3">Users Report</a>
					<hr class="border-secondary" width="100%">
					<button class="btn btn-warning btn-block font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
			 	</div>
			 </div>
			 <div class="ml-auto d-none d-md-block">
			 	<button class="btn btn-warning font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
			 </div>
		</div>
	</div>

	<div class="modal fade" id="logout">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="post">
					<div class="modal-body">
						<button class="close" data-dismiss="modal" type="button">&times;</button>
						<div class="mb-3 mt-4 mx-3 d-flex flex-column">
							<span class="mb-4">Are you sure, you want to log out?</span>
							<div class="text-right">
								<button class="btn btn-sm btn-light font-weight-bold" data-dismiss="modal" type="button">Cancel</button>
								<button class="btn btn-sm btn-danger font-weight-bold" type="submit" name="log_out">Log Out</button>
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