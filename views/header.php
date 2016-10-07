<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>taskraft: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>taskraft</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>
        
        <script src="/js/jquery.redirect.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <!---->
                <?php if (!empty($_SESSION["id"])): ?>
                    <div id="nav_tab">
                        <ul class="nav nav-tabs">
                            <li id="task_add"><a href="new_task.php"><strong>+</strong></a></li>
                            <li class="task_tab"><a href="global.php">activity</a></li>
                            <li class="active task_tab"><a href="index.php">pipeline</a></li>
                            <li class="task_tab"><a href="profile.php"><?= $_SESSION["username"] ?></a></li>
                        </ul>
                    </div>
                <?php endif ?>
            </div>

            <div id="middle">
