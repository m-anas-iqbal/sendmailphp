<?php

require_once "connection.php";
session_start();
$dbController = new DBController();

// Handle example form submission
if (isset($_POST['email'])) {
    // Sanitize and escape user inputs
    $name = mysqli_real_escape_string($dbController->getConnection(), $_POST['fullname']);
    $email = mysqli_real_escape_string($dbController->getConnection(), $_POST['email']);

    // Handle file upload if a file is provided
    $fileUrl = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $fileName = mysqli_real_escape_string($dbController->getConnection(), $file['name']);
        $fileTmpName = $file['tmp_name'];

        $uploadDirectory = 'uploads/';
        $date = date('YmdHis'); 
        $fileDestination = $uploadDirectory .$date. $fileName;

        // Move uploaded file to destination
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $fileUrl = mysqli_real_escape_string($dbController->getConnection(), "app/".$fileDestination);
        } else {
            $_SESSION["success"] = false;
            $_SESSION["message"] = "Failed to move uploaded file.";
            header("Location: ../index.php");
            exit();
        }
    }

    // Insert query with file URL if file was uploaded
    $query = "INSERT INTO demo (name, email,file) 
              VALUES (?, ?, ?)";
    $param_type = 'sss';
    $param_value_array = array($name, $email,$fileUrl);
    $result = $dbController->insert($query, $param_type, $param_value_array);

    if (!$result) {
        // Send confirmation email to the user
        $subject = "Thank you for requesting a demo!";
        $body = "Dear $name,\n\nThank you for submitting your demo request. We have received your details and will get back to you shortly.\n\nBest regards,\demo request";
        sendConfirmationEmail($email, $name, $subject, $body);
        $_SESSION["success"] = true;
        $_SESSION["message"] = "Thank you for reaching us at demo";
    } else {
        $_SESSION["success"] = false;
        $_SESSION["message"] = "Sorry! Kindly resubmit this due to some issues";
    }

    header("Location: ../index.php");
}
