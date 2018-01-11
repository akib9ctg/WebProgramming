<?php session_start(); ?>
<?php
include("Database.php");
require('./fpdf.php');
?>
<?php
$obDatabase = new Database();
if (isset($_GET['adminlogout']) && $_GET['adminlogout'] == 1) {
    session_unset();
    header('Location: adminLogin.php');
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['generatePDF'])) {
    $Section=$_GET["section"];
    $CourseCode=$_GET["courseCode"];
    $CourseName=$_GET["courseName"];
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $result = $obDatabase->getStudentInSection($Section, $CourseCode);
    $pdf->Write(5, "Course Code: ". $CourseCode);
    $pdf->Ln();
    $pdf->Write(5, "Section: ". $CourseName);
    $pdf->Ln();
    $pdf->Write(5, "Section: ". $Section);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(90,12,"ID",1);
    foreach ($result as $row) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln();
        foreach ($row as $column)
            $pdf->Cell(90, 12, $column, 1);
    }
    $pdf->Output();
}
?>
<html>
    <title>University Pre-Registration System</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
            text-align: center        }
        th{padding:15px;text-align:center;font-weight:bold;font-size:18px;background-color:#51AEB9;}
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
                                        <li><a href="http://localhost/UniversityPreRegistrationSystem/adminLogin.php">Hi, <?php echo $obDatabase->getAdminNameFromAdminTable($_SESSION["adminID"]) ?></a></li>
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
            <div>
                <br><br><br>
                <h3 style="text-align: center">Courses List for PDF Generate</h3>
                <br>

                <?php
                $obDatabase = new Database();
                $result = $obDatabase->getAllCoursesFromRegistrationTable();
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <h4><?php
                        echo "Course Code: " . $row["courseCode"];
                        $i = 1
                        ?></h4>
                    <table border="2">
                        <thead>
                            <tr>
                                <th style="text-align: center">Sr</th>
                                <th style="text-align: center" >Course Title</th>
                                <th style="text-align: center" >Credit</th>
                                <th style="text-align: center">Section</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result2 = $obDatabase->getSectionFromRegistrationTable($row["courseCode"]);
                            while ($row2 = $result2->fetch_assoc()) {
                                ?>
                        <form method="GET" target="_blank" action="http://localhost/UniversityPreRegistrationSystem/generatepdf.php">
                                <tr style="text-align: center">
                                    <td><?php echo $i++ ?></td>
                                    <td> <?php echo $row["CourseName"]; ?></td>
                                <input type="hidden" value="<?php echo $row["CourseName"] ?>" name="courseName">
                                <input type="hidden"value="<?php echo $row["courseCode"] ?>" name="courseCode">
                                <input type="hidden" value="<?php echo $row2["section"]; ?>"name="section">
                                <td><?php echo $row["CourseCredit"] ?></td>
                                <td><?php echo $row2["section"] . " ( " . $obDatabase->getNumberOfStudentInSection($row2["section"], $row["courseCode"]) . " )"; ?>
                                    <input type="submit" value="Generate PDF" name="generatePDF"></td>
                            </tr>
                        </form>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <?php
                }
                ?>


            <?php } ?>
            </body>   
            <footer>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <p>&copy;2017 University Pre-registration System. All rights reserved | Created by IIUC_While(1){}</p>
                        </div>
                    </div>
                </div>
            </footer>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>

    </body>
</html>