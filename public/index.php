<?php

    // configuration
    require("../includes/config.php"); 
    
    // gets current username and id
    $username = $_SESSION["username"];
    $id = $_SESSION["id"];
    
    $xp_completed = 100;
    
    date_default_timezone_set('America/New_York');
    
    $date = new DateTime("now");
    $timestamp = $date->format('Y-m-d H:i:s');
    
    $beginning_of_time = date('Y-m-d H:i:s' , strtotime("10 years ago", strtotime($timestamp)));
    $beginning_of_day = strtotime("today", strtotime($timestamp));
    $end_of_day = date('Y-m-d H:i:s' , strtotime("tomorrow", $beginning_of_day));
    $end_of_next_day = date('Y-m-d H:i:s' , strtotime("2 days", $beginning_of_day));
    $end_of_time = date('Y-m-d H:i:s' , strtotime("10 years", strtotime($timestamp)));
    
    
    // returns array of each category's tasks - today, tomorrow, soon, someday
    $today = CS50::query("SELECT * FROM tasks WHERE user_id=? AND status=? AND due_date BETWEEN ? AND ?", $id, "active", $beginning_of_time, $end_of_day);
    
    $tomorrow = CS50::query("SELECT * FROM tasks WHERE user_id=? AND status=? AND due_date BETWEEN ? AND ?", $id, "active", $end_of_day, $end_of_next_day);
    
    // upcoming /future / horizon / pipeline
    $pipeline = CS50::query("SELECT * FROM tasks WHERE user_id=? AND status=? AND due_date BETWEEN ? AND ?", $id, "active", $end_of_next_day, $end_of_time);
    
    // someday / dateless / unknown
    $unknown = CS50::query("SELECT * FROM tasks WHERE user_id=? AND status=? AND due_date=?", $id, "active", "0000-00-00 00:00:00");
    
    // On load, check to see if Streak should be reset
    $task_rows = CS50::query("SELECT *
                                FROM tasks
                                WHERE user_id = ?
                                ORDER BY date_completed DESC
                                LIMIT 1", $id);
                                
    if ($task_rows == 1)
    {
        $task_row = $task_rows[0];
        
        $last_task_date_completed = $task_row["date_completed"];
        $day_from_last_task = date('Y-m-d H:i:s', strtotime("tomorrow", strtotime($last_task_date_completed)));
    
        // Today is new day
        if ($day_from_last_task == date('Y-m-d H:i:s', $beginning_of_day))
        {
            // reset streak set today to 0, multi task count to 0
            $streak_update = CS50::query("UPDATE users SET streak_set_today=?, multi_count=? WHERE id=?", 0, 0, $id);
        }
        // if last task was completed more than 1 day ago
        if ($timestamp - $last_task_date_completed > 1)
        {
            // set streak_count to 0, reset streak today to 0, reset multi task count to 0
            $streak_update = CS50::query("UPDATE users SET streak_count=?, streak_set_today=?, multi_count=? WHERE id=?", 0, 0, 0, $id);
        }
    }
    
    // true / false : if user has set a streak today    
    $user_row = CS50::query("SELECT * FROM users WHERE id=?", $id);
    $user_row = $user_row[0];
    $streak_set_today = $user_row["streak_set_today"];
    $task_count = $user_row["task_count"];
    $xp = $user_row["xp"];
    $streak_count = $user_row["streak_count"];
    $multi_count = $user_row["multi_count"];
    
    // array of badges achieved
    $user_badges = get_user_badges($id);
    badge_assign($id, $task_count, $xp, $streak_count, $multi_count);

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render task list
        render("task.php", ["title" => "pipeline",
                             "username" => $username,
                             "today" => $today,
                             "tomorrow" => $tomorrow,
                             "pipeline" => $pipeline,
                             "unknown" => $unknown,
                             "date" => date('l, F j Y', $beginning_of_day),
                             "badges" => $user_badges,
                             "multi_count" => $multi_count,
                             "streak_count" => $streak_count
                             ]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if deleted button is pressed, change task status to 'complete', add xp to user
        if ($_POST["completed"] == "true")
        {
            // Task ID    
            $task_id = $_POST["id"];
            // mark task ascomplete
            $task_update = CS50::query("UPDATE tasks SET status=?, date_completed=? WHERE id=?", "completed", $timestamp, $task_id);
            
            if ($task_update == 0)
            {
                apologize("Sorry something went wrong.");
            }
            
            // if the streak hasn't been set today
            if ($streak_set_today == 0)
            {
                $user_update = CS50::query("UPDATE users SET xp = xp + ?, streak_count = streak_count + ?, streak_set_today=?, 
                                        task_count = task_count + ?, multi_count = multi_count + ? WHERE id=?", $xp_completed, 1, 1, 1, 1, $id);
            }
            // if streak's been incremented already
            else
            {
                $user_update = CS50::query("UPDATE users SET xp = xp + ?, task_count = task_count + ?,
                                        multi_count = multi_count + ? WHERE id=?", $xp_completed, 1, 1, $id);

            }
            
            if ($user_update == 0)
            {
                apologize("Sorry something went wrong.");
            }
        }

        

        
        
        
        // render task list
        render("task.php", ["title" => "pipeline",
                             "username" => $username,
                             "today" => $today,
                             "tomorrow" => $tomorrow,
                             "pipeline" => $pipeline,
                             "unknown" => $unknown,
                             "date" => date('l, F j Y', $beginning_of_day),
                             "badges" => $user_badges,
                             "multi_count" => $multi_count,
                             "streak_count" => $streak_count
                             ]);
        
        
    }    

    /* all of users stock positions
    $positions = [];
    
    foreach ($rows as $row)
    {
            $positions[] = [
                "trade" => $row["trade"],
                "symbol" => $row["symbol"],
                "quantity" => $row["quantity"],
                "price" => $row["price"],
                "date" => $row["datetime"]
            ];
    }
    */

?>
