<?php

    // configuration
    require("../includes/config.php");
    
    $badge_rows = CS50::query("SELECT * FROM badges");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // gets current username and id
        $username = $_SESSION["username"];
        $id = $_SESSION["id"];
        
        // returns user
        $user_rows = CS50::query("SELECT * FROM users WHERE id=?", $id);
        $user_row = $user_rows[0];
        
        $xp = $user_row["xp"];
        $task_count = $user_row["task_count"];
        $streak_count = $user_row["streak_count"];
        $class = $user_row["class"];
        
        $badges = get_user_badges($id);
        $badge_sum = 0;
        
        // holds array of badge_id's that have been achieved
        $badges_achieved = [];
        
        foreach ($badges as $k=>$v)
        {   
            if ($v == 1)
            {
                $badge_sum += $v;
                array_push($badges_achieved, $k+1);
            }
        }
        
        
        // render profile
        render("profile.php", ["title" => "global",
                                 "username" => $username,
                                 "class" => $class,
                                 "xp" => $xp,
                                 "task_count" => $task_count,
                                 "streak_count" => $streak_count,
                                 "badge_count" => $badge_sum,
                                 "badge_rows" => $badge_rows,
                                 "badges_achieved" => $badges_achieved
                                 ]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["username"];
        
        // returns user
        $user_rows = CS50::query("SELECT * FROM users WHERE username=?", $username);
        $user_row = $user_rows[0];
        $id = $user_row["id"];
        
        $xp = $user_row["xp"];
        $task_count = $user_row["task_count"];
        $streak_count = $user_row["streak_count"];
        $class = $user_row["class"];
        
        $badges = get_user_badges($id);
        $badge_sum = 0;
        
        // holds array of badge_id's that have been achieved
        $badges_achieved = [];
        
        foreach ($badges as $k=>$v)
        {   
            if ($v == 1)
            {
                $badge_sum += $v;
                array_push($badges_achieved, $k);
            }
        }
        
        // render profile
        render("profile.php", ["title" => "profile",
                                 "username" => $username,
                                 "class" => $class,
                                 "xp" => $xp,
                                 "task_count" => $task_count,
                                 "streak_count" => $streak_count,
                                 "badge_count" => $badge_sum,
                                 "badge_rows" => $badge_rows,
                                 "badges_achieved" => $badges_achieved
                                 ]);
        
    }
?>