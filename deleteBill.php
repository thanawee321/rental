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
    
    $id_bill = $_REQUEST['id_bill'];

    $query = "DELETE FROM rental.bill WHERE id_bill=$id_bill";
    $result = mysqli_query($connect,$query);

    if($result){
        echo "<script>";
        echo"alert('ลบข้อมูลเรียบร้อย')";
        echo "</script>";
        //Header("Refresh:0; url=billReport.php");
    }else {
        echo "<script>";
        echo"alert('ลบข้อมูลไม่สำเร็จ')";
        echo "</script>";
        Header("Refresh:0; url=admin.php");
    }

?>












<?php } ?>