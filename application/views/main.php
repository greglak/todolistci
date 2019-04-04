<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Greg's Wishlist Generator</title>
  <meta name="description" content="Greg's Wishlist Generator">
  <link rel="icon" href="<?=base_url()?>/download.png" type="image/gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">



  <style>

      #contacts { margin:auto; }
      .contact-container { width:400px; padding:10px; border:1px solid #aaa; margin:0 10px 10px 0; position:relative; float:left; font-family:sans-serif; color:#333; background-color:#eee; }
      .contact-container h1 { margin:0; font-weight:normal; }
      .contact-container h1 span { float:right; font-size:14px; line-height:24px; font-weight:normal; }
      .contact-container img { border-width:1px; border-style:solid; border-color:#fff; border-right-color:#aaa; border-bottom-color:#aaa; margin-right:10px; float:left; }
      .contact-container div { margin-bottom:24px; font-size:14px; }
      .contact-container a { color:#333;}
      .contact-container dl { margin:0; float:left; font-size:14px; }
      .contact-container dt, .contact-container dd { margin:0; float:left; }
      .contact-container dt { width:50px; clear:left; }
      .contact-container button { margin-top:10px; float:right; }

      header { margin-bottom:10px; }
      header:after { content:""; display:block; height:0; visibility:hidden; clear:both; font-size:0; line-height:0; }

      
      
  
      .contact-container form button { margin:5px 0 0; }

		</style>


</head>

<body>
<header>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li><a href='<?php echo base_url()."index.php/WishlistController/logout"; ?>'>Logout</a> </li>
        
      </ul>   
    </div>
  </nav>
</header>

<main>
  <div class="container-fluid">
    <div class="jumbotron">
      <h1 class="text-center"><?php echo $_SESSION['loginsession']['username']?>'s Wishlist</h1>      
    </div>
    <div class="row content">
      <!-- The Main mate! -->
      <!-- <?php	echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?> -->
      <!-- <?php	echo '<pre>' . print_r($celebs) . '</pre>'; ?> -->
    </div>
  </div>
  <div class="container">
    <div id="contacts">
      <header>
          
      <div class='row'>
      <form id="addContact" action="#">
          <div class="col-xs-2">
            Name
            <input class="form-control" id="name" />
          </div>
          <div class="col-xs-4">
            Url
            <input class="form-control" id="url" />
          </div>
          <div class="col-xs-2">
            Price
            <input class="form-control" id="price" />
          </div>
          <div class="col-xs-3">
            Category
            <select class="form-control" id="type">>
              <option value="High">High</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low</option>
            </select>
          </div>
          <div class="col-xs-1">
          <br>
              <button class="btn btn-default" id="add">Add</button>
          </div>         
      </form>
      </div>
          <div class="col-xs-12">
      
            <div class="form-group">
              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                  <input type="submit" name="shareList-submit" id="shareList-submit" tabindex="4" class="form-control btn btn-shareList" value="Share List">
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <div id="shareListMessage" style="text-align: center;">
                  <p id="info"> </p>
                </div>
              </div>
            </div>

          </div>
      </header>
        
      <script id="contactTemplate" type="text/template">
          <h1><%= name %><span><%= type %></span></h1>
          <div><a target="_blank" href="<%= url %>">Link</a></div>
          <dl>
              <dt>Price:</dt><dd><%= price %></dd>
          </dl>
          <button class="delete">Delete</button>
          <button class="edit">Edit</button>
      </script>
      <script id="contactEditTemplate" type="text/template">
          <form action="#">       
              <input class="name" value="<%= name %>" />
              <input class="url" value="<%= url %>" />
              <input class="price" value="<%= price %>" />
              <!-- <input id="type" type="hidden" value="<%= type %>" /> -->
              <select class="type" id="type">>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
              <button class="save">Save</button>
              <button class="cancel">Cancel</button>
          </form>
      </script>
    </div>
	</div> <!-- container -->
</main>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>		  
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script>
<script src="<?php echo base_url() ?>static/js/reverse.js"></script>
</body>
</html>