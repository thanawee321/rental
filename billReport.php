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
    $name_login = $_SESSION['name'];
    $id_member = $_REQUEST['id_member'];
    $name_member = $_REQUEST['name'];
    $query  = "SELECT bill.id_bill,member.id_member,member.name_member,member.sur_member,member.room_member,bill.water_bill,bill.electric_bill,bill.room_bill,bill.result_bill,bill.report_bill,bill.status_bill,bill.date_bill FROM bill
    INNER JOIN member ON bill.id_member=member.id_member WHERE member.id_member =$id_member";
    $result = mysqli_query($connect, $query);

    $queryroomEmpty = "SELECT * FROM rental.room";
    $resultroomEmpty = mysqli_query($connect, $queryroomEmpty);

    //ตรวจสอบการชำระ
    $querystatusPay = "SELECT bill.id_bill,member.name_member,member.sur_member,bill.status_bill,bill.date_bill FROM bill INNER JOIN member
    ON bill.id_member=member.id_member";
    $resultstatusPay = mysqli_query($connect, $querystatusPay);

?>

    <html>

    <head>
        <meta http-equiv="Content-Language" content="th" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href=" https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">
        <script src="https://kit.fontawesome.com/992613a55e.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="asset/style.css">
    </head>

    <body>
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg  navbar-light bg-primary">
                <a class="navbar-brand text-white" href="admin.php">Home</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <!--hrhefekf[fkl[fla[kgp-->
                        </li>
                        <li class="nav-item">
                            <!--hrhefekf[fkl[fla[kgp-->
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                การจัดการ
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item " href="registerMember.php">เพิ่มข้อมูลลูกค้า</a>

                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#roomEmpty">
                                    ตรวจสอบห้องว่าง
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#statusPay">
                                    ตรวจสอบการชำระเงิน
                                </a>
                            </div>

                        </li>
                        <li class="nav-item">
                            <!--hrhefekf[fkl[fla[kgp-->
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <h4 class="mr-sm-2 text-white"><?php echo $name_login; ?></h4>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <div class="container pt-3">

            <h1>ประวัติบิล Bill | คุณ <?php echo $name_member; ?></h1>

            <input type="hidden" value="<?php echo $id_member; ?>" name="id_member" id="id_member">
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>ค่าน้ำ</label>
                        <div class="was-validated">
                            <input type="number" class="form-control" name="water_bill" id="water_bill" required>
                            <div class="invalid-feedback">
                                ** กรุณาใส่ค่าน้ำ **
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <label>ค่าไฟ</label>
                        <div class="was-validated">
                            <input type="number" class="form-control" name="electric_bill" id="electric_bill" required>
                            <div class="invalid-feedback">
                                ** กรุณาค่าไฟ **
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <label>ค่าห้อง</label>
                        <div class="was-validated">
                            <input type="number" class="form-control" name="room_bill" id="room_bill" required>
                            <div class="invalid-feedback">
                                ** กรุณาใส่ค่าห้อง **
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-4">
                        <label>**หมายเหตุ**</label>
                        <textarea class="form-control" name="report_bill" id="report_bill"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#update">เพิ่มข้อมูล</button>
                        <input type="reset" class="btn btn-danger" value="ยกเลิก">
                    </div>
                </div>

            </div><br>
        </div>
        <div class="container-fluid">
            <table class="table table-striped table-dark text-center table-hover" id="viewbill" style="width:100%">
                <thead>

                    <tr>
                        <th>เลขที่บิล</th>
                        <!--<th>รหัสสมาชิก</th>-->
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>ห้อง</th>
                        <th>ค่าน้ำ</th>
                        <th>ค่าไฟ</th>
                        <th>ค่าห้อง</th>
                        <th>รวมทั้งหมด/บาท</th>
                        <th>หมายเหตุ</th>
                        <th>การชำระ</th>
                        <th>วันออกบิล</th>
                        <th>ลบ</th>
                        <th>แก้ไข</th>
                        <!--<th>ดู</th>-->

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row['id_bill']; ?></td>
                            <!--<td><?php //echo $row['id_member']; 
                                    ?></td>-->
                            <td><?php echo $row['name_member']; ?></td>
                            <td><?php echo $row['sur_member']; ?></td>
                            <td><?php echo $row['room_member']; ?></td>
                            <td><?php echo $row['water_bill']; ?></td>
                            <td><?php echo $row['electric_bill']; ?></td>
                            <td><?php echo $row['room_bill']; ?></td>
                            <td><?php echo $row['result_bill']; ?></td>
                            <td><?php echo $row['report_bill']; ?></td>
                            <?php if ($row['status_bill'] == 'ชำระแล้ว') { ?>
                                <td><button class="btn btn-success"><?php echo $row['status_bill']; ?></button></td>
                            <?php } else if ($row['status_bill'] == 'ยังไม่ชำระ') { ?>
                                <td><button class="btn btn-danger"><?php echo $row['status_bill']; ?></button></td>
                            <?php } ?>
                            <td><?php echo $row['date_bill']; ?></td>

                            <td><button type="button" class="btn btn-danger btndeletebill" id="<?php echo $row['id_bill']; ?>" data-toggle="modal" data-target="#deletebill"><i class="fas fa-trash"></i></button></td>
                            <td><a href="editBillReport.php?id_bill=<?php echo $row['id_bill']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                            <!--<td><button type="button" class="btn btn-info viewdetailbill" id="<?php// echo $row['id_bill']; ?>" data-toggle="modal" data-target="#viewbillreport">รายละเอียด</button>-->
                        <?php } ?>
                </tbody>
            </table>



            <!--modal logout-->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">การยืนยัน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ต้องการออกจากระบบหรือไม่
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <a href="logout.php" class="btn btn-danger">ตกลง</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--modal ลบ-->
            <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">การยืนยัน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ต้องการที่จะลบหรือไม่
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" class="btn btn-primary cfdelete">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--modal update-->
            <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">การยืนยัน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ต้องการเพิ่มข้อมูลหรือไม่?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" class="btn btn-primary cfupdatebill">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--modal deletebill -->
            <div class="modal fade" id="deletebill" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">การยืนยัน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ต้องการลบใช่หรือไม่?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" class="btn btn-primary cfdeletebill">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--modal viewbill-->

            <div class="modal fade" id="viewbillreport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">รายละเอียด</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>



        <!--modal room empty-->
        <div class="modal fade" id="roomEmpty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ห้องทั้งหมด</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container pt-3">
                            <table class="table table-lg table-hover" id="room">
                                <thead>
                                    <tr>
                                        <th scope="col">เลขห้อง</th>
                                        <th scope="col">ชนิดห้อง</th>
                                        <th scope="col">สถานะห้อง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_array($resultroomEmpty)) { ?>
                                        <tr>
                                            <td><?php echo $row['id_room']; ?></td>
                                            <td><?php echo $row['type_room']; ?></td>
                                            <td><?php echo $row['status_room']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal status Pay-->
        <div class="modal fade" id="statusPay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <table class="table table-lg table-hover" id="statuspay">
                                <thead>
                                    <tr>
                                        <!--<th scope="col">เลขที่บิล</th>-->
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">นามสกุล</th>
                                        <th scope="col">สถานะบิล</th>
                                        <th scope="col">วันออกบิล</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_array($resultstatusPay)) { ?>
                                        <tr>
                                            <!--<td><?php //echo $row['id_bill'];
                                                    ?></td>-->
                                            <td><?php echo $row['name_member']; ?></td>
                                            <td><?php echo $row['sur_member']; ?></td>
                                            <td><?php echo $row['status_bill']; ?></td>
                                            <td><?php echo $row['date_bill']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <center>Copyright © 2020 คะเมียวตำปรู๊ช คะเมียวตรำปร๊าช by KAPOOK V. 12.4</center><br>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
    <script src="asset/app.js"></script>

    </html>




















<?php } ?>