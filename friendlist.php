<?php

include('autoload.php');  // loading all classes using spl loader

if (Login::isLoggedIn())  
{
    $userid = Login::isLoggedIn(); 
}
else 
{  
    Redirect::goto('login.php'); 
}
    $isAdmin = authorization::ValidateAdmin($userid);
    $friends = DB::query('SELECT * FROM followers WHERE user_id=:userid', array(':userid'=>$userid));


?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Visual/style.css">
    <link rel="stylesheet" href="Visual/friendlist.css">
       <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
       <link rel="icon" type="image/x-icon" href="Visual\img\favicon.ico">
    <script src="https://kit.fontawesome.com/6bfb37676a.js" crossorigin="anonymous"></script>
    <title>COMBINED FRIENDLIST</title>
</head>
<body>
    <?php include 'navigation.php';  ?>

    <div class="content">
            <div class="list-div">
                <div class="header-text">
                    <h1>FRIENDS (<?php echo count($friends) ?>)</h1>
                </div>

                <div class="friend-list">
                <!-- START -->
                <?php echo User::displayFriendslist($userid); ?>
                <!-- END -->
                </div>
            </div>
    </div>
</body>
</html>