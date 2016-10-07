<div class="header_div">
    <h1>
        <?= $username; ?>
    </h1>
</div>

<div id="profile_class">
    <h3>
    <?php 
        if (empty($class))
        {
            echo "noob";
        }
        else
        {
            echo $class;
        }
        
    ?>
    </h3>
</div>
    <h6 id="profile_class_txt">class</h6>


<div id="profile_picture">
    <img src="/img/generic-logo.png"></img>
</div>

<a href="logout.php"><strong>log out</strong></a>

<table class="table table-bordered" id="profile_table">
    <tr>
        <td id="task_count"><?= $task_count ?></td>
        <td id="xp"><?= number_format($xp) ?></td>
        <td id="streak_count"><?= $streak_count ?></td>
        <td id="badge_count"><?= $badge_count ?></td>
    </tr>
    <tr>
        <td class="task_count">completed tasks</td>
        <td class="xp">xp</td>
        <td class="streak_count">streak</td>
        <td class="badge_count">badges</td>
    </tr>
</table>

<div class="header_div"><h2>badges</h2></div


<div id="badge_container">
    <?php 
    $counter = 0;
    foreach ($badge_rows as $br)
    {
        $achieved = 0;
        foreach ($badges_achieved as $ba)
        {
            if ($br['badge_id'] == $ba)
            {
                $achieved = 1;
            }
        }
        if ($counter % 3 == 0) { print("<div class='badge_row'>"); }
        if ($achieved == 1) { print("<div class='badge_box_achieved'>"); }
        else { print("<div class='badge_box'>"); }
        print("         <div class='badge_name'><h4>" . $br['badge_name'] . "</h4></div>
                        <img class='badge_image' src='/img/badge_icon_w.png'></img>
                        <div class='badge_description'><p>" . $br['badge_description'] . "</p></div>
                   </div>");
        if ($counter % 3 == 2) { print("</div>"); }
        $counter++;
    }
    ?>
</div>