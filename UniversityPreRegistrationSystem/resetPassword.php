<?php session_start(); ?>
<?php include("Database.php"); ?>
<?php
$updatePassword = "";
$site = "";
$obDatabase = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST["password"];
    $updatePassword = $_SESSION["updatePassword"];
    $site = $_SESSION["site"];
    $obDatabase->$updatePassword($password, $_SESSION["RStID"]);
    session_destroy();
    header('Location: ' . $site . '');
}
?>
<?php
if (isset($_GET['id']) && isset($_GET['fp_code'])) {
    $ID = $_GET['id'];
    $hash = $_GET['fp_code'];
    $_SESSION["RStID"] = $ID;
    $hashIdcheck = "studentHashAndIDCheck";
    $site = "studentLogin.php";
    $_SESSION["site"] = $site;
    $updatePassword = "updatePasswordInStudentTable";
    $_SESSION["updatePassword"] = $updatePassword;

    if (isset($_GET['status'])) {
        if ($_GET['status'] == "admin") {
            $hashIdcheck = "adminHashAndIDCheck";
            $updatePassword = "updatePasswordInAdminTable";
            $site = "adminLogin.php";
            $_SESSION["updatePassword"] = $updatePassword;
            $_SESSION["site"] = $site;
        }
    }
    if ($obDatabase->$hashIdcheck($ID, $hash)) {
        ?>
        <div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h3>Reset Password</h3>
                <label for="password">New Password</label><br>
                <input type="password" id="password" name="password" placeholder="Your Password.." required><br>
                <label for="password">Confirm New Password</label><br>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Your Password.." required oninput="check(this)"><br>
                <script language='javascript' type='text/javascript'>
                    function check(input) {
                        if (input.value != document.getElementById('password').value) {
                            input.setCustomValidity('Password Must be Matching.');
                        } else {
                            input.setCustomValidity('');
                        }
                    }
                </script>
                <input type="submit" value="Login">
            </form>
        </div>
        <?php
    } else {
        ?>
        <h3 style="text-align: center"><?php echo "Link Error. Please try again by clicking forgot password from login option"; ?></h3>
        <?php
    }
}
?>















<style>
    input[type=password], select {
        width:100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        width:25%; margin:0 auto;
    }
</style>