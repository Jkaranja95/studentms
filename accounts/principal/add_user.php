<?php
ob_start();
session_start();
require_once '../../classes/db.php';
require_once '../../classes/alert.php';
require_once '../../classes/user.php';


if (isset($_POST["add"])) {
    //get the request parameters
    $name = trim($_POST["name"]);
    $type = trim($_POST["type"]);
    $phone = trim($_POST["phone"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $user = new User();

    if ($user->user_exists($username)) {
        $status = Alert::create('danger', 'Save unsuccessful', 'Email Exists.');
    } else {
        //insert user
        $salt = "1L2A7B0CFD96A012";
        $pass = sha1($salt . $password);

        $sql = "INSERT INTO `users` (`type`,`name`,`phone`,`username`,`password`) VALUES (:type,:name,:phone,:username,:password)";

        $conn = Db::get()->conn;
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":type", $type);
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":phone", $phone);
        $stmt->bindparam(":username", $username);
        $stmt->bindparam(":password", $pass);

        $stmt->execute();

        $user_id = $conn->lastInsertId();

        if ($user_id) {
            $status = Alert::create('success', 'Save successful', 'User Added.');
            header("refresh:3;view_users.php");
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
                    <h1 class="page-header">Users</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-list fa-fw"></i>Add User
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="table-responsive" id="reportData">
                                <form class="form" method="post" role="form" enctype="multipart/form-data"
                                    id="add-form">
                                    <?php if (isset($status))
                                        echo $status; ?>
                                    <div class="form-group">
                                        <label for="type" class="control-label">Type</label>
                                        <select name="type" id="type" class="form-control" required="true">
                                            <option>PRINCIPAL</option>
                                            <option>TEACHER</option>
                                            <option>CLUB MASTER</option>
                                            <option>SPORT MASTER</option>
                                            <option>NURSE</option>
                                            <option>DISCIPLINARY MASTER</option>
                                            <option>FINANCE</option> 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="control-label">Email</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="control-label">Phone Number</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
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
            var phone =
                document.getElementById("phone").value;
            var name =
                document.getElementById("name").value;
            var username =
                document.getElementById("username").value;
            var password =
                document.getElementById("password").value;

            var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g; //Javascript reGex for Email Validation.
            var regPhone = /^\d{10}$/;									 // Javascript reGex for Phone Number validation.
            var regName = /\d+$/g;								 // Javascript reGex for Name validation


            if (!regPhone.test(phone)) {
                window.alert("Please enter a valid phone number.");
                event.preventDefault();
                return;
            }
            if (name == "" || regName.test(name)) {
                window.alert("Please enter your name properly.");
                event.preventDefault();
                return;
            }
            if (!regEmail.test(username)) {
                window.alert("Please enter a valid email.");
                event.preventDefault();
                return;
            }
            if (password.length < 6) {
                window.alert("Please enter a longer password. Atleast 6 characters");
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