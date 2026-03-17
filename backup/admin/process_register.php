<?php
require '../config/db.php';

if ($_POST) {
    $username  = $_POST['username'];
    $password  = $_POST['password']; // sengaja plain (lab)
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $bio       = $_POST['bio'];

    $sql = "INSERT INTO users 
            (username, password, full_name, email, phone, bio)
            VALUES
            ('$username','$password','$full_name','$email','$phone','$bio')";

    mysqli_query($conn, $sql);

    header("Location: register.php?success=1");
}
