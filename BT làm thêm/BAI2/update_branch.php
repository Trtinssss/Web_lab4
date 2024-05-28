<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaChiNhanh = $_POST['MaCN'];
    $TenChiNhanh = $_POST['TenChiNhanh'];
    $DiaChi = $_POST['Diachi'];
    $MaCongTy = $_POST['MaCongTy'];

    $query = "UPDATE chinhanh SET TenChiNhanh = ?, DiaChi = ?, MaCongTy = ? WHERE MaChiNhanh = ?";
    if ($stmt = $connect->prepare($query)) {
        $stmt->bind_param("ssss", $TenChiNhanh, $DiaChi, $MaCongTy, $MaChiNhanh);

        if ($stmt->execute()) {
            echo "Cập nhật thông tin chi nhánh thành công!";
        } else {
            echo "Lỗi khi cập nhật thông tin: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Lỗi khi chuẩn bị câu lệnh: " . $connect->error;
    }
    $connect->close();
} else {
    echo "Phương thức yêu cầu không hợp lệ.";
}
?>