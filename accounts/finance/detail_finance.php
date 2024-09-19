<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$finance_id = $_GET['finance_id'];

$finance = Db::get()->get_by_id("finance", $finance_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require('../../includes/finance-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Finance Details</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Finance Details
							<span class="pull-right" style="margin-top: -7px;">
								<a id="add_property_button" type="button" name="button" class="btn btn-success"
									href="edit_finance.php?finance_id=<?php echo $finance->id; ?>">
									<i class="fa fa-plus-square"></i>
									Edit
								</a>
							</span>
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive" id="reportData">
								<table class="table table-striped table-bordered table-hover">
									<tbody>
										<tr>
											<td>ID</td>
											<td><?php echo $finance->id; ?></td>
										</tr>
										<tr>
											<td>Date Payed</td>
											<td><?php echo $finance->date; ?></td>
										</tr>
										<tr>
											<td>Admission Number</td>
											<td><?php echo $finance->admno; ?></td>
										</tr>
										<?php $student = Db::get()->get_by("students", "admno", $finance->admno)[0]; ?>
										<tr>
											<td>Name</td>
											<td><?php echo $student->name; ?></td>
										</tr>
										<tr>
											<td>Form</td>
											<td><?php echo $finance->form; ?></td>
										</tr>
										<tr>
											<td>Term</td>
											<td><?php echo $finance->term; ?></td>
										</tr>
										<tr>
											<td>Amount</td>
											<td><?php echo $finance->amount; ?></td>
										</tr>
										<tr>
											<td>Balance</td>
											<?php
											$sql = "SELECT * from feestructure WHERE form = :form AND term = :term";
											$conn = Db::get()->conn;
											$stmt = $conn->prepare($sql);
											$stmt->bindparam("form", $finance->form);
											$stmt->bindparam("term", $finance->term);

											$stmt->execute();

											$fs = $stmt->fetch(PDO::FETCH_OBJ);

											$sql = "SELECT SUM(amount) as amount from finance WHERE admno = :admno AND form = :form AND term = :term";
											$conn = Db::get()->conn;
											$stmt = $conn->prepare($sql);
											$stmt->bindparam("admno", $finance->admno);
											$stmt->bindparam("form", $finance->form);
											$stmt->bindparam("term", $finance->term);

											$stmt->execute();

											$paid = $stmt->fetch(PDO::FETCH_OBJ);

											?>
											<td><?php echo ($fs->amount - $paid->amount); ?></td>
										</tr>
										<tr>
											<td>Receipt</td>
											<td><?php echo $finance->receipt; ?></td>
										</tr>
									</tbody>
								</table>
								<div style="display:flex; justify-content: center;">
									<?php if (($fs->amount - $paid->amount) > 0) { ?>
										<a href="add_finance.php" class="btn btn-success">PAY FEE</a>
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