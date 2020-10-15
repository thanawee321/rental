<?php
session_start();
require 'connect.php';
/*if (!$_SESSION['userid']) {

    echo "<script>";
    echo "alert('ไม่ได้มีการ login เข้ามาอย่างถูกต้อง')";
    echo "</script>";

    Header('Refresh:0; url=index.php');


} else if ($_SESSION['userstatus'] == "user") {

    echo "<script>";
    echo "alert('ไม่มีสิทธิ์ในการใช้งาน\nจะต้องเป็นผู้ใช้ระดับ Admin เท่านั้น')";
    echo "</script>";

    Header('Refresh:0; url=index.php');
} else {*/

   echo $id_bill = $_POST['id_bill']; echo "<br>";
   echo $id_member = $_POST['id_member'];echo "<br>";
   echo $water_bill = $_POST['water_bill'];echo "<br>";
   echo $electric_bill = $_POST['electric_bill'];echo "<br>";
   echo $room_bill = $_POST['room_bill'];echo "<br>";
   echo $report_bill = $_POST['report_bill'];echo "<br>";
   $status_bill = $_POST['status_bill'];

    $result_bill = $water_bill + $electric_bill + $room_bill;
    $today = date("Y-m-d");

    $query = "UPDATE rental.bill SET id_member=$id_member,water_bill=$water_bill,electric_bill=$electric_bill,room_bill=$room_bill,result_bill=$result_bill,report_bill='$report_bill',status_bill='$status_bill',date_bill='$today' WHERE id_bill=$id_bill";
    $result = mysqli_query($connect, $query);

    if ($result) {

        echo "<script>";
        echo "alert('แก้ไขข้อมูลเสร็จสิ้น')";
        echo "</script>";

        
    } else {
        echo "<script>";
        echo "alert('แก้ไขข้อมูลเสร็จสิ้นไม่สำเร็จกรุณาทำรายการอีกครั้ง')";
        echo "</script>";
echo mysqli_error($connect);
        Header ( "window.history.back()");
    }
//}
?>























