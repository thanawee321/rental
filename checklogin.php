<?php 
require 'connect.php';
session_start();

if(isset($_POST['username'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM rental.login WHERE id_login='$username' AND password_login='$password'";
    $result = mysqli_query($connect,$query);
    
    if(mysqli_num_rows($result)==1){

        $row = mysqli_fetch_array($result);

        $_SESSION['userid'] = $row['id_login'];
        $_SESSION['name'] = $row['name_login'] . " ". $row['sur_login'];
        $_SESSION['userstatus'] = $row['status_login'];

        if($_SESSION['userstatus']=="admin"){
            Header('Location: admin.php');
        }else if($_SESSION['userstatus']=="user") {
            Header('Location: user.php');
        }
    }else {
        echo "<script>";
        echo "alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง')";
        echo "</script>";

        Header('Refresh:0; url=index.php');
    }

}else {

    echo "<script>";
    echo "alert('มีการ Login เข้ามาใช้งานไม่ถูกต้อง')";
    echo "</script>";

    Header("Refresh:0; url=index.php");
}

?>