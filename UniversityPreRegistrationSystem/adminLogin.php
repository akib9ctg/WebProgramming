<?php session_start(); ?>
<?php include("Database.php"); ?>
<?php
$adminID = $adminPassword = $success = "";
$adminID = "admin";
$obDatabase = new Database();

if (isset($_GET['adminlogout']) && $_GET['adminlogout'] == 1) {
    session_unset();
}
if (isset($_GET['forgetPassword'])) {
    $hash = md5(rand(0, 1000));
    $obDatabase->updateHashAdminTable($hash, $adminID);
    $success = "Please check your e-mail, we have sent a password reset link to your registered email.";
    $resetPassLink = 'http://localhost/UniversityPreRegistrationSystem/resetPassword.php?fp_code=' . urldecode($hash) . '&id=' . urldecode($adminID) . '&status=' . urldecode("admin");

    //send reset password email
    $to = $obDatabase->getEmailFromAdminTable($adminID);
    $subject = "Password Update Request";
    $mailContent = 'Dear ' . $obDatabase->getNameFromAdminTable($adminID) . ', 
                Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
                To reset your password, visit the following link:  href="' . $resetPassLink . '"
                Regards,
                University PreRegistration System - Powered by IIUC_While(1){}';
    $headers = 'From: University PreRegistration<noreplay@gmail.com>';
    //send email
    mail($to, $subject, $mailContent, $headers);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminID = $_POST["adminID"];
    $adminPassword = $_POST["adminPassword"];
    if ($obDatabase->adminLoginCheck($adminID, $adminPassword) == true) {
        $_SESSION['admin_IS_LOGGED_IN'] = true;
        $_SESSION['adminID'] = $adminID;
        $success = "Login Successful";
        header('Location: adminLogin.php?id=' . $adminID);
    } else {
        $success = "Invalid Admin Username or Password";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['newRegistration'])&& isset($_SESSION['adminID'])) {
    $obDatabase->UpdateAllRegistrationStatus();
    $obDatabase->TruncateRegistrationTable(); //150no line
    $obDatabase->UpdateSemester();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Pre-registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <?php
        if (!isset($_SESSION['admin_IS_LOGGED_IN'])) {
            ?>
            <header class="navbar navbar-fixed-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="main-menu">
                            <div class="col-md-4">
                                <div class="site-logo">
                                    <h4>University Pre-registration System</h4>
                                </div>
                            </div>	
                            <div class="col-md-8">
                                <div class="site-navigation">
                                    <ul class="navigation">
                                        <li><a href="studentLogin.php">Student Login</a></li>
                                        <li><a href="adminLogin.php">Admin Login</a></li>	
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container sm100">
                <div class="row st_login_form">
                    <div class="col-md-offset-3 col-md-6">

                        <div class="login">
                            <h3>Admin Login</h3>
                            <form method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <span>Admin ID</span></br><input type="text" value="" name="adminID" required> </br>
                                <span>Password</span></br><input type="password" value="" name="adminPassword" required></br>
                                <a><button>Login</button></a>
                                <a href="http://localhost/UniversityPreRegistrationSystem/adminLogin.php?forgetPassword=1">Forget Password?</a><br>
                                <label style="align-items: center" ><?php echo $success ?></label>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <header class="navbar navbar-fixed-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="main-menu">
                            <div class="col-md-4">
                                <div class="site-logo">
                                    <h4>University Pre-registration System</h4>
                                </div>
                            </div>	
                            <div class="col-md-8">
                                <div class="site-navigation">
                                    <ul class="navigation">
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/adminLogin.php">Hi, <?php echo $obDatabase->getAdminNameFromAdminTable($_SESSION["adminID"]) ?></a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/generatepdf.php">Generate PDF</a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/pendinglist.php">Pending List</a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/Courses.php">All Courses</a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/allstudents.php">All Students</a></li>    
                                        <li><a href="?adminlogout=1">Logout</a></li>	
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="container sm50" style="width: 55%">
                <div class="row ">
                    <div class="col-md-offset-3 col-md-5 st_profile">

                        <h3>Admin Profile</h3>
                        <?php
                        $result = $obDatabase->getAllDataFromAdminTable($_SESSION["adminID"]);
                        $row = $result->fetch_assoc()
                        ?>
                        <img src="assets/img/profile_st.jpg">


                        <div id="Info">
                            <p>
                                <strong>Name:</strong>
                                <span><?php echo $row['adminName'] ?></span>
                            </p>

                            <p>
                                <strong>Email:</strong>
                                <span><?php echo $row['adminEmail'] ?></span>
                            </p>
                            <p>
                                <strong>Phone            :</strong>
                                <span><?php echo $row['adminMobile'] ?></span>
                            </p>


                        </div>
                    </div>
                </div>
            </div>
        
        <div class="container sm50" style="width: 55%">
            <div class="row ">
                <div class="col-md-offset-3 col-md-5 st_profile">
                    <form method="GET"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                        <input type="submit" value="Open New Semester Registration" name="newRegistration"></td>
                    </form>
                </div>
            </div>
        </div>
<?php } ?>

        <footer>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy;2017 University Pre-registration System. All rights reserved | Created by IIUC_....</p>
                    </div>
                </div>
            </div>

        </footer>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>