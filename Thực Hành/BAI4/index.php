<?php
include ("connect.php");

// Fetch existing data for dropdowns
$sql_chinhanh = "select tenchinhanh from chinhanh";
$result_chinhanh = $connect->query($sql_chinhanh);
$chinhanh_option = '';
while ($row_cn = $result_chinhanh->fetch_assoc()) {
    $chinhanh_option .= "<option value='{$row_cn['tenchinhanh']}'>{$row_cn['tenchinhanh']}</option>";
}

$sql_phongban = "select tenphong from phongban";
$result_phongban = $connect->query($sql_phongban);
$phongban_option = '';
while ($row_pb = $result_phongban->fetch_assoc()) {
    $phongban_option .= "<option value='{$row_pb['tenphong']}'>{$row_pb['tenphong']}</option>";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $tenchinhanh = $_POST['tenchinhanh'];
    $tenphong = $_POST['tenphong'];
    $manhanvien = $_POST['manhanvien'];
    $tennhanvien = $_POST['tennhanvien'];
    $luongthang = $_POST['luongthang'];
    $gioiTinh = isset($_POST['gioiTinh']) ? 'Nam' : 'Nữ';

    // Insert data into NHANVIEN table
    $sql_insert = "INSERT INTO NHANVIEN (manhanvien, tennhanvien, luongthang, gioiTinh, maPhong) 
                   VALUES ('$manhanvien', '$tennhanvien', '$luongthang', '$gioiTinh', 
                   (SELECT maPhong FROM PHONGBAN WHERE tenphong = '$tenphong'))";

    if ($connect->query($sql_insert) === TRUE) {
        echo "Đã thêm thành công thông tin nhân viên !";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $connect->error;
    }
}

echo "<form action='' method='post'>";
echo "<table>";
echo "<th>Thêm nhân viên</th>";
echo "<tr><td>Tên chi nhánh</td>
<td><select name='tenchinhanh'>
    $chinhanh_option
</select></td></tr>";
echo "<tr><td>Tên phòng ban</td>
<td><select name='tenphong' >
    $phongban_option
</select></td></tr>";
echo "<tr><td>Mã nhân viên</td>
<td><input type='text' name='manhanvien'></td></tr>";
echo "<tr><td>Tên nhân viên</td>
<td><input type='text' name='tennhanvien'></td></tr>";
echo "<tr><td>Lương</td>
<td><input type='number' name='luongthang'></td></tr>";
echo "<tr><td>Giới tính</td>
<td><input type='checkbox' name='gioiTinh'> </td></tr>";
echo "<tr>
<td></td><td><button type='submit' name='add' value='add'>Thêm</button><button type='reset' name='reset' value='reset'>Reset</button></td></tr>";
echo "</table>";
echo "</form>";
?>
<link rel="stylesheet" href="style.css">
