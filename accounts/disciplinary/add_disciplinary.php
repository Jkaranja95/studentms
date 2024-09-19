<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../classes/user.php';
require_once '../../classes/student.php';


if (isset($_POST["add"])) {
    //get the request parameters
    $admno = trim($_POST["admno"]);
    $case = trim($_POST["case"]);
    $punishment = trim($_POST["punishment"]);
$std_obj = new Student();
	if (!$std_obj->admno_exists($admno)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'wrong admno.');
    } else {
    $sql = "INSERT INTO `disciplinary` (`admno`,`case`,`punishment`) VALUES (:admno,:case,:punishment)";

    $conn = Db::get()->conn;
    $stmt = $conn->prepare($sql);
    $stmt->bindparam(":admno", $admno);
    $stmt->bindparam(":case", $case);
    $stmt->bindparam(":punishment", $punishment);

    $stmt->execute();

    $id = $conn->lastInsertId();
    if ($id) {
        $status = Alert::create('success', 'Save successful', 'Record Added.');
        header("refresh:3;view_disciplinary.php");
    } else {
        $status = Alert::create('danger', 'Save unsuccessful', 'Error Occured.');
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require('../../includes/acc-head.php'); ?>

<body>

    <div id="wrapper">

        <?php require('../../includes/disciplinary-nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Disciplinary</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Add Record
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="table-responsive" id="reportData">
                                <form class="form" method="post" role="form" enctype="multipart/form-data"
                                    id="add-form">
                                    <?php if (isset($status))
                                        echo $status; ?>

                                    <div class="form-group">
                                        <label for="admno" class="control-label">Admission Number</label>
                                        <input type="number" name="admno" id="admno" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="case" class="control-label">Case</label>
                                        <input type="text" id="case" name="case" class="form-control" required="true">
                                    </div>


                                    <div class="form-group">
                                        <label for="punishment" class="control-label">Punishment</label>
                                        <input type="text" id="punishment" name="punishment" class="form-control" required="true">
                                    </div>


                                    <button type="submit" name="add" id="add" class="btn btn-success mybutton btn-block"
                                        style="margin-top:10px;">Add</button>
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