<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Backbone.js Web App</title>
       

        <style>
            #contacts { width:1300px; margin:auto; }
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

            #filter { float:left; }
            #showForm { float:right; }
            #addContact { display:none; width:466px; float:right; clear:both; font-family:sans-serif; font-size:14px; }
            #addContact label { width:60px; margin-right:10px; text-align:right; line-height:25px; }
            #addContact label, #addContact input { display:block; margin-bottom:10px; float:left; }
            #address { width:380px; margin-left:2px; }
            #addContact label[for="name"], #addContact label[for="url"], #addContact label[for="price"] { clear:both; }
            #addContact button { display:block; margin:10px 10px 0 0; float:right; clear:both; }

            .contact-container input, .contact-container select { display:block; margin:0; float:left; }
            .contact-container .name, .contact-container .url { clear:left; }
            .contact-container input { margin:0 10px 3px 0; }
            .contact-container .url { width:395px; margin-right:0; }
            .contact-container .tel { width:90px; }
            .contact-container form button { margin:5px 0 0; }
		</style>
    </head>
    <body>
        <div id="contacts">
            <header>
                <div id="filter"><label>Show me:</label></div>
                <a id="showForm" href="#">Add new contact</a>
                <form id="addContact" action="#">
                    <label for="name">Name:</label><input id="name" />
                    <label for="type">Type:</label><input id="type" /> 
                    <label for="url">Url:</label><input id="url" />
                    <label for="price">Price:</label><input id="price" />
                    <!-- <label for="type">Category:</label><input id="type" /> -->
                    <button id="add">Add</button>         
                </form>
            </header>
        
            <script id="contactTemplate" type="text/template">
                <h1><%= name %><span><%= type %></span></h1>
                <div><a href="<%= url %>">Link</a></div>
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
                    <input id="type" type="hidden" value="<%= type %>" />
                    <button class="save">Save</button>
                    <button class="cancel">Cancel</button>
                </form>
            </script>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>		  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.2.3/backbone-min.js"></script>
        <script src="<?php echo base_url() ?>static/js/reverse.js"></script>
    </body>
</html>