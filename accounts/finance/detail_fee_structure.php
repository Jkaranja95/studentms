<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$fs_id = $_GET['fs_id'];
$fs = Db::get()->get_by_id("feestructure", $fs_id);

?>

<!DOCTYPE html>
<html lang="en">

<?php require ('../../includes/acc-head.php'); ?>

<body>

  <div id="wrapper">

    <?php require ('../../includes/finance-nav.php'); ?>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Fee Stucture</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-th-list fa-fw"></i>Fee Structure
              <span class="pull-right" style="margin-top: -7px;">
                <a id="add_property_button" type="button" name="button" class="btn btn-success" href="edit_fee_structure.php?fs_id=<?php echo $fs->id; ?>">
                  <i class="fa fa-plus-square"></i>
                  Edit
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
                      <td><?php echo $fs->id; ?></td>
                    </tr>
                    <tr>
                      <td>Form</td>
                      <td><?php echo $fs->form; ?></td>
                    </tr>
                    <tr>
                      <td>Term</td>
                      <td><?php echo $fs->term; ?></td>
                    </tr>
                    <tr>
                      <td>Amount</td>
                      <td><?php echo $fs->amount; ?></td>
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