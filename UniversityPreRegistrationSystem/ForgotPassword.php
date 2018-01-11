<?php session_start(); ?>
<?php include("Database.php"); ?>
<?php
$success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST["id"];
    $email = $_POST["email"];
    $obDatabase = new Database();
    if ($obDatabase->studentEmailCheck($ID, $email) == true) {
        $hash = md5(rand(0, 1000));
        $obDatabase->updateHashStudentTable($hash, $ID);
        $success = "Please check your e-mail, we have sent a password reset link to your registered email.";
        $resetPassLink = 'http://localhost/UniversityPreRegistrationSystem/resetPassword.php?fp_code=' . urldecode($hash) . '&id=' . urldecode($ID);

        //send reset password email
        $to = $email;
        $subject = "Password Update Request";
        $mailContent = 'Dear ' . $obDatabase->getNameFromStudentTable($ID) . ', 
                Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
                To reset your password, visit the following link:  href="' . $resetPassLink . '"
                Regards,
                University PreRegistration System - Powered by IIUC_While(1){}';
        //additional headers
        $headers = 'From: University PreRegistration<noreplay@gmail.com>';
        //send email
        mail($to, $subject, $mailContent, $headers);
        //header('Location: studentLogin.php');  
    } else {
        $success = "Invalid Student ID or Email";
    }
}
?>
<html>
    <style>


        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
            margin: 0 auto;
            width: 50%;
            border: 3px solid #f1f1f1;

        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
            .cancelbtn {
                width: 100%;
            }
        }
    </style>
    <body>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <div class="container">
                <h3>Forgot Password</h3>

                <label><b>Student ID</b></label>
                <input type="text" placeholder="Enter Student ID" name="id" required>

                <label><b>Email (Associated with your profile)</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <button type="submit" name="verificationButton">Send Verification Mail</button>
                <h3 style="text-align: center" ><?php echo $success; ?></h3>

            </div>

        </div>
    </form>
</body>
</html>

