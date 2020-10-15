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

    Header('Refresh:0; url=index.php');
} else {

    $id_member = $_POST['id_member'];
    $water_bill = $_POST['water_bill'];
    $electric_bill = $_POST['electric_bill'];
    $room_bill = $_POST['room_bill'];
    $report_bill = $_POST['report_bill'];
    
    $result_bill = $water_bill + $electric_bill + $room_bill;
    $today = date("Y-m-d");
    "result = " . $result_bill;

    $query = "INSERT INTO rental.bill VALUES ('',$id_member,$water_bill,$electric_bill,$room_bill,$result_bill,'$report_bill','ยังไม่ชำระ','$today')";
    $result = mysqli_query($connect, $query);

    if ($result) {

        echo "<script>";
        echo "alert('บันทึกข้อมูลเสร็จสิ้น')";
        echo "</script>";

        echo"window.history.back()";
    } else {
        echo "<script>";
        echo "alert('บันทึกข้อมูลเสร็จสิ้นไม่สำเร็จ\nกรุณาทำรายการอีกครั้ง')";
        echo "</script>";

        echo"window.history.back()";
    }

?>























<?php } ?>