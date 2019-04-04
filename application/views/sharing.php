<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Greg's Wishlist Generator 5000</title>
  <meta name="description" content="Greg's Bookstore">
  <link rel="icon" href="<?=base_url()?>/download.png" type="image/gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
<header>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo base_url();?>index.php/">Create your own list</a></li>
            </ul>   
        </div>
    </nav>
</header>

<main>
<div class="container-fluid">
    <div class="jumbotron">
        <h1 class="text-center">Wishlist Generator 5000</h1>
        <p>Name: <?php echo $listname ?></p>
        <p>Description: <?php	echo $listdescription ?></p>
        <p>Owner: <?php echo $username ?></p>      
    </div>	
    <?php if((!empty($listitems)) || (!isset($listitems))){ ?>
	<div class="row content">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Url</th>
                    <th scope="col">Price</th>
                    <th scope="col">Type</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach($listitems as $item){ ?>
                    <tr>
                        <td><?php echo $item->name?></td>
                        <td><a target="_blank" href="<?php echo $item->url?>">Open Link</a></td>
                        <td>£<?php echo $item->price?></td>
                        <td><?php echo $item->type?></td>
                    </tr>
                <?php } ?>
                
            </tbody>
        </table>
	</div>
    <?php } else {?>
        <div class="row content">
        <h2>Why would you share an empty list :) ask the sender to add things to the list</h2>

        </div>
    <?php } ?>
</div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script> 
</body>
</html>