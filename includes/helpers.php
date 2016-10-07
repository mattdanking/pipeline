<?php

    /**
     * helpers.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     */

    require_once("config.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
    }

    /**
     * Facilitates debugging by dumping contents of argument(s)
     * to browser.
     */
    function dump()
    {
        $arguments = func_get_args();
        require("../views/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }
    
    function get_user_badges($user_id)
    {
        // rows of user_id and badge_id
        $users_badges = CS50::query("SELECT *
                                        FROM users_badges
                                        JOIN users ON users.id = users_badges.user_FK
                                        JOIN badges ON badges.badge_id = users_badges.badge_FK
                                        WHERE user_FK = ?", $user_id);
        
        // number of achievable badges
        $badge_count = count(CS50::query("SELECT * FROM badges"));
        
        // initialize badges array
        $badges = [];
        for ($i = 0; $i < $badge_count; $i++)
        {
            $badges[$i] = 0;
        }
        
        foreach ($users_badges as $ub)
        {
            $badge_id = $ub["badge_id"];
            // -1 because badges array is 0-indexed and badges_id is not (from users_badges table)
            $badges[$badge_id - 1] = 1;
        }
        
        return $badges;
    }

    /**
     * check for and log badges, when achieved
     */
     
    function badge_achieved($user_id, $badge_id)
    {
        $badge_rows = CS50::query("SELECT * FROM badges WHERE badge_id=?", $badge_id);
        $xp_bonus = $badge_rows[0]["xp"];
        $badge_name = $badge_rows[0]["badge_name"];
        CS50::query("INSERT IGNORE INTO users_badges (user_FK, badge_FK) VALUES (?,?)", $user_id, $badge_id);
        CS50::query("UPDATE users SET xp = xp + ? WHERE id=?", $xp_bonus, $user_id);
        if ($badge_id > 9 && $badge_id < 16)
        {
            CS50::query("UPDATE users SET class=? WHERE id=?", $badge_name, $user_id);
        }
    }
    
    function badge_assign($user_id, $task_count, $xp, $streak_count, $multi_count)
    {
        // get user's badges
        $ub = get_user_badges($user_id);
        
        // TASK TOTAL BADGES
        if ($task_count >= 2 && $ub[0] !== 1) 
        {
            //INSERT IGNORE
            badge_achieved($user_id, 1);
        }
        if ($task_count >= 25 && $ub[1] !== 1)
        {
            badge_achieved($user_id, 2);
        }
        if ($task_count >= 100 && $ub[2] !== 1)
        {
            badge_achieved($user_id, 3);
        }
        
        // TASK STREAK BADGES
        if ($streak_count >= 2 && $ub[3] !== 1) 
        {
            badge_achieved($user_id, 4);
        }
        if ($streak_count >= 4 && $ub[4] !== 1)
        {
            badge_achieved($user_id, 5);
        }
        if ($streak_count >= 7 && $ub[5] !== 1)
        {
            badge_achieved($user_id, 6);
        }
        
        // MULTITASK BADGES
        if ($multi_count >= 3 && $ub[6] !== 1) 
        {
            badge_achieved($user_id, 7);
        }
        if ($multi_count >= 5 && $ub[7] !== 1)
        {
            badge_achieved($user_id, 8);
        }
        if ($multi_count >= 10 && $ub[8] !== 1)
        {
            badge_achieved($user_id, 9);
        }
        
        
        // CLASS XP BADGES
        if ($xp >= 500 && $ub[9] !== 1) 
        {
            // INSERT IGNORE INTO users_badges
            // UPDATE IGNORE 
            badge_achieved($user_id, 10);
        }
        if ($xp >= 3500 && $ub[10] !== 1)
        {
            badge_achieved($user_id, 11);
        }
        if ($xp >= 20000 && $ub[11] !== 1)
        {
            badge_achieved($user_id, 12);
        }
        if ($xp >= 50000 && $ub[12] !== 1)
        {
            badge_achieved($user_id, 13);
        }
        if ($xp >= 100000 && $ub[13] !== 1)
        {
            badge_achieved($user_id, 14);
        }
        if ($xp >= 250000 && $ub[14] !== 1)
        {
            badge_achieved($user_id, 15);
        }
    }

    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     * http://stackoverflow.com/a/25643550/5156190
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }

    /**
     * Renders view, passing in values.
     */
    function render($view, $values = [])
    {
        // if view exists, render it
        if (file_exists("../views/{$view}"))
        {
            // extract variables into local scope
            extract($values);

            // render view (between header and footer)
            require("../views/header.php");
            require("../views/{$view}");
            require("../views/footer.php");
            exit;
        }

        // else err
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }

?>
