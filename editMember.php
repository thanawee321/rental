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
    $name_login = $_SESSION['name'];
    $id_member = $_REQUEST['id_member'];

    $query  = "SELECT member.id_member,member.idcard_member,member.name_member,member.sur_member,member.room_member,room.type_room,member.vehicle_member,member.plate_member,member.phone_member,member.fristday_member FROM member INNER JOIN room ON member.id_member=room.id_member WHERE member.id_member = $id_member";
    $result = mysqli_query($connect, $query);

    $queryroom = "SELECT * FROM rental.room WHERE status_room='ห้องว่าง'";
    $resultroom = mysqli_query($connect, $queryroom);

    while ($row = mysqli_fetch_array($result)) {
        $id_card = $row['idcard_member'];
        $name = $row['name_member'];
        $sur = $row['sur_member'];
        $room = $row['room_member'];
        $vehicle = $row['vehicle_member'];
        $plate = $row['plate_member'];
        $phone = $row['phone_member'];
    }
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
        <link rel="stylesheet" href="asset/style.css">
    </head>

    <body>
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg  navbar-light bg-warning">
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
    <?php } ?>


    <div class="container pt-3">
        <h1>แก้ไขข้อมูล</h1><br>
        <form method="post" action="updateMember.php">
            <input type="hidden" name="id_member" value="<?php echo $id_member ?>">

            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label>รหัสบัตรประชาชน</label>
                        <div class="was-validated">
                            <input type="text" class="form-control " name="idcard" id="idcard" value="<?php echo $id_card; ?>" maxlength="13" required>
                            <div class="invalid-feedback">
                                ** กรุณาใส่เลขบัตรประชาชน **
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-4">
                            <label>ชื่อลูกค้า</label>
                            <div class="was-validated">
                                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" required>
                                <div class="invalid-feedback">
                                    ** กรุณาใส่ชื่อลูกค้า **
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label>นามสกุลลูกค้า</label>
                            <input type="text" class="form-control" name="surname" id="surname" value="<?php echo $sur; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="fomr-group">
                    <div class="row">
                        <div class="col-2">
                            <label>เบอร์โทร</label>
                            <div class="was-validated">
                                <input type="number" class="form-control" name="phone" value="<?php echo $phone; ?>" required>
                                <div class="invalid-feedback">
                                    ** กรุณาใส่เบอร์โทร **
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>เลขห้อง</label>
                            <input type="hidden" value="<?php echo $room; ?>" name="oldroom" required><!-- เก็บเลขห้องเดิมเอาไว้ก่อน -->

                            <select class="form-control" name="roomNumber" id="roomNumber">
                            
                                <option value="<?php echo $room; ?>"><?php echo $room ?></option>
                                <?php while ($row = mysqli_fetch_array($resultroom)) { ?>
                                    <option value="<?php echo $row['id_room'];?>"><?php echo $row['id_room']; ?> | <?php echo $row['type_room'];?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label>ประเภทรถต์</label>
                            <select name=typeCar id="typeCar" class="form-control">
                                <option value="<?php echo $vehicle; ?>"><?php echo $vehicle; ?></option>
                                <option value="ไม่มี"> - </option>
                                <option value="รถยนต์">รถยนต์</option>
                                <option value="มอเตอร์ไซค์">มอเตอร์ไซค์</option>
                                <option value="จักรยาน">จักรยาน</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>ป้ายทะเบียนรถ</label>
                            <input type="text" class="form-control" name="plate" id="plate" value="<?php echo $plate; ?>">
                        </div>
                    </div>

                </div>
                <center>
                    <input type="submit" class=" btn btn-info" value="ตกลง">
                    <input type="reset" class="btn btn-secondary" value="ยกเลิก">
                </center>
        </form>
    </div>
    <br>
    <center>Copyright © 2020 คะเมียวตำปรู๊ช คะเมียวตรำปร๊าช by KAPOOK V. 12.4</center><br>
    </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="asset/app.js"></script>

    </html>