<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Greg's Wishlist Generator</title>
  <meta name="description" content="Greg's Bookstore">
  <link rel="icon" href="<?=base_url()?>/download.png" type="image/gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<header>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        
      </ul>   
    </div>
  </nav>
</header>

<main>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="text-center">Invalid bit mate</h1>      
    </div>
    <div class="row content">
    <h1>Sorry, You don't have access to this page mate.</h1>  
    <a href='<?php echo base_url()."index.php/WishlistController/login"; ?>'>Login Again</a>
    </div>
  </div>
</main>

</body>
</html>