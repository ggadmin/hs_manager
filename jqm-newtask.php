<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 9:04 AM
 */

function generateNewTaskPage($projName)
{
    $project = getProject($projName);
    if (!$project)
    {
        exit("project not found.");
    }

    $html =
        '<div data-role="page" id="newTaskPage" data-theme="b" data-title="New Task">
            <div data-role="header" data-theme="b">
                <h1>Add task to: ' . $project['name'] . '</h1>
            </div>
            <div data-role="content">
                <form id="newTask" class="ui-body ui-body-b ui-corner-all" action="proj_man.php" data-ajax="false" method="POST">
                    <input data-role="none" type="hidden" name="cmd" id="cmd" value="newtask">
                    <input data-role="none" type="hidden" name="project" id="project" value="' . $project['name'] . '">
                    <div data-role="fieldcontain">
                        <label for="task">Task Title:</label>
                        <input type="text" id="task" name="task">
                    </div>
                    <div data-role="fieldcontain">
                        <label for="pointvalue">Point Value:</label>
                        <input type="text" id="pointvalue" name="pointvalue">
                    </div>
                    <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
                </form>
            </div>
        </div>';
    echo $html;
}
