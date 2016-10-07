<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Your passwords do not match.");
        }
        
        // insert new user into users database
        $rows = CS50::query("INSERT IGNORE INTO users (username, hash) VALUES(?, ?)", $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT));
        
        //dump();
        
        if ($rows !== 1)
        {
            apologize("This username is taken.");
        }
        else
        {
            // select last inserted user
            $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
            $rows[0] = $row;
            
            // grab the new user's ID and username
            $id = $row["id"];
            $username = $row["username"];
            
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $row;
            
            // redirect to portfolio
            redirect("/");
        }
        
    }
?>