<?php session_start(); ?>
<?php include("Database.php"); ?>
<?php require_once("StudentClass.php"); ?>
<?php
$ID = $password = $success = "";
$RstudentID = "";
$obDatabase=new Database();
$ob2Database=new Database();
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_unset();
}
if (isset($_SESSION["RStID"])) {
    $RstudentID = $_SESSION["RStID"];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["id"]) && isset($_POST["password"])) {
    $ID = $_POST["id"];
    $password = $_POST["password"];
    $obDatabase = new Database();
    if ($obDatabase->studentLoginCheck($ID, $password) == true) {
        $_SESSION['IS_LOGGED_IN'] = true;
        $_SESSION['id'] = $ID;
        $success = "Login Successful";
        header('Location: studentLogin.php?id=' . $ID);
    } else {
        $success = "Invalid Student ID or Password";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["CourseName"]) && isset($_GET["CourseCode"]) && isset($_GET["addtolist"])) {
    $ID = $_SESSION['id'];
    $courseCode = $_GET['CourseCode'];
    $courseName = $_GET['CourseName'];
    $courseCredit = $_GET['Credit'];
    $obDatabase = new Database();
    $semester = $obDatabase->getSemesterFromStudentTable($ID);
    $code = $courseCode[strlen($courseCode) - 3];
    $section = $obDatabase->getSectionFromStudentTable($ID);
    if ($code == $semester) {
        $obDatabase->addCoursesInRegistraionTable($courseCode, $courseName, $courseCredit, $ID, $section);
    } else {
        $obDatabase->addCoursesInRegistraionTable($courseCode, $courseName, $courseCredit, $ID, "Pending");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["CourseCode"]) && isset($_GET["removefromlist"])) {

    $ID = $_SESSION['id'];
    $courseCode = $_GET['CourseCode'];
    $obDatabase = new Database();
    $obDatabase->RemoveCoursesFromRegistrationTable($courseCode, $ID);
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["confirm"])) {
    
    $ID = $_SESSION['id'];
    $obDatabase = new Database();
    $obDatabase->updateRegistrationStatusInStudentTable($ID,true);
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
        if (!isset($_SESSION['IS_LOGGED_IN'])) {
            ?>
            <header class="navbar navbar-fixed-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="main-menu " >
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
            <br><br><br>

            <div class="container">
                <div class="row st_login_form">
                    <div class="col-md-offset-3 col-md-6">
                        <div class="login">
                            <h3>Student Login</h3>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <span>Student ID</span></br>
                                <input type="text" id="id" name="id" style="text-transform:uppercase"  required></br>
                                <span>Password</span></br>
                                <input type="password" id="password" name="password" required></br>
                                <a><button>Login</button></a>
                                <a href="ForgotPassword.php">forget password?</a>
                                <span ><?php echo $success ?></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $dataBaseObj = new Database();
            $studentClassOB = new StudentClass();
            $studentClassOB = $dataBaseObj->getAllInformationFromStudentTable($_SESSION['id']);
            if ($studentClassOB->registrationStatus == 0) {
                $status = "Not Completed";
            } else {
                $status = "Completed";
            }
            ?>
            <header header class="navbar navbar-fixed-top">
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
                                        <li><a href=""><?php echo $studentClassOB->studentName; ?>, You are logged in as: <?php echo $_SESSION['id']; ?></a></li>
                                        <li><a href='?logout=1'>Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <br><br><br>
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4 st_profile">
                        <h3>Student Profile</h3>
                        <img src="assets/img/profile_st.jpg">
                        <div id="Info">
                            <p>
                                <strong>Name:</strong>
                                <span><?php echo $studentClassOB->studentName; ?></span>
                            </p>
                            <p>
                                <strong>ID:</strong>
                                <span><?php echo $_SESSION['id']; ?></span>
                            </p>
                            <p>
                                <strong>Semester:</strong>
                                <span><?php echo $studentClassOB->semester; ?></span>
                            </p>
                            <p>
                                <strong>Section:</strong>
                                <span><?php echo $studentClassOB->semester . $studentClassOB->section; ?></span>
                            </p>
                            <p>
                                <strong>Email:</strong>
                                <span><?php echo $studentClassOB->email; ?></span>
                            </p>
                            <p>
                                <strong>Phone:</strong>
                                <span><?php echo $studentClassOB->contactNumber; ?></span>
                            </p>
                            <p>
                                <strong>Registration Status:</strong>
                                <span><?php echo $status; ?></span>
                            </p>
                        </div>
                    </div>
                    <?php if ($ob2Database->getRegistrationStatusFromStudentTable($_SESSION['id']) == 0) { ?>
                    <div class="container">
                        <div class="row registered table">
                            <div class="col-md-12">
                                <h3>Registered Courses</h3>
                                <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <button class="btn-success confirm"><input type="hidden" name="confirm" value="ok">Confirm Registration</button>
                                </form>
                                <table border="2">

                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Credit</th>
                                            <th>Section</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <?php
                                    $ob2Database = new Database();
                                    $result2 = $ob2Database->StudentCourseFromRegistrationTable($_SESSION['id']);
                                    $i = 1;
                                    while ($row = $result2->fetch_assoc()) {
                                        ?>
                                        <tbody>
                                        <form method="GET"action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >

                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td ><input type="hidden"value="<?php echo $row["courseCode"] ?>" name="CourseCode"><?php echo $row["courseCode"] ?></td>
                                                <td><?php echo $row["CourseName"] ?></td>
                                                <td><?php echo $row["CourseCredit"] ?></td>
                                                <td><?php echo $row["section"] ?></td>
                                                <td><input type="submit" value="Remove" name="removefromlist"></td>
                                            </tr>
                                        </form>

                                    <?php } ?>

                                    </tbody>


                                </table>

                            </div>
                        </div>
                    </div>
                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h3>All Courses</h3>
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo1" aria-expanded="false" aria-controls="collapseTwo ">1st Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo1" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("1");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>

                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo2" 
                                           aria-expanded="false" aria-controls="collapseTwo ">2nd Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo2" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("2");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>

                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo3" 
                                           aria-expanded="false" aria-controls="collapseTwo ">3rd Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo3" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("3");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>

                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div

                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo4" 
                                           aria-expanded="false" aria-controls="collapseTwo ">4th Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo4" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("4");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>
                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo5" 
                                           aria-expanded="false" aria-controls="collapseTwo ">5th Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo5" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("5");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>
                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo6" 
                                           aria-expanded="false" aria-controls="collapseTwo ">6th Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo6" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("6");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>
                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo7" 
                                           aria-expanded="false" aria-controls="collapseTwo ">7th Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo7" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("7");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>
                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row registered table">
                                <div class="col-md-12">
                                    <h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo8"
                                           aria-expanded="false" aria-controls="collapseTwo ">8th Semester Courses</a></h4>
                                    <div class="answer collapse" id="collapseTwo8" role="tabpanel" aria-labelledby="headingTwo">
                                        <table border="2">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Title</th>
                                                    <th>Credit</th>
                                                    <th>status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $obDatabase = new Database();
                                                $result = $obDatabase->courseFromCourseTable("8");
                                                while ($row = $result->fetch_assoc()) {
                                                    ?><form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                                    <tr>
                                                        <td><input type="hidden"value="<?php echo $row["CourseCode"] ?>" name="CourseCode"><?php echo $row["CourseCode"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["CourseName"] ?>" name="CourseName"><?php echo $row["CourseName"] ?></td>
                                                        <td><input type="hidden"value="<?php echo $row["Credit"] ?>" name="Credit"><?php echo $row["Credit"] ?></td>
                                                        <td><input type="submit" value="Add to List" name="addtolist"></td>
                                                    </tr>

                                                </form>
                                            <?php } ?>
                                            </tbody>


                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>




                    <?php }else{?>
                        <div class="container">
                        <div class="row registered table">
                            <div class="col-md-12">
                                <h3>Registered Courses</h3>
                                <form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                                </form>
                                <table border="2">

                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Credit</th>
                                            <th>Section</th>

                                        </tr>
                                    </thead>
                                    <?php
                                    $ob2Database = new Database();
                                    $result2 = $ob2Database->StudentCourseFromRegistrationTable($_SESSION['id']);
                                    $i = 1;
                                    while ($row = $result2->fetch_assoc()) {
                                        ?>
                                        <tbody>
                                        <form method="GET" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>

                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td ><input type="hidden"value="<?php echo $row["courseCode"] ?>" name="CourseCode"><?php echo $row["courseCode"] ?></td>
                                                <td><?php echo $row["CourseName"] ?></td>
                                                <td><?php echo $row["CourseCredit"] ?></td>
                                                <td><?php echo $row["section"] ?></td>
                                            </tr>
                                        </form>

                                    <?php } ?>

                                    </tbody>


                                </table>

                            </div>
                        </div>
                    </div>
                    <?php }
                }
                ?>
                <main></main>
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