<?php
include('autoload.php');    // spl autoloader



if (Login::isLoggedIn()) {  // validating that the user is logged in 
  $userid = Login::isLoggedIn();
} else {
 Redirect::goto('login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Visual/style.css">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <script type="text/javascript" src="script.js"></script>
   <link rel="icon" type="image/x-icon" href="Visual\img\favicon.ico">
    <script src="https://kit.fontawesome.com/6bfb37676a.js" crossorigin="anonymous"></script>
    <title>COMBINED - SEARCH</title>
</head>
<body>
    <?php include 'navigation.php';  ?>
    <div class="Emission_Line"> </div>

    <div class="searchBox">
        <input type="text" id="search" placeholder="Search for users" autocomplete="off" />
    </div>

    <div class="ResultBox" id="display">
    </div>