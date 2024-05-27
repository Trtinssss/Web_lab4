<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm chi nhánh</title>
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
    </style>

</head>
<body>
<form method="POST" action="add_branch.php">
    <table>
        <tr>
            <td colspan="2" id="title">Thêm chi nhánh</td>
        </tr>
        <tr>
            <td>Mã chi nhánh</td>
            <td><input type="text" name="MaCN" required></td>
        </tr>
        <tr>
            <td>Tên chi nhánh</td>
            <td><input type="text" name="TenCN" required></td>
        </tr>
        <tr>
            <td>Địa chỉ</td>
            <td><input type="text" name="Diachi" required></td>
        </tr>
        <tr>
            <td>Tên công ty</td>
            <td>
                <select name="MaCongTy" id="MaCongTy" required>
                <?php
                include "connect.php";
                $query = "SELECT MaCongTy, TenCongTy FROM congty";
                $result = $connect->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['MaCongTy'] . "'>" . $row['TenCongTy'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có công ty nào</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" value="Thêm" name="submit" class="btn">
                <input type="reset" value="Reset" class="btn">
            </td>
        </tr>
    </table>
</form>
</body>

</html>