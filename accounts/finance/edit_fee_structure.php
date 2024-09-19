<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$fs_id = trim($_GET["fs_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$amount = trim($_POST["amount"]);

	$sql = "UPDATE `feestructure` SET `amount` = :amount WHERE id = :id";

	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
    $stmt->bindparam(":id", $fs_id);
	$stmt->bindparam(":amount", $amount);

	$stmt->execute();

	$status = Alert::create('success', 'Update successful', 'Fee Structure Updated.');
	header("refresh:3;detail_fee_structure.php?fs_id=" . $fs_id);
}

$fs = Db::get()->get_by_id("feestructure", $fs_id);
?>

<!DOCTYPE html>
<html lang="en">

<?php require ('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require ('../../includes/finance-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edit Fee Structure</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Fee Structure
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>
									
									<div class="form-group">
										<label for="amount" class="control-label">Amount</label>
										<input type="number" name="amount" id="amount" class="form-control" required="true"
											value="<?php echo $fs->amount; ?>">
									</div>
								
									<button type="submit" name="edit" id="edit" class="btn btn-success mybutton btn-block"
										style="margin-top:10px;">Edit</button>
									<br>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require '../../includes/footer.php'; ?>
	<script>
		document.getElementById("add-form").addEventListener("submit", function (event) {
			var amount =
                document.getElementById("amount").value;
            if (amount < 1) {
                window.alert("Please enter a valid admission number.");
                event.preventDefault();
                return;
            }
		});
	</script>
	<!-- Bootstrap Core JavaScript -->
	<script src="../../assets/js/bootstrap.min.js"></script>
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../../assets/metisMenu/metisMenu.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="../../assets/js/admin.js"></script>
</body>

</html>