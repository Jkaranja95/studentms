<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$sport_id = $_GET['sport_id'];

if (isset($_GET['option'])) {
	$option = $_GET['option'];
	if ($option == "deactivate") {
		$sql = "UPDATE `sports` SET `status` = 0 WHERE `id` = $sport_id";
		//echo "<script type='text/javascript'>alert('".$sql."');</script>";
		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	} else if ($option == "activate") {
		$sql = "UPDATE `sports` SET `status` = 1 WHERE `id` = $sport_id";

		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	}
}
$sport = Db::get()->get_by_id("sports", $sport_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require('../../includes/sport-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Sport Details</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Sport Details
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive" id="reportData">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>ID</td>
											<td><?php echo $sport->id; ?></td>
										</tr>
										<tr>
											<td>Date Joined</td>
											<td><?php echo $sport->date; ?></td>
										</tr>
										<tr>
											<td>Admission Number</td>
											<td><?php echo $sport->admno; ?></td>
										</tr>
										<?php $student = Db::get()->get_by("students", "admno", $sport->admno)[0]; ?>
										<tr>
											<td>Name</td>
											<td><?php echo $student->name; ?></td>
										</tr>
										<tr>
											<td>Sport</td>
											<td><?php echo $sport->sport; ?></td>
										</tr>
										<tr>
											<td>Rank</td>
											<td><?php echo $sport->rank; ?></td>
										</tr>
										<tr>
											<td>Status</td>
											<?php
											$status = ($sport->status == 1) ? "ACTIVE" : "DEACTIVATED";
											?>
											<td><?php echo $status; ?></td>
										</tr>
									</tbody>
								</table>
								<div style="display:flex; justify-content: center;">
									<?php if ($sport->status == 1) { ?>
										<a href="?sport_id=<?php echo $sport->id; ?>&option=deactivate"
											class="btn btn-danger">DEACTIVATE</a>
									<?php } else { ?>
										<a href="?sport_id=<?php echo $sport->id; ?>&option=activate"
											class="btn btn-success">ACTIVATE</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require '../../includes/footer.php'; ?>
	<!-- Bootstrap Core JavaScript -->
	<script src="../../assets/js/bootstrap.min.js"></script>
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../../assets/metisMenu/metisMenu.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="../../assets/js/admin.js"></script>
</body>

</html>