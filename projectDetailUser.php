<?php
    session_start();
    include('connection.php');


    function isInvested($link,$userId, $projectId){
         $checking = $link -> queryExec("SELECT * FROM projects_investors
         WHERE idUser='$userId' AND idProject='$projectId';");
         if(mysqli_num_rows($checking) > 0){
             return True;
         } else {
             return False;
         }
    }

    function isClosed($projectId, $link){
         $query = mysqli_fetch_assoc($link -> queryExec("SELECT projectEndDate FROM projects WHERE idProject='$projectId';"));
         $endDate = $query['projectEndDate'];
         if($endDate<date("Y-m-d")){
             return True;
         }else{
             return False;
         }
     }


     function isOwner($link,$userId, $projectId){
         $res = $link -> queryExec("SELECT idUser FROM projects WHERE idUser=\"$userId\" AND idProject=\"$projectId\";");
         if (mysqli_num_rows($res) == 1) {
             return 1;
         } else {
             return 0;
         }
     }

    function projectDetails($projectId, $link){
        $projectDetailsArray = mysqli_fetch_assoc($link -> queryExec("SELECT * FROM projects WHERE idProject='$projectId';"));
        return $projectDetailsArray;
    }

    function projectsBudget($projectId, $link){
         $total = mysqli_fetch_assoc($link -> queryExec("SELECT SUM(investmentFund) totalSum
         FROM projects_investors
         WHERE idProject='$projectId';"))['totalSum'];
         return $total;
    }



    $projectId = $_GET['idProject']; 
    $userId = $_SESSION['user_id'];

    $projHistory = $link ->  queryExec("SELECT * FROM `projects_investors` JOIN users USING (idUser) WHERE idProject='$projectId';");

    $projDetails = projectDetails($projectId, $link);

    $remainMoney = $projDetails['requestedFund'] - projectsBudget($projectId, $link);

    if (isset($_POST['donate'])){
        $amount = $_POST['amount'];
        $date_ = $_POST['date_'];
        $date = date("Y-m-d", $timestamp);
        $insertQuery = "INSERT INTO `projects_investors` (`idUser`, `idProject`, `investmentFund`, `investmentDate`) 
        VALUES ('$userId', '$projectId', '$amount', '$date');";
        if ($link-> queryExec($insertQuery)) {
            header("Location:index.php");
        }else{
            echo '<script>There is problem</script>';
        }
}
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="projectDetailUserStyle.css">
    <title>Document</title>
</head>
<body>
    <?php   
        echo '<div style="text-align: center;"><a class="homeLink" href="index.php">Home</a></div>';
        echo '<div><h2 class="proj_title">'.$projDetails['projectName'].'</h2></div>';
        echo "<p class=\"proj_amount\">Requested fund: ".$projDetails['requestedFund']."$</p>";
    
    if(isInvested($link,$userId, $projectId)==1){
        echo '<p class="msg">You have already donated one time. You cannot donate for this project second time!!!</p>';
    }
    else if(isClosed($projectId, $link)==1){
        echo '<p class="msg">Sorry:( Time to donate to this project has already finished.</p>';
    }
    else{
        if(isOwner($link,$userId, $projectId)==0){
            if($remainMoney>0){
                echo '<form>';
                echo '<label for="amount">Amount: </label>';
                echo '<input class="inp" type="number" id="amount" name="amount" max="'.$remainMoney.'"><br>';
                echo '<label for="starting">Date: </label>';
                echo '<input class="inp" type="date" id="starting" name="starting" min="'.$projDetails['projectEndDate'].'"><br>';
                echo '<input class="invest-btn" type="submit" name="invest" id="submit" value="Invest">';
                echo '</form>';
            }else{
                echo '<p class="notInvest">Required amount has already collected. No need to invest!</p>';
            }
        }else{
            echo '<p class="ownerMessage">You are owner of this project</p>';
        }
    }
    ?>
</body>
</html>

<?php
    if(isOwner($link,$userId, $projectId)==1){
        include('projectDetailOwner.php');
    }
?>


