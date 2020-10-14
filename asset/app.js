$(document).ready(function () {

  $('#viewmember').DataTable({

    aLengthMenu: [[5, 10, 15, 20, -1], ["5", "10", "15", "20", "ทั้งหมด"]],
    "pageLength": 5
  });

  $('#viewbill').DataTable({

    dom: 'Bfrtip',
    buttons: [
      'pageLength', 'excel', 'pdf',
      { extend: 'print', essageTop: 'รายการบิลทั้งหมด' },
      'colvis'],
    "lengthMenu": [[5, 10, 15, 20, -1], ["5", "10", "15", "20", "ทั้งหมด"]],


  });

  $('#room').DataTable({
    aLengthMenu: [[5, 10,-1], ["5", "10", "ทั้งหมด"]],
    "pageLength": 10

  });
  
  
  $('#statuspay').DataTable({

    aLengthMenu: [[5, 10,-1], ["5", "10", "ทั้งหมด"]],
    "pageLength": 10
    
  });





  $('.delete').click(function () {
    console.log("TEST button");

    var id_member = $(this).attr('id');
    var Numroom = $(this).attr('Numroom');

    console.log(id_member);
    console.log(Numroom);
    $('.cfdelete').click(function () {


      $.ajax({
        url: "deleteMember.php",
        method: "post",
        data: { id_member: id_member, Numroom: Numroom },
        success: function (data) {
          window.location = "admin.php";
        }
      });


    });

  });

  $('.cfupdatebill').click(function () {

    console.log("ทดสอบการกดหน่อยซิ้");

    var id_member = $('#id_member').val();
    var water_bill = $('#water_bill').val();
    var electric_bill = $('#electric_bill').val();
    var room_bill = $('#room_bill').val();
    var report_bill = $('#report_bill').val();

    console.log(id_member);
    console.log(water_bill);
    console.log(electric_bill);
    console.log(room_bill);
    console.log(report_bill);

    $.ajax({
      url: "insertBill.php",
      method: "post",
      data: { id_member: id_member, water_bill: water_bill, electric_bill: electric_bill, room_bill: room_bill, report_bill: report_bill },
      success: function (data) {
        location.reload();
      }
    });
  });

  $('.cfupdatebill2').click(function () {


    var id_bill = $('#id_bill').val();
    var id_member = $('#id_member').val();
    var water_bill = $('#water_bill').val();
    var electric_bill = $('#electric_bill').val();
    var room_bill = $('#room_bill').val();
    var report_bill = $('#report_bill').val();
    var status_bill = $('#status_bill option:selected').val();

    console.log(id_bill);
    console.log(id_member);
    console.log(water_bill);
    console.log(electric_bill);
    console.log(room_bill);
    console.log(report_bill);
    console.log(status_bill);

    $.ajax({
      url: "updateBill.php",
      method: "post",
      data: { id_bill: id_bill, id_member: id_member, water_bill: water_bill, electric_bill: electric_bill, room_bill: room_bill, report_bill: report_bill,status_bill:status_bill },
      success: function (data) {
        alert('เพิ่มข้อมูลเสร็จสิ้น');
        window.history.back();
       
        //location.reload();
      }
    });

  });


  $('.btndeletebill').click(function () {
    //console.log("ทดสอบการกดหน่อยซิ้");
    var id_bill = $(this).attr('id');
    console.log(id_bill);
    $('.cfdeletebill').click(function () {
      window.location.replace("deleteBill.php?id_bill=" + id_bill);

      location.reload();
      alert("ลบข้อมูลสำเร็จ");

    });

  });

  $('.viewdetailbill').click(function () {
    console.log("ทดสอบการกดหน่อยซิ้");
    var id_bill = $(this).attr('id');
    console.log(id_bill);
    $.ajax({
      url: "billReport.php",
      method: "post",
      data: { id_bill: id_bill },
      success: function (data) {
        // $('#viewDetailBill').html(data)

      }
    });


  });
});
