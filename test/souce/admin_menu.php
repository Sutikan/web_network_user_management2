<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="nav flex-column mx-2" style="min-height: 100vh;">
		<a href="<?php echo "admin_index.php?id=$id" ?>" style="margin-bottom: 0;"><h3 class="text-light font-weight-bold mt-5">CTC <span class="text-warning">NETWORK</span></h3></a>
		<hr class="border-secondary" width="100%">
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

</body>
</html>