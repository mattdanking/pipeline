<form id="new_task_form" action="new_task.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control new_task_input" name="task_name" placeholder="what's in the pipeline?" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control new_task_input" name="due_date" placeholder="Due Date" value="" type="datetime-local"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Add Task
            </button>
        </div>
    </fieldset>
</form>
