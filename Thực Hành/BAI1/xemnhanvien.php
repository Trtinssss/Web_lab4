<?php
if (isset($_GET['manhanvien'])) {
    $manhanvien = $_GET['manhanvien'];
    include "connect.php";

        // Lấy thông tin nhân viên
        $sql = "SELECT * FROM NHANVIEN WHERE MaNhanVien='$manhanvien'";
        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        // Lấy danh sách phòng ban
        $sql_phongban = "SELECT MaPhong  FROM PHONGBAN";
        $result_phongban = $connect->query($sql_phongban);
        $phongban_options = '';
        while ($row_pb = $result_phongban->fetch_assoc()) {
            $phongban_options .= "<option value='{$row_pb['MaPhong']}' " . ($row['MaPhong'] == $row_pb['MaPhong'] ? 'selected' : '') . ">{$row_pb['MaPhong']}</option>";
        }



        echo "<form action='' method='post'>";
        echo "<table border='1' cellspacing='0'>";
        echo "<tr><td>Mã Nhân Viên</td><td>{$row['MaNhanVien']}<input type='hidden' name='manhanvien' value='{$row['MaNhanVien']}'></td></tr>";
        echo "<tr><td>Tên Nhân Viên</td><td><input type='text' name='tennhanvien' value='{$row['TenNhanVien']}'></td></tr>";
        echo "<tr><td>Lương Tháng</td><td><input type='text' name='luongthang' value='{$row['LuongThang']}'></td></tr>";
        echo "<tr><td>Giới Tính</td>
              <td><input type='checkbox' name='gioiTinh' value='1' " . ($row['GioiTinh'] == '1' ? 'checked' : '') . "></td></tr>";
        echo "<tr><td>Mã phòng ban</td>
              <td><select name='maPhong' id='maPhong'>
                  $phongban_options
              </select></td></tr>";
        echo "<tr><td colspan='2'><button type='submit' name='capNhat' value='capNhat'>Cập nhật</button></td></tr>";
        echo "</table>";
        echo "</form>";

        $connect->close();
    } else {
        echo "Không tìm thấy nhân viên";
    }
}
?>
<?php
if (isset($_POST['capNhat'])) {
    $manhanvien = $_POST['manhanvien'];
    $tennhanvien = $_POST['tennhanvien'];
    $luongthang = $_POST['luongthang'];
    $gioiTinh = $_POST['gioiTinh'];
    $maPhong = $_POST['maPhong'];

    include "connect.php";

    $sql = "UPDATE NHANVIEN SET 
            TenNhanVien='$tennhanvien', 
            LuongThang='$luongthang', 
            GioiTinh='$gioiTinh', 
            MaPhong='$maPhong' 
            WHERE MaNhanVien='$manhanvien'";

    if ($connect->query($sql) === TRUE) {
        // Redirect to the same page to refresh the data
        header("Location: xemnhanvien.php?manhanvien=$manhanvien");
        exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . $connect->error;
    }

    $connect->close();
}
?>  