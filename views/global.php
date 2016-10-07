<div class="header_div"><h2>global feed</h2></div>
<div class="activity_container">
    <div class="activity_nav">
        <ul class="nav nav-pills">
            <li class="active"><a href="global.php">global</a></li>
            <li><a href="personal.php">personal</a></li>
        </ul>
    </div>
    
    <table class="table table-striped">
    <thead>
        <tr>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach ($task_rows as $tr)
            {
                $username = $tr["username"];
                $task = $tr["task_name"];
                
                if ($tr["status"] == "completed")
                    $verb = "</strong> completed <strong>";
                else
                    $verb = "</strong> added <strong>";
                
                print("<tr class='activity_tr'>");
                                print("<td><strong><a class='activity_user' href='". $username ."'>" . $username . "</a>" . $verb . $task . "</td>");
                print("</tr>");
            }
        ?>
    </tbody>
    </table>
</div>
