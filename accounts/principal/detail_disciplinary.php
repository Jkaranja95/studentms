<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$disc_id = $_GET['disc_id'];

if (isset($_GET['option'])) {
	$option = $_GET['option'];
	if ($option == "open") {
		$sql = "UPDATE `disciplinary` SET `status` = 0 WHERE `id` = $disc_id";
		//echo "<script type='text/javascript'>alert('".$sql."');</script>";
		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	} else if ($option == "clear") {
		$sql = "UPDATE `disciplinary` SET `status` = 1 WHERE `id` = $disc_id";

		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	}
}
$disc = Db::get()->get_by_id("disciplinary", $disc_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require('../../includes/principal-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Disciplinary Details</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Disciplinary Details
							<span class="pull-right" style="margin-top: -7px;">
								<a id="add_property_button" type="button" name="button" class="btn btn-success"
									href="edit_disciplinary.php?disc_id=<?php echo $disc->id; ?>">
									<i class="fa fa-plus-square"></i>
									Edit Record
								</a>
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive" id="reportData">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>ID</td>
											<td><?php echo $disc->id; ?></td>
										</tr>
										<tr>
											<td>Date Reported</td>
											<td><?php echo $disc->date; ?></td>
										</tr>
										<tr>
											<td>Admission Number</td>
											<td><?php echo $disc->admno; ?></td>
										</tr>
										<?php $student = Db::get()->get_by("students", "admno", $disc->admno)[0]; ?>
										<tr>
											<td>Name</td>
											<td><?php echo $student->name; ?></td>
										</tr>
										<tr>
											<td>Case</td>
											<td><?php echo $disc->case; ?></td>
										</tr>
										<tr>
											<td>Punishment</td>
											<td><?php echo $disc->punishment; ?></td>
										</tr>
										<tr>
											<td>Status</td>
											<?php
											$status = ($disc->status == 1) ? "CLEARED" : "OPEN";
											?>
											<td><?php echo $status; ?></td>
										</tr>
									</tbody>
								</table>
								<div style="display:flex; justify-content: center;">
									<?php if ($disc->status == 1) { ?>
										<a href="?disc_id=<?php echo $disc->id; ?>&option=open" class="btn btn-danger">OPEN
											CASE</a>
									<?php } else { ?>
										<a href="?disc_id=<?php echo $disc->id; ?>&option=clear"
											class="btn btn-success">CLEAR CASE</a>
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