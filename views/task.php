<div id="task_info">
    <p id="date"><?= $date ?></p>
    <span id="task_border">
        <div  id="task_stats">
            <img class="task_icon" src="/img/check_icon.png"/>
            <span class="task_num"><?= $multi_count ?></span>
            <img class="task_icon" src="/img/fire-icon.png"/>
            <span class="task_num"><?= $streak_count ?></span>
        </div>
    </span>
</div>


<div id="task_list">
    <h1 class="task_header">today</h1>
        <table class="table table-striped task_tbl">
        <thead>
        </thead>
        <tbody>
            <?php foreach ($today as $td): ?>
                <tr>
                    <td class="task_check">
                        <form>
                            <input type="hidden" name="checked" value="<?= $td['id'] ?>"/>
                        </form>
                    </td>
                    <td class="task_name"><?= $td['task_name'] ?></td>
                    <td class="task_complete">
                        <form class="completed" action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= $td['id'] ?>"/>
                            <button type="submit" class="btn btn-info completed" name="completed" value="true">X</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
    
    <h1 class="task_header">tomorrow</h1>
        <table class="table table-striped task_tbl">
        <thead>
        </thead>
        <tbody>
            <?php foreach ($tomorrow as $tm): ?>
                <tr>
                    <td class="task_check">
                        <form>
                            <input type="hidden" name="checked" value="<?= $tm['id'] ?>"/>
                        </form>
                    </td>
                    <td class="task_name"><?= $tm['task_name'] ?></td>
                    <td class="task_complete">
                        <form class="completed" action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= $tm['id'] ?>"/>
                            <button type="submit" class="btn btn-info completed" name="completed" value="true">X</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
    <h1 class="task_header">pipeline</h1>
        <table class="table table-striped task_tbl">
        <thead>
        </thead>
        <tbody>
            <?php foreach ($pipeline as $pl): ?>
                <tr>
                    <td class="task_check">
                        <form>
                            <input type="hidden" name="checked" value="<?= $pl['id'] ?>"/>
                        </form>
                    </td>
                    <td class="task_name"><?= $pl['task_name'] ?></td>
                    <td class="task_complete">
                        <form class="completed" action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= $pl['id'] ?>"/>
                            <button type="submit" class="btn btn-info completed" name="completed" value="true">X</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
    <h1 class="task_header">indefinite</h1>
        <table class="table table-striped task_tbl">
        <thead>
        </thead>
        <tbody>
            <?php foreach ($unknown as $uk): ?>
                <tr>
                    <td class="task_check">
                        <form>
                            <input type="hidden" name="checked" value="<?= $uk['id'] ?>"/>
                        </form>
                    </td>
                    <td class="task_name"><?= $uk['task_name'] ?></td>
                    <td class="task_complete">
                        <form class="completed" action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= $uk['id'] ?>"/>
                            <button type="submit" class="btn btn-info completed" name="completed" value="true">X</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
        </table>
</div>
