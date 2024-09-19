<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$med_id = $_GET['med_id'];

if (isset($_GET['option'])) {
	$option = $_GET['option'];
	if ($option == "activate") {
		$sql = "UPDATE `medical` SET `status` = 0 WHERE `id` = $med_id";
		//echo "<script type='text/javascript'>alert('".$sql."');</script>";
		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	} else if ($option == "clear") {
		$sql = "UPDATE `medical` SET `status` = 1 WHERE `id` = $med_id";

		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	}
}
$medical = Db::get()->get_by_id("medical", $med_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require('../../includes/medical-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Medical Details</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Medical Details
							<span class="pull-right" style="margin-top: -7px;">
								<a id="add_property_button" type="button" name="button" class="btn btn-success"
									href="edit_medical.php?med_id=<?php echo $medical->id; ?>">
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
											<td><?php echo $medical->id; ?></td>
										</tr>
										<tr>
											<td>Date Reported</td>
											<td><?php echo $medical->date; ?></td>
										</tr>
										<tr>
											<td>Admission Number</td>
											<td><?php echo $medical->admno; ?></td>
										</tr>
										<?php $student = Db::get()->get_by("students", "admno", $medical->admno)[0]; ?>
										<tr>
											<td>Name</td>
											<td><?php echo $student->name; ?></td>
										</tr>
										<tr>
											<td>Sickness</td>
											<td><?php echo $medical->sickness; ?></td>
										</tr>
										<tr>
											<td>Allergies</td>
											<td><?php echo $medical->allergies; ?></td>
										</tr>
										<tr>
											<td>Treatment</td>
											<td><?php echo $medical->treatment; ?></td>
										</tr>
										<tr>
											<td>Status</td>
											<?php
											$status = ($medical->status == 1) ? "CLEARED" : "ACTIVE";
											?>
											<td><?php echo $status; ?></td>
										</tr>
									</tbody>
								</table>
								<div style="display:flex; justify-content: center;">
									<?php if ($medical->status == 1) { ?>
										<a href="?med_id=<?php echo $medical->id; ?>&option=activate" class="btn btn-danger">ACTIVATE
										</a>
									<?php } else { ?>
										<a href="?med_id=<?php echo $medical->id; ?>&option=clear"
											class="btn btn-success">CLEAR</a>
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