<?php

    // configuration
    require("../includes/config.php");

            // gets current username and id
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    
    // returns array of 100 latest tasks that were added or completed
    $task_completed = CS50::query("SELECT *
                                    FROM tasks
                                    WHERE status = ? AND user_id = ?
                                    ORDER BY date_completed DESC
                                    LIMIT 10", "completed", $id);
    $completed = [];
    
    foreach ($task_completed as $tc)
    {
            $completed[] = [
                "task_name" => $tc["task_name"],
                "username" => $tc["username"],
                "date_created" => $tc["date_created"],
                "date_completed" => $tc["date_completed"],
                "status" => $tc["status"]
            ];
    }

    $task_added = CS50::query("SELECT *
                                    FROM tasks
                                    WHERE status = ? AND user_id = ?
                                    ORDER BY date_created DESC
                                    LIMIT 10", "active", $id);
    
    $added = [];
    
    foreach ($task_added as $ta)
    {
            $added[] = [
                "task_name" => $ta["task_name"],
                "username" => $ta["username"],
                "date_created" => $ta["date_created"],
                "date_completed" => $ta["date_completed"],
                "status" => $ta["status"]
            ];
    }
                                    
    $task_all = [];
    
    $total_count = count($added) + count($completed);
    
    
    $last_added = null;
    $last_completed = null;
    $last_added_date = null;
    $last_completed_date = null;
    
    for ($i = 0; $i < $total_count; $i++)
    {
        
        if ($last_added == null && $last_completed == null)
        {
            $last_added = array_shift($added);
            $last_completed = array_shift($completed);
            $last_added_date = $last_added["date_created"];
            $last_completed_date = $last_completed["date_completed"];
            
            if ($last_added_date > $last_completed_date)
            {
                array_push($task_all, $last_added);
                $last_added = null;
            }
            else
            {
                array_push($task_all, $last_completed);
                $last_completed = null;
            }
        }
        
        else if ($last_added == null)
        {
            $last_added = array_shift($added);
            $last_added_date = $last_added["date_created"];

            if ($last_added_date > $last_completed_date)
            {
                array_push($task_all, $last_added);
                $last_added = null;
            }
            else
            {
                array_push($task_all, $last_completed);
                $last_completed = null;
            }
        }
        
        else if ($last_completed == null)
        {
            $last_completed = array_shift($completed);
            $last_completed_date = $last_completed["date_completed"];

            if ($last_added_date > $last_completed_date)
            {
                array_push($task_all, $last_added);
                $last_added = null;
            }
            else
            {
                array_push($task_all, $last_completed);
                $last_completed = null;
            }
        }
    }
    
    // returns array of 100 highest xp users
    $user_rows = CS50::query("SELECT * FROM users WHERE id=?", $id);
    $user_row = $user_rows[0];
    
    
    

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render personal activity
        render("personal.php", ["title" => "personal activity",
                                 "username" => $username,
                                 "task_rows" => $task_all
                                 ]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

    }
?>