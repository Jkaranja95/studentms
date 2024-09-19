<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$student_id = $_GET['student_id'];
$student = Db::get()->get_by_id("students", $student_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require ('../../includes/acc-head.php'); ?>

<body>

  <div id="wrapper">

    <?php require ('../../includes/club-nav.php'); ?>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Student Details</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-th-list fa-fw"></i>Student Details
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
              <div class="table-responsive" id="reportData">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <td>ID</td>
                      <td><?php echo $student->id; ?></td>
                    </tr>
                    <tr>
                      <td>Date Added</td>
                      <td><?php echo $student->date; ?></td>
                    </tr>
                    <tr>
                      <td>Admission Number</td>
                      <td><?php echo $student->admno; ?></td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td><?php echo $student->name; ?></td>
                    </tr>
                    <tr>
                      <td>Form</td>
                      <td><?php echo $student->form; ?></td>
                    </tr>
                    <tr>
                      <td>Stream</td>
                      <td><?php echo $student->stream; ?></td>
                    </tr>
                    <tr>
                      <td>Contact</td>
                      <td><?php echo $student->contact; ?></td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td><?php echo $student->address; ?></td>
                    </tr>
                    <tr>
                      <td>KCPE</td>
                      <td><?php echo $student->kcpe; ?></td>
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