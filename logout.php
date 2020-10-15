<?php 
session_start();
session_destroy();

echo"<script>";
echo"alert('ทำการออกจากระบบเรียบร้อยแล้ว!!')";
echo"</script>";

header('Refresh:0; url=index.php');
?>