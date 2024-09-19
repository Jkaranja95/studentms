<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../loginchecker.php';



if (isset($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
} else {
  $pageno = 1;
}
$records_no_per_page = 15;
$offset = ($pageno - 1) * $records_no_per_page;
$sqlArr = array();
if (isset($_GET['search'])) {
  if (!empty($_GET['form'])) {
    $sqlArr[count($sqlArr)] = "form = :form";
  }
}
$sql = "";
$i = 1;
foreach ($sqlArr as $value) {
  if ($i === count($sqlArr)) {
    $sql = $sql . $value;
    break;
  }
  $sql = $sql . $value . " AND ";
  $i++;
}
$conn = Db::get()->conn;

if (count($sqlArr)) {
  $count_sql = "SELECT * FROM `feestructure` WHERE $sql ORDER BY `id` DESC";
  $result_sql = "SELECT * FROM `feestructure` WHERE $sql ORDER BY `id` DESC LIMIT $offset , $records_no_per_page";
} else {
  $count_sql = "SELECT * FROM `feestructure` WHERE 1 ORDER BY `id` DESC";
  $result_sql = "SELECT * FROM `feestructure` WHERE 1 ORDER BY `id` DESC LIMIT $offset , $records_no_per_page ";
}

$count_stmt = $conn->prepare($count_sql);
$result_stmt = $conn->prepare($result_sql);

if (isset($_GET['search'])) {
  if (!empty($_GET['form'])) {
    $admno = $_GET['form'];
    $count_stmt->bindparam(":form", $form);
    $result_stmt->bindparam(":form", $form);
  }
}
$count_stmt->execute();
$result_stmt->execute();

$total_records = $count_stmt->fetch()[0] ?? 0;

$total_pages = ceil($total_records / $records_no_per_page);

$table_rows = $result_stmt->fetchAll(PDO::FETCH_OBJ);

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
          <h1 class="page-header">Fee Structure</h1>
        </div>
        <div class="container" style="margin-bottom:10px;">
          <form class="form">
            <div class="row">
              <div class="col-sm-2">
                <label>Form</label>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <input class="form-control" type="text" name="form" id="form" value="<?php
                  if (isset($_GET['form'])) {
                    echo $_GET['form'];
                  } else {
                    echo '';
                  } ?>">
                </div>
              </div>


              <div class="col-sm-2">
                <button type="submit" name="search" id="search" class="btn btn-success btn-block">Search</button>
              </div>

            </div>
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-th-list fa-fw"></i>Fee Structure
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">

              <div class="table-responsive" id="reportData">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr class="info">
                      <th colspan="15" class="text-center"> Fee Structure</th>
                    </tr>
                    <tr>
                      <th>Id</th>
                      <th>Form</th>
                      <th>Term</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php
                    if (!count($table_rows)) {
                      ?>
                      <tr>
                        <td colspan="3">
                          <strong>SORRY: </strong> No Records Found.
                        </td>
                      </tr>
                      <?php
                    }
                    ?>
                    <?php
                    foreach ($table_rows as $row) { ?>
                      <tr>
                        <td><?php echo $row->id; ?></td>
                        <td><?php echo $row->form; ?></td>
                        <td><?php echo $row->term; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td>
                          <a href="detail_fee_structure.php?fs_id=<?php echo $row->id; ?>"
                            style="color: blue; margin-left: 10px;">View More</a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="row" style="text-align: center;">
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" id="first_page"
                        href="javascript:paginate('<?php echo '1'; ?>')">First Page</a></li>
                    <li class="page-item <?php if ($pageno <= 1) {
                      echo 'disabled';
                    } ?>">
                      <a id="prev_page" class="page-link" href="javascript:paginate('<?php if ($pageno <= 1) {
                        echo '#';
                      } else {
                        echo $pageno - 1;
                      } ?>')">Prev</a>
                    </li>

                    <li class="page-item <?php if ($pageno >= $total_pages) {
                      echo 'disabled';
                    } ?>"><a id="prev_page" class="page-link" href="javascript:paginate('<?php if ($pageno >= $total_pages) {
                       echo '#';
                     } else {
                       echo $pageno + 1;
                     } ?>')">Next</a>
                    </li>
                    <li><a id="prev_page" class="page-link"
                        href="javascript:paginate('<?php echo $total_pages == 0 ? $pageno : $total_pages; ?>')">Last
                        Page</a></li>
                  </ul>
                </nav>
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

        <script>
          function paginate(page_no) {
            var href = new URL(window.location.href);
            href.searchParams.set('pageno', page_no);
            window.location = href.toString();
          }
        </script>
</body>

</html>