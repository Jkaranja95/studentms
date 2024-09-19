
Conversations
4.86 GB of 15 GB used
Terms · Privacy · Program Policies
Last account activity: 20 hours ago
Details
Quick settings
See all settings

Apps in Gmail
Chat and Meet
Customize

Density

Default


Comfortable


Compact

Theme
View all
Default
Inbox type

Default
Customize


Important first


Unread first


Starred first


Priority Inbox
Customize


Multiple Inboxes
Customize


Reading pane

No split


Right of inbox


Below inbox

Email threading
Conversation view

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
    $sickness = trim($_POST["sickness"]);
    $allergies = trim($_POST["allergies"]);
    $treatment = trim($_POST["treatment"]);
    $std = new Student();
    if (!$std->admno_exists($admno)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Wrong Adm No.');
    } else {
        $sql = "INSERT INTO `medical` (`admno`,`sickness`,`allergies`,`treatment`) VALUES (:admno,:sickness,:allergies,:treatment)";

        $conn = Db::get()->conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":admno", $admno);
        $stmt->bindparam(":sickness", $sickness);
        $stmt->bindparam(":allergies", $allergies);
        $stmt->bindparam(":treatment", $treatment);

        $stmt->execute();

        $id = $conn->lastInsertId();

        if ($id) {
            $status = Alert::create('success', 'Save successful', 'Record Added.');
            header("refresh:3;view_medical.php");
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

        <?php require('../../includes/medical-nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Medical</h1>
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
                                        <input type="number" name="admno" id="admno" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="sickness" class="control-label">Sickness</label>
                                        <input type="text" name="sickness" id="sickness" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="allergies" class="control-label">Allergies</label>
                                        <input type="text" name="allergies" id="allergies" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="treatment" class="control-label">Treatment</label>
                                        <input type="text" name="treatment" id="treatment" class="form-control"
                                            required="true">
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