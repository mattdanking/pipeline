<?php
    date_default_timezone_set('America/New_York');
    
    $date = new DateTime("now");
    $timestamp = $date->format('Y-m-d H:i:s');
    
    // configuration
    require("../includes/config.php");
    $username = $_SESSION["username"];

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("task_form.php", ["title" => "add a task"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $task_name = $_POST["task_name"];
        $due_date = $_POST["due_date"];
        $user_id = $_SESSION["id"];
        
        // validate submission
        if (empty($task_name))
        {
            apologize("You must give your task a name.");
        }
        
        // due_date:2016-09-12T09:00
        
        // insert new task into tasks database
        $new_task_row = CS50::query("INSERT INTO tasks (user_id, username, task_name, date_created, due_date) VALUES(?, ?, ?, ?, ?)", $user_id, $username, $task_name, $timestamp, $due_date);
        
        if ($new_task_row !== 1)
        {
            apologize("Sorry something went wrong.");
        }
        else
        {
            $user_update = CS50::query("UPDATE users SET xp = xp + ? WHERE id=?", 20, $user_id);
            
            // redirect to portfolio
            redirect("/");
            
            
            
            /* select last inserted user
            $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
            
            // grab the new user's ID
            $id = $rows[0]["id"];
            
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $rows[0]["username"];
            */

        }
        
    }
?>