<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../classes/user.php';
require_once '../../classes/club.php';
require_once '../../classes/student.php';


if (isset($_POST["add"])) {
    //get the request parameters
    $admno = trim($_POST["admno"]);
    $club = trim($_POST["club"]);
    $rank = trim($_POST["rank"]);

    $club_obj = new Club();
	$std_obj = new Student();
	if (!$std_obj->admno_exists($admno)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'wrong admno.');
    } else {
    if ($club_obj->exists($admno, $club)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Record Exists.');
    } else {
        $sql = "INSERT INTO `clubs` (`admno`,`club`,`rank`) VALUES (:admno,:club,:rank)";

        $conn = Db::get()->conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":admno", $admno);
        $stmt->bindparam(":club", $club);
        $stmt->bindparam(":rank", $rank);

        $stmt->execute();

        $id = $conn->lastInsertId();

        if ($id) {
            $status = Alert::create('success', 'Save successful', 'Membership Added.');
            header("refresh:3;view_clubs.php");
        } else {
            $status = Alert::create('danger', 'Save unsuccessful', 'Error Occured.');
        }
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
                    <h1 class="page-header">Club</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Add Membership
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
                                        <input type="text" name="admno" id="admno" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="club" class="control-label">Club</label>
                                        <select class="form-control" name="club" id="club" required="true">
                                            <option>ART</option>
                                            <option>WILDLIFE</option>
                                            <option>CHESS</option>
                                            <option>COOKING</option>
                                            <option>ANIME</option>
                                            <option>DANCE</option>
                                            <option>SCOUT</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="rank" class="control-label">Rank</label>
                                        <select class="form-control" name="rank" id="rank" required="true">
                                            <option>CAPTAIN</option>
                                            <option>ASSISTANT CAPTAIN</option>
                                            <option>MEMBER</option>
                                        </select>
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