<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';

$student_id = trim($_GET["student_id"]);

if (isset($_POST["edit"])) {
	//get the request parameters
	$name = trim($_POST["name"]);
    $form = trim($_POST["form"]);
    $stream = trim($_POST["stream"]);
    $contact = trim($_POST["contact"]);
    $address = trim($_POST["address"]);
    $kcpe = trim($_POST["kcpe"]);

	$sql = "UPDATE `students` SET `name` = :name,`form` = :form,`stream` = :stream,`contact` = :contact,`address` = :address, `kcpe` = :kcpe WHERE id = :id";

	$conn = Db::get()->conn;
	$stmt = $conn->prepare($sql);
    $stmt->bindparam(":id", $student_id);
	$stmt->bindparam(":name", $name);
    $stmt->bindparam(":form", $form);
    $stmt->bindparam(":stream", $stream);
    $stmt->bindparam(":contact", $contact);
    $stmt->bindparam(":address", $address);
    $stmt->bindparam(":kcpe", $kcpe);

	$stmt->execute();

	$status = Alert::create('success', 'Update successful', 'Student Updated.');
	header("refresh:3;detail_student.php?student_id=" . $student_id);
}

$student = Db::get()->get_by_id("students", $student_id);
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
					<h1 class="page-header">Edit Student</h1>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-th-list fa-fw"></i>Edit Student
						</div>

						<!-- /.panel-heading -->
						<div class="panel-body">

							<div class="table-responsive" id="reportData">
								<form class="form" method="post" role="form" enctype="multipart/form-data"
									id="add-form">
									<?php if (isset($status))
										echo $status; ?>
									
									<div class="form-group">
										<label for="name" class="control-label">Name</label>
										<input type="text" name="name" id="name" class="form-control" required="true"
											value="<?php echo $student->name; ?>">
									</div>
									<div class="form-group">
										<label for="form" class="control-label">Form</label>
										<input type="number" name="form" id="form" class="form-control" required="true"
											value="<?php echo $student->form; ?>">
									</div>
									<div class="form-group">
										<label for="stream" class="control-label">Stream</label>
										<input type="text" name="stream" id="stream" class="form-control" required="true"
											value="<?php echo $student->stream; ?>">
									</div>
									<div class="form-group">
										<label for="contact" class="control-label">Contact</label>
										<input type="text" name="contact" id="contact" class="form-control" required="true"
											value="<?php echo $student->contact; ?>">
									</div>
									<div class="form-group">
										<label for="address" class="control-label">Address</label>
										<input type="text" name="address" id="address" class="form-control" required="true"
											value="<?php echo $student->address; ?>">
									</div>
									<div class="form-group">
										<label for="kcpe" class="control-label">KCPE</label>
										<input type="text" name="kcpe" id="kcpe" class="form-control" required="true"
											value="<?php echo $student->kcpe; ?>">
									</div>
									<button type="submit" name="edit" id="add-form" class="btn btn-success mybutton btn-block"
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
	<script >
        document.getElementById("add-form").addEventListener("submit", function (event) {
            var phoneno =
                document.getElementById("contact").value;
            var name =
                document.getElementById("name").value;
            var admno =
                document.getElementById("admno").value;
            var form =
                document.getElementById("form").value;
                var kcpe =
                document.getElementById("kcpe").value;


            var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g; //Javascript reGex for Email Validation.
            var regPhone = /^\d{10}$/;									 // Javascript reGex for Phone Number validation.
            var regName = /\d+$/g;			
            
            if (admno < 1) {
                window.alert("Please enter a valid admission number.");
                event.preventDefault();
                return;
            }

            if (form > 4 || form < 1) {
                window.alert("Please enter a valid form.");
                event.preventDefault();
                return;
            }
            if (kcpe > 500 || kcpe < 1) {
                window.alert("Please enter valid KCPE marks.");
                event.preventDefault();
                return;
            }

            if (!regPhone.test(phoneno)) {
                window.alert("Please enter a valid phone number.");
                event.preventDefault();
                return;
            }
            if (name == "" || regName.test(name)) {
                window.alert("Please enter your name properly.");
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