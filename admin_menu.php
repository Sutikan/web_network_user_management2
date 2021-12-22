<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="nav flex-column my-3 mx-2" style="min-height: 100vh;">
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link" style="padding-bottom: 0;"><h3 class="text-light mt-3 font-weight-bold">CTC <span class="text-warning">NETWORK</span></h3></a>
		<hr width="100%" class="border-secondary">
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

</body>
</html>