<?php
include("connect.php");

$sql_congty = "SELECT macongty, tencongty FROM congty";
$result_congty = $connect->query($sql_congty);
$congty_option = '';
while ($row_cn = $result_congty->fetch_assoc()) {
    $congty_option .= "<option value='{$row_cn['macongty']}'>{$row_cn['tencongty']}</option>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lietke'])) {
    $macongty = $_POST['tencongty'];
    $tenchinhanh = $_POST['tenchinhanh'];
    $sql = "SELECT tenphong FROM phongban WHERE machinhanh IN (SELECT machinhanh FROM chinhanh WHERE tenchinhanh = ? AND macongty = ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('si', $tenchinhanh, $macongty);
    $stmt->execute();
    $result = $stmt->get_result();
    $departments = [];
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row['tenphong'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetch_branches'])) {
    $macongty = $_POST['macongty'];
    $sql_chinhanh = "SELECT tenchinhanh FROM chinhanh WHERE macongty = ?";
    $stmt = $connect->prepare($sql_chinhanh);
    $stmt->bind_param('i', $macongty);
    $stmt->execute();
    $result = $stmt->get_result();
    $chinhanh_option = '<option value="">Select Branch</option>';
    while ($row_pb = $result->fetch_assoc()) {
        $chinhanh_option .= "<option value='{$row_pb['tenchinhanh']}'>{$row_pb['tenchinhanh']}</option>";
    }
    echo $chinhanh_option;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dynamic Dropdown</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="tencongty"]').change(function() {
                var macongty = $(this).val();
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {fetch_branches: true, macongty: macongty},
                    success: function(data) {
                        $('select[name="tenchinhanh"]').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>
<form action='' method='post'>
    Tên công ty
    <select name='tencongty'>
        <option value=''>Select Company</option>
        <?php echo $congty_option; ?>
    </select>
    <br>
    Tên chi nhánh
    <select name='tenchinhanh'>
        <option value=''>Select Branch</option>
    </select>
    <br>

    <button type='submit' name='lietke' value='lietke'>Liệt kê</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lietke'])) {
    if (isset($departments) && count($departments) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>STT</th>
                    <th>Tên phòng ban</th>
                </tr>";
        $stt = 1;
        foreach ($departments as $department) {
            echo "<tr>
                    <td>{$stt}</td>
                    <td>{$department}</td>
                  </tr>";
            $stt++;
        }
        echo "</table>";
    } else {
        echo "No departments found for the selected branch and company.";
    }
}
?>

</body>
</html>
