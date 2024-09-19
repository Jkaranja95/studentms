<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$disc_id = trim($_GET["disc_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$case = trim($_POST["case"]);
    $punishment = trim($_POST["punishment"]);


	$sql = "UPDATE `disciplinary` SET `case` = :case,`punishment` = :punishment WHERE id = :id";

	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
    $stmt->bindparam(":id", $disc_id);
	$stmt->bindparam(":case", $case);
    $stmt->bindparam(":punishment", $punishment);

	$stmt->execute();

	$status = Alert::create('success', 'Update successful', 'Disciplinary Updated.');
	header("refresh:3;detail_disciplinary.php?disc_id=" . $disc_id);
}

$disc = Db::get()->get_by_id("disciplinary", $disc_id);
?>

<!DOCTYPE html>
<html lang="en">

<?php require ('../../includes/acc-head.php'); ?>

<body>

	<div id="wrapper">

		<?php require ('../../includes/disciplinary-nav.php'); ?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Edit Case</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Case
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>
									
									<div class="form-group">
										<label for="case" class="control-label">Case</label>
										<input type="text" name="case" id="case" class="form-control" required="true"
											value="<?php echo $disc->case; ?>">
									</div>
									<div class="form-group">
										<label for="punishment" class="control-label">Punishment</label>
										<input type="text" name="punishment" id="punishment" class="form-control" required="true"
											value="<?php echo $disc->punishment; ?>">
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
			var admno =
                document.getElementById("admno").value;
            if (admno < 1) {
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