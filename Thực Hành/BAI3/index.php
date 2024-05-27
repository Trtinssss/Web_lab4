<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng ban</title>
    <style>
        table{
            background-color: pink;
            border: 1px solid purple;
        }
        #title{
            background-color: aqua;
            font-weight: bold;
            text-align: center;
        }
        .btn{
            border-radius: 10px;

        }
        #btn{
            text-align: center;
        }
    </style>

</head>
<body>
<form method="POST" action="add_room.php">
    <table>
        <tr>
            <td colspan="2" id="title">Thêm phòng ban</td>
        </tr>
        <tr>
            <td>Mã phòng ban</td>
            <td><input type="text" name="MaPB" required></td>
        </tr>
        <tr>
            <td>Tên phòng ban</td>
            <td><input type="text" name="TenPB" required></td>
        </tr>
        <tr>
            <td>Tên chi nhánh</td>
            <td>
                <select name="MaCN" id="TenCN" required>
                <?php
                include "connect.php";
                $query = "SELECT MaChiNhanh, TenChiNhanh FROM chinhanh";
                $result = $connect->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['MaChiNhanh'] . "'>" . $row['TenChiNhanh'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có chi nhánh nào</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" id="btn">
                <input type="submit" value="Thêm" name="submit" class="btn">
                <input type="reset" value="Reset" class="btn">
            </td>
        </tr>
    </table>
</form>
</body>

</html>