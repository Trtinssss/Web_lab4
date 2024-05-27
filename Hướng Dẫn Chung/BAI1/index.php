<link rel="stylesheet" href="style.css">
<div class="container">
   <form method="get" action="#">
      <table border="1" cellspacing="0">
         <tr>
            <td class="tieude" colspan="2">Thêm công ty</td>
         </tr>
         <tr>
            <td>Mã công ty </td>
            <td><input type="input" name="ma"></td>
         </tr>
         <tr>
            <td>Tên công ty </td>
            <td><input type="input" name="ten"></td>
         </tr>
         <tr>
            <td>Địa chỉ </td>
            <td><input type="input" name="diachi"></td>
         </tr>
         <tr>
            <td class="nut" colspan="2" b>
               <input type="Submit" value="Thêm" name="Submit">

               <input type="Reset" name="Reset" value="Reset">
            </td>

         </tr>
      </table>
   </form>
</div>
<?php
if (isset($_GET['Submit']) && ($_GET['Submit'] == "Thêm")) {
   include "connect.php";
   $macongty = $_GET['ma'];
   $tencongty = $_GET['ten'];
   $diachi = $_GET['diachi'];
   $str = "insert into CONGTY values ('$macongty','$tencongty','$diachi')";
   if ($connect->query($str) == true) {
      echo "Thêm thành công";
   } else {
      echo "Thêm không thành công";
   }
   $connect->close();
}
?>