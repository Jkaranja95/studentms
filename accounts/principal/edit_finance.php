<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$finance_id = trim($_GET["finance_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$form = trim($_POST["form"]);
	$term = trim($_POST["term"]);
	$amount = trim($_POST["amount"]);
	$receipt = trim($_POST["receipt"]);
	$sql = "SELECT * from feestructure WHERE form = :form AND term = :term";
	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
	$stmt->bindparam("form", $form);
	$stmt->bindparam("term", $term);

	$stmt->execute();

	$fs = $stmt->fetch(PDO::FETCH_OBJ);

	$finance = Db::get()->get_by_id("finance", $finance_id);

	$sql = "SELECT SUM(amount) as amount from finance WHERE admno = :admno AND form = :form AND term = :term";
	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
	$stmt->bindparam("admno", $finance->admno);
	$stmt->bindparam("form", $form);
	$stmt->bindparam("term", $term);

	$stmt->execute();

	$paid = $stmt->fetch(PDO::FETCH_OBJ);


	if (($fs->amount - (($paid->amount - $finance->amount) + $amount)) < 0) {
		$status = Alert::create('danger', 'Save unsuccessful', 'Fee Exceeds Balance.');
	} else {

		$sql = "UPDATE `finance` SET `form` = :form,`term` = :term,`amount` = :amount,`receipt` = :receipt WHERE id = :id";

		$conn = Db::get()->conn;
		$stmt = $conn->prepare($sql);
		$stmt->bindparam(":id", $finance_id);
		$stmt->bindparam(":form", $form);
		$stmt->bindparam(":form", $form);
		$stmt->bindparam(":term", $term);
		$stmt->bindparam(":amount", $amount);
		$stmt->bindparam(":receipt", $receipt);

		$stmt->execute();

		$status = Alert::create('success', 'Update successful', 'Fee Updated.');
		header("refresh:3;detail_finance.php?finance_id=" . $finance_id);
	}
}

$finance = Db::get()->get_by_id("finance", $finance_id);
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
					<h1 class="page-header">Edit Finance</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Fee
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>

									<div class="form-group">
										<label for="form" class="control-label">Form</label>
										<input type="number" name="form" id="form" class="form-control" required="true"
											value="<?php echo $finance->form; ?>">
									</div>
									<div class="form-group">
										<label for="term" class="control-label">Term</label>
										<input type="number" name="term" id="term" class="form-control" required="true"
											value="<?php echo $finance->term; ?>">
									</div>
									<div class="form-group">
										<label for="amount" class="control-label">Amount</label>
										<input type="number" name="amount" id="amount" class="form-control"
											required="true" value="<?php echo $finance->amount; ?>">
									</div>
									<div class="form-group">
										<label for="receipt" class="control-label">Receipt</label>
										<input type="text" name="receipt" id="receipt" class="form-control"
											required="true" value="<?php echo $finance->receipt; ?>">
									</div>

									<button type="submit" name="edit" id="edit"
										class="btn btn-success mybutton btn-block"
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
            var form =
                document.getElementById("form").value;
            var term =
                document.getElementById("term").value;
                var amount =
                document.getElementById("amount").value;

            if (amount < 1) {
                window.alert("Please enter a valid amount.");
                event.preventDefault();
                return;
            }

            if (form > 4 || form < 1) {
                window.alert("Please enter a valid form.");
                event.preventDefault();
                return;
            }
            if (term > 3 || term < 1) {
                window.alert("Please enter valid term.");
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