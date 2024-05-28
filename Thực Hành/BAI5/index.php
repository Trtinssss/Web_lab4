<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách các chi nhánh</title>
</head>
<body>
    <form method="GET" action="">
        <p>Chọn tên công ty: 
            <select name="company_id">
                <?php
                include "connect.php";
                $sql = "SELECT MaCongTy, TenCongTy FROM CONGTY";
                $result = $connect->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='".$row['MaCongTy']."'>".$row['TenCongTy']."</option>";
                    }
                } else {
                    echo "<option value=''>Không có công ty nào</option>";
                }
                $connect->close();
                ?>
            </select>
        </p>
        <input type="submit" value="Liệt kê" name="submit">
    </form>

    <p>Danh sách các chi nhánh</p>
    <?php
    if (isset($_GET['submit']) && $_GET['submit'] == "Liệt kê" && isset($_GET['company_id'])) {
        include "connect.php";
        $company_id = $_GET['company_id'];
        $sql = "SELECT MaChiNhanh, TenChiNhanh FROM CHINHANH WHERE MaCongTy = '$company_id'";
        $result = $connect->query($sql);

        echo "<table border='1' cellspacing='0'>";
        echo "<tr>
        <th>STT</th>
        <th>Mã chi nhánh</th>
        <th>Tên chi nhánh</th>
        </tr>"; 
        $stt = 1;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$stt."</td>";
                echo "<td>".$row['MaChiNhanh']."</td>";
                echo "<td>".$row['TenChiNhanh']."</td>";
                echo "</tr>";
                $stt++; 
            }
        } 
        else {
            echo "<tr><td colspan='3'>Không có chi nhánh nào</td></tr>";
        }
        echo "</table>";
        $connect->close();
    }
    ?>
</body>
</html>