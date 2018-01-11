<?php session_start(); ?>
<?php include("Database.php"); ?>
<?php
$obDatabase =new Database();
if (isset($_GET['adminlogout']) && $_GET['adminlogout'] == 1) {
    session_unset();
    header('Location: adminLogin.php');
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $obDatabase = new Database();
    $studentClassOB = new StudentClass();
    $courseCode = $_POST["courseCode"];
    $courseName = $_POST["courseName"];
    $courseCredit = $_POST["courseCredit"];
    $obDatabase->addCoursesInCoursesTable($courseCode, $courseName, $courseCredit);
    header("Refresh:0");
}
?>
<html>
    <title>University Pre-Registration System</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 80%;
            margin-left: auto;
            margin-right: auto;        }
       th{padding:15px;text-align:center;font-weight:bold;font-size:18px;background-color:#51AEB9; height: 35px;}
       
        tr td{padding:5px;text-align:center;font-size:15px}

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
    <body>
        <?php
        if (!isset($_SESSION['admin_IS_LOGGED_IN'])) {
            ?>
            <h1>Access Denied!!!</h1>
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
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/adminLogin.php">Hi, <?php echo $obDatabase->getAdminNameFromAdminTable($_SESSION["adminID"])?></a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/pendinglist.php">Pending List</a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/Courses.php">All Courses</a></li>
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/allstudents.php">All Students</a></li>
                                        <li><a onclick="document.getElementById('modal-wrapper').style.display = 'block'">Add COurse</a></li>
                                        <li><a href="?adminlogout=1">Logout</a></li>	
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div>
                <br><br><br>
                 <h3 style="text-align: center">All Courses</h3>
                 <br>

                <?php
                for ($i = 1; $i <= 8; $i++) {
                    if ($i == 1) {
                        $str = "1st";
                    } else if ($i == 2) {
                        $str = "2nd";
                    } else if ($i == 3) {
                        $str = "3rd";
                    } else {
                        $str = $i . "th";
                    }
                    ?>
                    <h4 style="text-align: center"><u><?php echo $str ?> Semester Courses</u></h4>
                    <table border="2">
                        <tr>
                            <th style="text-align: center">Sr</th>
                            <th style="text-align: center">Course Code</th>
                            <th style="text-align: center">Course Name</th>
                            <th style="text-align: center">Course Credit</th>
                            <th style="text-align: center">Total Registered</th>
                            <?php
                            $sr=1;
                            $obDatabase = new Database();
                            $result = $obDatabase->courseFromCourseTable($i . "");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                            <tr>
                                <td><?php echo $sr++;?></td>
                                <td><?php echo $row["CourseCode"] ?></td>
                                <td><?php echo $row["CourseName"] ?></td>
                                <td><?php echo $row["Credit"] ?></td>
                                <td><?php echo $obDatabase->getTotalNumberOfRegisteredStudent($row["CourseCode"]);?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tr>
                    </table>
                    <br>
                <?php }
                ?>
            </div>
            <br>
        <?php }
        ?>

        <div id="modal-wrapper" class="modal">

            <form class="modal-content animate" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <div class="imgcontainer">
                    <span onclick="document.getElementById('modal-wrapper').style.display = 'none'" class="close" title="Close PopUp">&times;</span>
                    <h2 style="text-align:center">Add Course</h2>
                </div>

                <div class="container">
                    <br><input style="text-transform:uppercase" type="text" placeholder="Enter Course Code" name="courseCode" required><br>
                    <input type="text" placeholder="Enter Course Name" name="courseName" required><br>
                    <input type="text" placeholder="Enter Credit no:" name="courseCredit" required><br>
                    <button type="submit">Submit</button>
                </div>

            </form>

        </div>
        <script>
            // If user clicks anywhere outside of the modal, Modal will close

            var modal = document.getElementById('modal-wrapper');
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <style>
            *{margin:0px; padding:0px; font-family:Helvetica, Arial, sans-serif;}

            /* Full-width input fields */
            input[type=text], input[type=password] {
                width: 40%;
                padding: 12px 20px;
                margin: 8px 26px;
                display: inline-block;
                border: 1px solid #ccc;
                box-sizing: border-box;
                font-size:16px;
            }

            /* Set a style for all buttons */
            button {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 26px;
                border: none;
                cursor: pointer;
                font-size:20px;
            }
            button:hover {
                opacity: 0.8;
            }

            /* Center the image and position the close button */
            .imgcontainer {
                text-align: center;
                margin: 24px 0 12px 0;
                position: relative;
            }
            .avatar {
                width: 200px;
                height:200px;
                border-radius: 50%;
            }

            /* The Modal (background) */
            .modal {
                display:none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.4);
            }

            /* Modal Content Box */
            .modal-content {
                background-color: #fefefe;
                margin: 4% auto 15% auto;
                border: 1px solid #888;
                width: 40%; 
                padding-bottom: 30px;
            }

            /* The Close Button (x) */
            .close {
                position: absolute;
                right: 25px;
                top: 0;
                color: #000;
                font-size: 35px;
                font-weight: bold;
            }
            .close:hover,.close:focus {
                color: red;
                cursor: pointer;
            }

            /* Add Zoom Animation */
            .animate {
                animation: zoom 0.6s
            }
            @keyframes zoom {
                from {transform: scale(0)} 
                to {transform: scale(1)}
            }
        </style>

    </body>   
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