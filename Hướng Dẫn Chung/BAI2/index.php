<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bai 1</title>
    <link rel="stylesheet" href="Bai2.css" />
</head>
<?php
include "connect.php";

$sql = "select * from chinhanh where MaCongTy='CT01'";
$result = $connect->query($sql);
echo "<table border='1' cellspacing='0'>";
echo "<tr><th>STT</th><th>Mã chi nhánh</th><th>Tên chi nhánh</th></tr>";
$stt = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        echo "<tr>";
        echo "<td>$stt</td><td>$row[0]</td><td>$row[1]</td>";
        echo "</tr>";
        $stt++;
    }
} else {
    echo "Không có dòng nào";
}
$connect->close();
?>

</html>