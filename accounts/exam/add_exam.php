<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../classes/exam.php';


if (isset($_POST["add"])) {
    //get the request parameters
    $type = trim($_POST["type"]);
    $admno = trim($_POST["admno"]);
    $form = trim($_POST["form"]);
    $term = trim($_POST["term"]);
    $subject = trim($_POST["subject"]);
    $exam = new Exam();
    $student = Db::get()->get_by("students","admno",$admno)[0];
    if ($exam->exists($type, $admno, $form, $term, $subject)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Record Exists.');
    } if ($student->form < $form) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Student not in that class.');
    }else {
        //check whether all exams are available
        if ($type == "OVERALL") {
            $cat1_exist = $exam->exists("CAT 1", $admno, $form, $term, $subject);
            $cat2_exist = $exam->exists("CAT 2", $admno, $form, $term, $subject);
            $end_term_exist = $exam->exists("END TERM", $admno, $form, $term, $subject);

            if ($cat1_exist == false || $cat2_exist == false || $end_term_exist == false) {
                $status = Alert::create('danger', 'Save unsuccessful', 'MISSING MARKS.');
            } else {
                $cat1_score = $exam->get_score("CAT 1", $admno, $form, $term, $subject);
                $cat2_score = $exam->get_score("CAT 2", $admno, $form, $term, $subject);
                $end_term_score = $exam->get_score("END TERM", $admno, $form, $term, $subject);

                $score = ($cat1_score + $cat2_score) / 2 + $end_term_score;

                $sql = "INSERT INTO `exams` (`admno`,`type`,`form`,`term`,`subject`,`score`) VALUES (:admno,:type,:form,:term,:subject,:score)";

                $conn = Db::get()->conn;
                $stmt = $conn->prepare($sql);
                $stmt->bindparam(":admno", $admno);
                $stmt->bindparam(":type", $type);
                $stmt->bindparam(":form", $form);
                $stmt->bindparam(":term", $term);
                $stmt->bindparam(":subject", $subject);
                $stmt->bindparam(":score", $score);

                $stmt->execute();

                $id = $conn->lastInsertId();

                if ($id) {
                    $status = Alert::create('success', 'Save successful', 'Exam Added.');
                    header("refresh:3;view_exams.php");
                } else {
                    $status = Alert::create('danger', 'Save unsuccessful', 'Error Occured.');
                }

            }
        } else {
            $score = trim($_POST["score"]);

            $sql = "INSERT INTO `exams` (`admno`,`type`,`form`,`term`,`subject`,`score`) VALUES (:admno,:type,:form,:term,:subject,:score)";

            $conn = Db::get()->conn;
            $stmt = $conn->prepare($sql);
            $stmt->bindparam(":admno", $admno);
            $stmt->bindparam(":type", $type);
            $stmt->bindparam(":form", $form);
            $stmt->bindparam(":term", $term);
            $stmt->bindparam(":subject", $subject);
            $stmt->bindparam(":score", $score);

            $stmt->execute();

            $id = $conn->lastInsertId();

            if ($id) {
                $status = Alert::create('success', 'Save successful', 'Exam Added.');
                header("refresh:3;view_exams.php");
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
<style>
    .hidden {
        display: none;
        visibility: hidden;
    }
</style>

<body>

    <div id="wrapper">

        <?php require('../../includes/exam-nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Exam</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Add Exam
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
                                        <label for="type" class="control-label">Exam Type</label>
                                        <select name="type" id="type" class="form-control" required="true">
                                            <option>CAT 1</option>
                                            <option>CAT 2</option>
                                            <option>END TERM</option>
                                            <option>OVERALL</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="form" class="control-label">Form</label>
                                        <input type="number" name="form" id="form" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="term" class="control-label">Term</label>
                                        <input type="number" name="term" id="term" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject" class="control-label">Subject</label>
                                        <select name="subject" id="subject" class="form-control" required="true">
                                            <option>MATHS</option>
                                            <option>ENGLISH</option>
                                            <option>KISWAHILI</option>
                                            <option>CHEMISTRY</option>
                                            <option>PHYSICS</option>
                                            <option>BIOLOGY</option>
                                            <option>HISTORY</option>
                                            <option>GEOGRAPHY</option>
                                            <option>CRE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="score" class="control-label" id="score_lbl">Score</label>
                                        <input type="number" name="score" id="score" class="form-control">
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
        var select = document.getElementById("type");
        var add = document.getElementById("add");
        var lbl_score = document.getElementById("score_lbl");
        var score = document.getElementById("score");
        select.addEventListener("change", function (event) {
            if (select.value == "OVERALL") {
                lbl_score.classList.add("hidden");
                score.classList.add("hidden");
                add.innerHTML = "GENERATE";
            } else {
                lbl_score.classList.remove("hidden");
                score.classList.remove("hidden");
                add.innerHTML = "ADD";
            }
        });


        document.getElementById("add-form").addEventListener("submit", function (event) {
            var admno =
                document.getElementById("admno").value;
            var form =
                document.getElementById("form").value;
            var term =
                document.getElementById("term").value;
            var type =
                document.getElementById("type").value;
            if (type !== "OVERALL") {
                var score =
                    document.getElementById("score").value;
                if (score < 1 || score > 100) {
                    window.alert("Please enter a valid score.");
                    event.preventDefault();
                    return;
                }
            }

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