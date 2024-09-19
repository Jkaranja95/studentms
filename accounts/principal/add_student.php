<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../classes/user.php';
require_once '../../classes/student.php';


if (isset($_POST["add"])) {
    //get the request parameters
    $name = trim($_POST["name"]);
    $admno = trim($_POST["admno"]);
    $form = trim($_POST["form"]);
    $stream = trim($_POST["stream"]);
    $contact = trim($_POST["contact"]);
    $address = trim($_POST["address"]);
    $kcpe = trim($_POST["kcpe"]);

    $std = new Student();
    if ($std->admno_exists($admno)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Admission Number Exists.');
    } else {
        $sql = "INSERT INTO `students` (`admno`,`name`,`form`,`stream`,`contact`,`address`,`kcpe`) VALUES (:admno,:name,:form,:stream,:contact,:address,:kcpe)";

        $conn = Db::get()->conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":admno", $admno);
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":form", $form);
        $stmt->bindparam(":stream", $stream);
        $stmt->bindparam(":contact", $contact);
        $stmt->bindparam(":address", $address);
        $stmt->bindparam(":kcpe", $kcpe);

        $stmt->execute();

        $id = $conn->lastInsertId();

        if ($id) {
            $status = Alert::create('success', 'Save successful', 'Student Added.');
            header("refresh:3;view_students.php");
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

        <?php require('../../includes/principal-nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Student</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Add Student
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
                                        <input type="number" name="admno" id="admno" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="form" class="control-label">Form</label>
                                        <input type="number" name="form" id="form" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="stream" class="control-label">Stream</label>
                                        <input type="text" name="stream" id="stream" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact" class="control-label">Contact</label>
                                        <input type="text" name="contact" id="contact" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="control-label">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="kcpe" class="control-label">KCPE Marks</label>
                                        <input type="number" name="kcpe" id="kcpe" class="form-control" required="true">
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
    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../../assets/js/admin.js"></script>
</body>

</html>