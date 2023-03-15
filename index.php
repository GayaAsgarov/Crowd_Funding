<?php
    include('check.php');
     include('connection.php');

    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $email = $_SESSION['email'];

    $query = "SELECT * FROM projects
    JOIN users
    USING (idUser);";

    $projs = $link -> queryExec($query);


    function isOwner($link,$userId, $projectId){
        $result = $link -> queryExec("SELECT idUser FROM projects WHERE idUser=\"$userId\" AND idProject=\"$projectId\";");
        if (mysqli_num_rows($result) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    function isInvested($link,$userId, $projectId){
        $check = $link -> queryExec("SELECT * FROM projects_investors
        WHERE idUser='$userId' AND idProject='$projectId';");
        if(mysqli_num_rows($check)!=0){
            return True;
        } else {
            return False;
        }
    }

    function isClosed($link,$projectId){
        $query = mysqli_fetch_assoc($link -> queryExec("SELECT projectEndDate FROM projects WHERE idProject='$projectId';"));
        if($query['projectEndDate']<date("Y-m-d")){
            return True;
        }else{
            return False;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="indexStyle.css">
    <title>Home</title>
</head>

<body>
    <header>
        <div class="user">
            <?php
                echo '<h2>'.$firstName.' '.$lastName.'</h2>';   
            ?>
        </div>
        <div class="logout">
            <form action="logout.php" method="post">
                <input type="submit" name="logout-btn" value="Log out">
            </form>
        </div>
    </header>
    <div class="container">
    <?php
        while($row = mysqli_fetch_assoc($projs)){
            echo '<div class="project-box">';
            echo '<h3>'.$row['projectName'].'</h3>';
            echo '<h5 class="desc">Project Description: '.$row['projectDescription'].'</h5>';
            echo '<h5>Owner of the project: '.$row['firstname'].' '.$row['lastname'].'</h5>';
            echo '<h5>Email of the project owner: '.$row['email'].'</h5>';
            echo '<h5>Needed Amount: '.$row['requestedFund'].'$</h5>';
            echo '<h5>Starting date of the project: '.($row['projectStartDate']).'</h5>';
            echo '<h5>Ending date of the project:'.$row['projectEndDate'].'</h5>';

            

            if(isOwner($link,$userId, $row['idProject'])==1){
                echo '<a href="projectDetailUser.php?idProject='.($row['idProject']).'">Click to see more details</a></div>';
            }
            else if(isInvested($link,$userId, $row['idProject'])==1){
                echo '<a href="projectDetailUser.php?idProject='.($row['idProject']).'">Click to get more information</a></div>';
            }
            else if(isClosed($link,$row['idProject'])==1){
                echo '<a href="projectDetailUser.php?idProject='.($row['idProject']).'">Click to get more information</a></div>';
            }
            else{
                echo '<a href="projectDetailUser.php?idProject='.($row['idProject']).'">Click to invest to the project</a></div>';
            }
        }
    ?>
</div>
</body>
</html>
