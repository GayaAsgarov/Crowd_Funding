<?php
    include("connection.php");
    $queryHome = "SELECT * FROM projects
    JOIN users
    USING (idUser);";
    $resultHome = $link -> queryExec($queryHome);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" type="text/css" href="homePageStyle.css">
</head>
<body>
    <header>
        <h2>Welcome</h2>
        <div>
            <a href="login.php">Login</a>
        </div>
    </header>
    <?php
        echo '<table>';
        echo '<tr>';
        echo '<th>Project Name</th>';
        echo '<th>Project Owner</th>';
        echo '<th>Project Description</th>';
        echo '<th>Project Start Date</th>';
        echo '<th>Project End Date</th>';
        echo '<th>Needed Amount</th>';
        echo '</tr>';
        while($row = mysqli_fetch_assoc($resultHome)){
            echo '<tr>';
            echo '<td>'.$row['projectName'].'</td>';
            echo '<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
            echo '<td>'.$row['projectDescription'].'</td>';
            echo '<td>'.$row['projectStartDate'].'</td>';
            echo '<td>'.$row['projectEndDate'].'</td>';
            echo '<td>'.$row['requestedFund'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
    ?>

</body>
</html>

