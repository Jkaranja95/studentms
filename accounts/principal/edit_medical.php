<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$med_id = trim($_GET["med_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$sickness = trim($_POST["sickness"]);
    $allergies = trim($_POST["allergies"]);
    $treatment = trim($_POST["treatment"]);

	$sql = "UPDATE `medical` SET `sickness` = :sickness,`allergies` = :allergies,`treatment` = :treatment WHERE id = :id";

	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
    $stmt->bindparam(":id", $med_id);
	$stmt->bindparam(":sickness", $sickness);
    $stmt->bindparam(":allergies", $allergies);
    $stmt->bindparam(":treatment", $treatment);
   
	$stmt->execute();

	$status = Alert::create('success', 'Update successful', 'Record Updated.');
	header("refresh:3;detail_medical.php?med_id=" . $med_id);
}

$medical = Db::get()->get_by_id("medical", $med_id);
?>

<!DOCTYPE html>
<html lang="en">

<?php require ('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require ('../../includes/principal-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edit Medical</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Record
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>
									
									<div class="form-group">
										<label for="sickness" class="control-label">Sickness</label>
										<input type="text" name="sickness" id="sickness" class="form-control" required="true"
											value="<?php echo $medical->sickness; ?>">
									</div>
									<div class="form-group">
										<label for="allergies" class="control-label">Allergies</label>
										<input type="text" name="allergies" id="allergies" class="form-control" required="true"
											value="<?php echo $medical->allergies; ?>">
									</div>
									<div class="form-group">
										<label for="treatment" class="control-label">Treatment</label>
										<input type="text" name="treatment" id="treatment" class="form-control" required="true"
											value="<?php echo $medical->treatment; ?>">
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
			//input validation
			var price = document.getElementById("price");

			if(price.value < 1000){
				alert("Enter a valid room price");
				event.preventDefault();
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