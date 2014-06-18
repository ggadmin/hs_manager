<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 9:05 AM
 */

function generateEditProjectPage($projName)
{
    $project = getProject($projName);
    if (!$project)
    {
        exit("project not found.");
    }

    $completeCheckSetting = "";
    if ($project['completed'])
    {
        $completeCheckSetting = "checked";
    }

    $html =
        '<div data-role="page" id="editProjectPage" data-theme="b" data-title="Edit Project">
            <div data-role="header" data-theme="b">
                <h1>' . $project['name'] . '</h1>
            </div>
            <div data-role="content">
                <form id="editProject" class="ui-body ui-body-b ui-corner-all" action="proj_man.php" data-ajax="false" method="POST">
                    <input data-role="none" type="hidden" name="cmd" id="cmd" value="editproject">
                    <input data-role="none" type="hidden" name="project" id="project" value="' . $project['name'] . '">
                    <div data-role="fieldcontain">
                        <label for="descrip">Project Description:</label>
                        <input type="text" id="descrip" name="descrip" value="' . $project['descrip'] . '">
                    </div>
                    <div data-role="fieldcontain">
                        <label for="completed">Completed:</label>
                        <input type="checkbox" id="completed" name="completed[]" value="true" ' . $completeCheckSetting . '>
                    </div>
                    <button type="submit" data-theme="b" name="submit" value="submit-value">Save</button>
                </form>
            </div>
        </div>';
    echo $html;
}
