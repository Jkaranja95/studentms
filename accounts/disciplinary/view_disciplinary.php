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
    if (!empty($_GET['admno'])) {
        $sqlArr[count($sqlArr)] = "admno = :admno";
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
    $count_sql = "SELECT * FROM `disciplinary` WHERE $sql ORDER BY `id` DESC";
    $result_sql = "SELECT * FROM `disciplinary` WHERE $sql ORDER BY `id` DESC LIMIT $offset , $records_no_per_page";
} else {
    $count_sql = "SELECT * FROM `disciplinary` WHERE 1 ORDER BY `id` DESC";
    $result_sql = "SELECT * FROM `disciplinary` WHERE 1 ORDER BY `id` DESC LIMIT $offset , $records_no_per_page ";
}

$count_stmt = $conn->prepare($count_sql);
$result_stmt = $conn->prepare($result_sql);

if (isset($_GET['search'])) {
    if (!empty($_GET['admno'])) {
        $admno = $_GET['admno'];
        $count_stmt->bindparam(":admno", $admno);
        $result_stmt->bindparam(":admno", $admno);
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

<?php require('../../includes/acc-head.php'); ?>

<body>

    <div id="wrapper">

        <?php require('../../includes/disciplinary-nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Disciplinary</h1>
                </div>
                <div class="container" style="margin-bottom:10px;">
                    <form class="form">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Admission Number</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="admno" id="admno" value="<?php
                                    if (isset($_GET['admno'])) {
                                        echo $_GET['admno'];
                                    } else {
                                        echo '';
                                    } ?>">
                                </div>
                            </div>


                            <div class="col-sm-2">
                                <button type="submit" name="search" id="search"
                                    class="btn btn-success btn-block">Search</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Disciplinary
                            <span class="pull-right" style="margin-top: -7px;">
                                <a id="add_property_button" type="button" name="button" class="btn btn-success"
                                    href="add_disciplinary.php">
                                    <i class="fa fa-plus-square"></i>
                                    Add record
                                </a>
                            </span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="table-responsive" id="reportData">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th colspan="15" class="text-center"> Disciplinary</th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th>Adm No</th>
                                            <th>Name</th>
                                            <th>Case</th>
                                            <th>Punishment</th>
                                            <th>Status</th>
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
                                                <td><?php echo $row->date; ?></td>
                                                <td><?php echo $row->admno; ?></td>
                                                <?php $student = Db::get()->get_by("students", "admno", $row->admno)[0]; ?>
                                                <td><?php echo $student->name; ?></td>
                                                <td><?php echo $row->case; ?></td>
                                                <td><?php echo $row->punishment; ?></td>
                                                <?php
                                                $status = ($row->status == 1) ? "ACTIVE" : "DEACTIVATED";
                                                ?>
                                                <td><?php echo $status; ?></td>
                                                <td>
                                                    <a href="detail_disciplinary.php?disc_id=<?php echo $row->id; ?>"
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