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

     $id_member = $_REQUEST['id_member'];

    $idcard = $_POST['idcard'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $roomNumber = $_POST['roomNumber'];
    $typeCar = $_POST['typeCar'];
    $plate = $_POST['plate'];
     $phone = $_POST['phone'];
    $today = date("Y-m-d");
    $oldroom = $_POST['oldroom'];

    $query = "UPDATE rental.member SET idcard_member='$idcard',name_member='$name',sur_member='$surname',room_member='$roomNumber',vehicle_member='$typeCar',plate_member='$plate',phone_member='$phone',fristday_member='$today' WHERE id_member=$id_member";
    $result = mysqli_query($connect, $query);

    if ($result) {

        echo "<script>";
        echo "alert('แก้ไขข้อมูลเรียบร้อย')";
        echo "</script>";



        if ($oldroom == $roomNumber) {

            $queryroom = "UPDATE rental.room SET status_room='ไม่ว่าง' WHERE id_room=$roomNumber";
            $resultroom = mysqli_query($connect, $queryroom);

        } else if ($oldroom != $roomNumber) {

            $queryroomold = "UPDATE rental.room SET status_room='ห้องว่าง' WHERE id_room=$oldroom";
            $resultroomold = mysqli_query($connect, $queryroomold);

            $queryroom = "UPDATE rental.room SET status_room='ไม่ว่าง' WHERE id_room=$roomNumber";
            $resultroom = mysqli_query($connect, $queryroom);
        }
        Header("Refresh:0; url=admin.php");
    } else {
        echo "<script>";
        echo "alert('แก้ไขข้อมูลล้มเหลว')";
        echo "</script>";
        echo "window.history.back()";
    }
}
