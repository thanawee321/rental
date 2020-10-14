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
    
    $id_bill = $_POST['id_bill'];
    $query = "SELECT bill.id_bill,member.id_member,member.name_member,member.sur_member,member.room_member,bill.water_bill,bill.electric_bill,bill.room_bill,bill.result_bill,bill.report_bill,bill.date_bill FROM bill
    INNER JOIN member ON bill.id_member=member.id_member WHERE member.id_member =$id_bill";
    $result = mysqli_query($connect,$query);


?>
<?php while($row = mysqli_fetch_array($result)){ ?>

<p>เลขที่ Bill : <?php echo $row['id_bill'];?></p>
<p>รหัสสมาชิก : <?php echo $row['id_member'];?></p>
<p>ชื่อ : <?php echo $row['name_member'];?></p>
<p>นามสกุล : <?php echo $row['sur_member'];?></p>
<p>ห้อง : <?php echo $row['room_member'];?></p>
<p>ค่าน้ำ : <?php echo $row['water_bill'];?></p>
<p>ค่าไฟ : <?php echo $row['electric_bill'];?></p>
<p>ค่าห้อง : <?php echo $row['room_bill'];?></p>
<p>ยอดรวม : <?php echo $row['result_bill'];?></p>
<p>หมายเหตุ : <?php echo $row['report_bill'];?></p>
<p>วันที่ออกบิล : <?php echo $row['date_bill'];?></p>      

<?php }?>

























<?php } ?>