<?php
include("connect.php");

// Kiểm tra xem có sự kiện click vào nút "Xóa" không
if(isset($_POST['btn-xoa'])) {
    // Lấy tên công ty từ form
    $tencongty = $_POST['tencongty'];

    // Truy vấn SQL để lấy mã công ty tương ứng với tên đã chọn
    $sql_ma_congty = "SELECT macongty FROM congty WHERE tencongty = '$tencongty'";
    $result_ma_congty = $connect->query($sql_ma_congty);

    if ($result_ma_congty->num_rows > 0) {
        // Lấy mã công ty từ kết quả truy vấn
        $row_ma_congty = $result_ma_congty->fetch_assoc();
        $macongty = $row_ma_congty['macongty'];

        // Truy vấn để lấy mã chi nhánh tương ứng với mã công ty
        $sql_ma_chinhanh = "SELECT machinhanh FROM chinhanh WHERE macongty = '$macongty'";
        $result_ma_chinhanh = $connect->query($sql_ma_chinhanh);

        // Xóa tất cả các phòng ban liên quan đến các chi nhánh
        while ($row_ma_chinhanh = $result_ma_chinhanh->fetch_assoc()) {
            $machinhanh = $row_ma_chinhanh['machinhanh'];

            // Truy vấn để lấy mã phòng liên quan đến mã chi nhánh
            $sql_ma_phong = "SELECT maphong FROM phongban WHERE machinhanh = '$machinhanh'";
            $result_ma_phong = $connect->query($sql_ma_phong);

            // Xóa tất cả các nhân viên liên quan đến các phòng ban
            while ($row_ma_phong = $result_ma_phong->fetch_assoc()) {
                $maphong = $row_ma_phong['maphong'];
                $sql_delete_nhanvien = "DELETE FROM nhanvien WHERE maphong = '$maphong'";
                $connect->query($sql_delete_nhanvien);
            }

            // Xóa các phòng ban liên quan đến chi nhánh
            $sql_delete_phongban = "DELETE FROM phongban WHERE machinhanh = '$machinhanh'";
            $connect->query($sql_delete_phongban);
        }

        // Xóa các chi nhánh liên quan đến công ty
        $sql_delete_chinhanh = "DELETE FROM chinhanh WHERE macongty = '$macongty'";
        $connect->query($sql_delete_chinhanh);

        // Xóa công ty
        $sql_delete_congty = "DELETE FROM congty WHERE macongty = '$macongty'";
        
        // Thực thi truy vấn xóa
        if($connect->query($sql_delete_congty) === TRUE) {
            echo "Xóa công ty thành công!";
        } else {
            echo "Lỗi: " . $connect->error;
        }
    } else {
        echo "Không tìm thấy mã công ty tương ứng với tên đã chọn.";
    }
}

// Truy vấn để lấy tên công ty
$sql_congty = "SELECT tencongty FROM congty";
$result_congty = $connect->query($sql_congty);
$congty_option = '';
while ($row_ct = $result_congty->fetch_assoc()) {
    $congty_option .= "<option value='{$row_ct['tencongty']}'>{$row_ct['tencongty']}</option>";
}
?>

<form method="post">
    Tên công ty: 
    <select name='tencongty'>
        <?php echo $congty_option; ?>
    </select>
    <br>
    <button type='submit' name='btn-xoa'>Xóa</button>
</form>
