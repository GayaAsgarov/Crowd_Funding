<?php
    include('projectDetailUser.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="projectDetailOwnerStyle.css">
</head>
<body>
    <table>
    <thead>
        <tr>
        <th>Donater</th>
        <th>Email</th>
        <th>Amount</th>
        <th>Investment Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($detail = mysqli_fetch_assoc($projHistory)) {
                echo "<tr>";
                echo "<td>" . ($detail['firstname']. " ". $detail['lastname']) . "</td>";
                echo "<td>" . ($detail['email']) . "</td>";
                echo "<td>" . ($detail['investmentFund']) . "</td>";
                echo "<td>" . ($detail['investmentDate']) . "</td>";
                echo "</tr>";
            }
        ?>
        
    </tbody>
    </table>

</body>
</html>