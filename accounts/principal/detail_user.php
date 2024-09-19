<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';

$user_id = $_GET['user_id'];

if (isset($_GET['option'])) {
	$option = $_GET['option'];

	if ($option == "deactivate") {
		$sql = "UPDATE `users` SET `status` = 0 WHERE `id` = $user_id";
		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	} else if ($option == "activate") {
		$sql = "UPDATE `users` SET `status` = 1 WHERE `id` = $user_id";
		$stmt = Db::get()->conn->prepare($sql);
		$stmt->execute();
	}
}
$user = Db::get()->get_by_id("users", $user_id);
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
          <h1 class="page-header">User Details</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-th-list fa-fw"></i>User Details
            </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
              <div class="table-responsive" id="reportData">

                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <td>User ID</td>
                      <td><?php echo $user->id; ?></td>
                    </tr>
                    <tr>
                      <td>Date Added</td>
                      <td><?php echo $user->date; ?></td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td><?php echo $user->name; ?></td>
                    </tr>
                    <tr>
                      <td>Type</td>
                      <td><?php echo $user->type; ?></td>
                    </tr>
                    <tr>
                      <td>Phone</td>
                      <td><?php echo $user->phone; ?></td>
                    </tr>
                    <tr>
                      <?php
                      $status = "DISABLED";
                      if ($user->status == 1) {
                        $status = "ACTIVE";
                      }
                      ?>
                      <td>Status</td>
                      <td><?php echo $status; ?> <?php
												if ($user->status == 1) { ?>
													<a href="?option=deactivate&user_id=<?php echo $user->id; ?>"
														style="font-size: 14px;font-weight: bold; color:#fff;"
														class="btn btn-danger">
														Deactivate
													</a>
												<?php } else { ?>
													<a href="?option=activate&user_id=<?php echo $user->id; ?>"
														style="font-size: 14px;font-weight: bold;  color:#fff;"
														class="btn btn-danger">
														Activate
													</a>
												<?php } ?></td>
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