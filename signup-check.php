<?php 
session_start(); 
include "DBConnection.php";

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['re_password']) && isset($_POST['name']) && isset($_POST['username']) && isset($_POST['phone_no'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uemail = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $re_pass = validate($_POST['re_password']);
    $name = validate($_POST['name']);
    $user_name = validate($_POST['username']);
    $phone_no = validate($_POST['phone_no']);

    $user_data = 'uemail='. $uemail. '&name='. $name. '&user_name='. $user_name. '&phone_no='. $phone_no;

    if (empty($uemail)) {
        header("Location: signup.php?error=User Email is required&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: signup.php?error=Password is required&$user_data");
        exit();
    } else if (empty($re_pass)) {
        header("Location: signup.php?error=Re Password is required&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: signup.php?error=Name is required&$user_data");
        exit();
    } else if (empty($user_name)) {
        header("Location: signup.php?error=Username is required&$user_data");
        exit();
    } else if (empty($phone_no)) {
        header("Location: signup.php?error=Phone Number is required&$user_data");
        exit();
    } else if ($pass !== $re_pass) {
        header("Location: signup.php?error=The confirmation password does not match&$user_data");
        exit();
    } else {
        // hashing the password
        $pass = md5($pass);

        $sql = "SELECT * FROM users WHERE email='$uemail'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=The email is taken, try another&$user_data");
            exit();
        } else {
           $sql2 = "INSERT INTO users(email, password, name, user_name, phone_no) VALUES('$uemail', '$pass', '$name', '$user_name', '$phone_no')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
             header("Location: index.php?success=Your account has been created successfully");
             exit();
           } else {
             header("Location: signup.php?error=unknown error occurred&$user_data");
             exit();
           }
        }
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
