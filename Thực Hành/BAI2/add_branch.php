<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $machinhanh = $_POST['MaCN'];
    $tenchinhanh = $_POST['TenCN'];
    $diachi = $_POST['Diachi'];
    $macongty = $_POST['MaCongTy'];

    // Truy vấn để lấy TenCongTy từ MaCongTy
    $query = "SELECT TenCongTy FROM congty WHERE MaCongTy = ?";
    $stmt = $connect->prepare($query);
    if ($stmt === false) {
        die("Lỗi: Không thể chuẩn bị truy vấn. " . $connect->error);
    }
    
    $stmt->bind_param("s", $macongty);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $tencongty = $row['TenCongTy'];

        // In ra TenCongTy để kiểm tra
        echo "Tên công ty tìm thấy: " . htmlspecialchars($tencongty) . "<br>";

        // Tiếp tục thực hiện truy vấn chèn dữ liệu vào bảng chinhanh
        $insert_query = "INSERT INTO chinhanh (MaChiNhanh, TenChiNhanh, DiaChi, MaCongTy) VALUES (?, ?, ?, ?)";
        $insert_stmt = $connect->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Lỗi: Không thể chuẩn bị truy vấn chèn dữ liệu. " . $connect->error);
        }
        
        $insert_stmt->bind_param("ssss", $machinhanh, $tenchinhanh, $diachi, $macongty);

        if ($insert_stmt->execute()) {
            echo "Thêm chi nhánh thành công!";
        } else {
            echo "Lỗi: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    } else {
        echo "Lỗi: Công ty không tồn tại.";
    }

    $stmt->close();
    $connect->close();
}
?>
