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
    
    $id_member = $_POST['id_member'];
    $Numroom = $_POST['Numroom'];

    $query = "DELETE FROM rental.member WHERE id_member=$id_member";
    $result = mysqli_query($connect,$query);

    
    if($result){

        echo "<script>";
        echo"alert('ลบข้อมูลเรียบร้อย')";
        echo "</script>";

        $queryroom = "UPDATE rental.room SET id_member = '',status_room='ห้องว่าง' WHERE id_room=$Numroom";
        $resultroom = mysqli_query($connect,$queryroom);

        $querydeletebill = "DELETE FROM rental.bill WHERE id_member=$id_member";
        $resultdeletebil = mysqli_query($connect,$querydeletebill);

        Header("Refresh:0; url=admin.php");
    }else {
        echo "<script>";
        echo"alert('ลบข้อมูลล้มเหลว')";
        echo "</script>";
        echo "window.history.back()";
    }

    
}
?>







