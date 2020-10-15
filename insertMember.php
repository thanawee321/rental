<?php
session_start();
require 'connect.php';
if (!$_SESSION['userid']) {

    echo "<script>";
    echo "alert('ไม่ได้มีการ login เข้ามาอย่างถูกต้อง')";
    echo "</script>";

    Header('Refresh:0; url=index.php');
} else if ($_SESSION['userstatus'] == "user") {

    echo "<script>";
    echo "alert('ไม่มีสิทธิ์ในการใช้งาน\nจะต้องเป็นผู้ใช้ระดับ Admin เท่านั้น')";
    echo "</script>";

    //Header('Refresh:0; url=index.php');
} else {
    
    $idcard = $_POST['idcard'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $roomNumber = $_POST['roomNumber'];
    $phone = $_POST['phone'];
    $typeCar = $_POST['typeCar'];
    $plate = $_POST['plate'];
    $today = date("Y-m-d");

    $query = "INSERT INTO rental.member VALUES('','$idcard','$name','$surname','$roomNumber','$typeCar','$plate','$phone','$today')";
    $result = mysqli_query($connect,$query);


    
    if($result){

        echo "<script>";
        echo"alert('เพิ่มข้อมูลเรียบร้อย')";
        echo "</script>";

        $queryroom = "UPDATE rental.room SET status_room='ไม่ว่าง' WHERE id_room=$roomNumber";
        $resultroom = mysqli_query($connect,$queryroom);
        
        Header("Refresh:0; url=admin.php");
    }else {
        echo "<script>";
        echo"alert('เพิ่มข้อมูลล้มเหลว')";
        echo "</script>";
        echo "window.history.back()";
    }

    
}
