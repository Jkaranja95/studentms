<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$exam_id = trim($_GET["exam_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$score = trim($_POST["score"]);

	$sql = "UPDATE `exams` SET `score` = :score WHERE id = :id";

	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
	$stmt->bindparam(":id", $exam_id);
	$stmt->bindparam(":score", $score);

	$stmt->execute();

	$status = Alert::create('success', 'Update successful', 'Student Updated.');
	header("refresh:3;detail_exam.php?exam_id=" . $exam_id);
}

$exam = Db::get()->get_by_id("exams", $exam_id);
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
					<h1 class="page-header">Edit Score</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Score
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>

									<div class="form-group">
										<label for="score" class="control-label">Score</label>
										<input type="text" name="score" id="score" class="form-control" required="true"
											value="<?php echo $exam->score; ?>">
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
			var score =
				document.getElementById("score").value;
			if (score < 1 || score > 100) {
				window.alert("Please enter a valid score.");
				event.preventDefault();
				return;
			}

		});
	</script>
	</script>
	<!-- Bootstrap Core JavaScript -->
	<script src="../../assets/js/bootstrap.min.js"></script>
	<!-- Metis Menu Plugin JavaScript -->
	<script src="../../assets/metisMenu/metisMenu.min.js"></script>
	<!-- Custom Theme JavaScript -->
	<script src="../../assets/js/admin.js"></script>
</body>

</html>