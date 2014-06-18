<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 9:04 AM
 */

function generateEditTaskPage($projName, $taskName)
{
    $project = getProject($projName);
    if (!$project)
    {
        exit("project not found.");
    }
    if (!isset($project['tasks'][$taskName]))
    {
        exit("task not found.");
    }
    $task = $project['tasks'][$taskName];

    $completeCheckSetting = "";
    if ($project['completed'])
    {
        $completeCheckSetting = "checked";
    }

    $html =
        '<div data-role="page" id="editTaskPage" data-theme="b" data-title="Edit Task">
            <div data-role="header" data-theme="b">
                <h1>' . $task['name'] . '</h1>
            </div>
            <div data-role="content">
                <form id="newProject" class="ui-body ui-body-b ui-corner-all" action="proj_man.php" data-ajax="false" method="POST">
                    <input data-role="none" type="hidden" name="cmd" id="cmd" value="edittask">
                    <input data-role="none" type="hidden" name="project" id="project" value="' . $project['name'] . '">
                    <input data-role="none" type="hidden" name="task" id="task" value="' . $task['name'] . '">
                    <div data-role="fieldcontain">
                        <label for="descrip">Project Description:</label>
                        <input type="text" id="descrip" name="descrip" value="' . $task['descrip'] . '">
                    </div>
                    <div data-role="fieldcontain">
                        <label for="pointvalue">Point Value:</label>
                        <input type="number" id="pointvalue" name="pointvalue" value="' . $task['pointvalue'] . '">
                    </div>
                    <div data-role="fieldcontain">
                        <label for="completed">Completed:</label>
                        <input type="checkbox" id="completed" name="completed[]" value="true" ' . $completeCheckSetting . '>
                    </div>
                    <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
                </form>
            </div>
        </div>';
    echo $html;
}
