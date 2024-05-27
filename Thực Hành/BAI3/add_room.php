<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy giá trị từ form
    $maphongban = $_POST['MaPB'];
    $tenphongban = $_POST['TenPB'];
    $machinhanh = $_POST['MaCN'];

    // Truy vấn để lấy TenCongTy từ MaCongTy
    $query = "SELECT TenChiNhanh FROM chinhanh WHERE MaChiNhanh = ?";
    $stmt = $connect->prepare($query);
    if ($stmt === false) {
        die("Lỗi: Không thể chuẩn bị truy vấn. " . $connect->error);
    }
    
    $stmt->bind_param("s", $machinhanh);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $tenchinhanh = $row['TenChiNhanh'];

        // In ra TenChiNhanh để kiểm tra
        echo "Tên chi nhánh tìm thấy: " . htmlspecialchars($tenchinhanh) . "<br>";

        // Tiếp tục thực hiện truy vấn chèn dữ liệu vào bảng phongban
        $insert_query = "INSERT INTO phongban (MaPhong, TenPhong, MaChiNhanh) VALUES (?, ?, ?)";
        $insert_stmt = $connect->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Lỗi: Không thể chuẩn bị truy vấn chèn dữ liệu. " . $connect->error);
        }
        
        $insert_stmt->bind_param("sss", $maphongban, $tenphongban, $machinhanh);

        if ($insert_stmt->execute()) {
            echo "Thêm chi nhánh thành công!";
        } else {
            echo "Lỗi: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    } else {
        echo "Lỗi: Chi nhánh không tồn tại.";
    }

    $stmt->close();
    $connect->close();
}
?>
