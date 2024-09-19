<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';
require_once '../../classes/exam.php';

$exam_id = $_GET['exam_id'];
$exam = Db::get()->get_by_id("exams", $exam_id);

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
          <h1 class="page-header">Exam Details</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-th-list fa-fw"></i>Exam Details
              <span class="pull-right" style="margin-top: -7px;">
                <a id="add_property_button" type="button" name="button" class="btn btn-success" href="edit_exam.php?exam_id=<?php echo $exam->id; ?>">
                  <i class="fa fa-plus-square"></i>
                  Edit Score
                </a>
              </span>
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
              <div class="table-responsive" id="reportData">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <td>ID</td>
                      <td><?php echo $exam->id; ?></td>
                    </tr>
                    <tr>
                      <td>Date Added</td>
                      <td><?php echo $exam->date; ?></td>
                    </tr>
                    <tr>
                      <td>Admission Number</td>
                      <td><?php echo $exam->admno; ?></td>
                    </tr>
                    <tr>
                      <td>Type</td>
                      <td><?php echo $exam->type; ?></td>
                    </tr>
                    <tr>
                      <td>Form</td>
                      <td><?php echo $exam->form; ?></td>
                    </tr>
                    <tr>
                      <td>Term</td>
                      <td><?php echo $exam->term; ?></td>
                    </tr>
                    <tr>
                      <td>Subject</td>
                      <td><?php echo $exam->subject; ?></td>
                    </tr>
                    <tr>
                      <td>Score</td>
                      <td><?php   $exam_obj = new Exam(); echo $exam->type == "OVERALL" ? $exam->score." - ".$exam_obj->grade($exam->score):$exam->score; ?> </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require '../../includes/footer.php'; ?>
  <!-- Bootstrap Core JavaScript -->
  <script src="../../assets/js/bootstrap.min.js"></script>
  <!-- Metis Menu Plugin JavaScript -->
  <script src="../../assets/metisMenu/metisMenu.min.js"></script>
  <!-- Custom Theme JavaScript -->
  <script src="../../assets/js/admin.js"></script>
</body>

</html>