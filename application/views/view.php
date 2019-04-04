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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script> 
</head>

<body>
<header>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
    <ul class="nav navbar-nav">
    <li><a href="<?php echo base_url();?>index.php/">Home</a></li>
    </ul>   
    </div>
</nav>
</header>

<main>
<div class="container-fluid">
    <div class="jumbotron">
    <h1 class="text-center">Wishlist Generator 5000</h1>      
    </div>
	<?php if(isset($listcheck)){ ?>
			

		<div class="row content">
			<form method="post" action="<?php echo base_url();?>index.php/WishlistController/addListById">
				<div class="container">
					<h2>Give a name and a description to your list </h2>
					<hr/>
					<input type="hidden" name="form3" value="whatever">
					<label for="uname"><b>Name of the list</b></label>
					<input type="text" placeholder="Enter List Name" name="listname" required>

					<label for="psw"><b>Description for the list</label>
					<input type="text" placeholder="Enter Description" name="description" required>
				
					<button type="submit" value="Submit Form 2">Create List</button>
				
				</div>
			</form>
		</div>
	<?php } else {?>

	<div class="row content">
		<form method="post" action="<?php echo base_url();?>index.php/WishlistController/login_action">
		<h2>Login Form</h2>
		<hr/>
		<div class="container">
			<?php if(isset($form1_errors)){ ?>
				<h2><?php echo $form1_errors?></h2>
			<?php }?>
			<input type="hidden" name="form1" value="whatever">
			<label for="uname"><b>Username</b></label>
      		<input type="text" placeholder="Enter Username" name="username" required>

      		<label for="psw"><b>Password</b></label>
      		<input type="password" placeholder="Enter Password" name="password" required>
        
      		<button type="submit" value="Submit Form 1">Login</button>
		</div>
		</form>
	</div>
	
	<div class="row content">
		<form method="post" action="<?php echo base_url();?>index.php/WishlistController/registration_action">
		<h2>Registration Form </h2>
		<hr/>
		<div class="container">
			<?php if(isset($form2_errors)){ ?>
				<h2><?php echo $form2_errors?></h2>
			<?php }?>
			<input type="hidden" name="form2" value="whatever">
			<label for="uname"><b>Username</b></label>
      		<input type="text" placeholder="Enter Username" name="registrationUsername" required>

      		<label for="psw"><b>Password</b></label>
      		<input type="password" placeholder="Enter Password" name="password" required>
        
      		<button type="submit" value="Submit Form 2">Sign Up</button>
  
		</div>
		</form>
		<?php if(isset($success_msg)){ ?>
			

		<div class="row content">
			<form method="post" action="<?php echo base_url();?>index.php/WishlistController/addList">
				<div class="container">
					<h2>Give a name and a description to your list </h2>
					<hr/>
					<input type="hidden" name="form3" value="whatever">
					<label for="uname"><b>Name of the list</b></label>
					<input type="text" placeholder="Enter List Name" name="listname" required>

					<label for="psw"><b>Description for the list</label>
					<input type="text" placeholder="Enter Description" name="description" required>
				
					<button type="submit" value="Submit Form 2">Create List</button>
				
				</div>
			</form>
		</div>
		<?php }?>

		<?php }?>
		
	</div>

	</div>
</div>
</main>

</body>
</html>