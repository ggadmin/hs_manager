<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 9:04 AM
 */

function generateNewProjectPage()
{
    $html =
        '<div data-role="page" id="newProjectPage" data-theme="b" data-title="New Project">
            <div data-role="header" data-theme="b">
                <h1>New Project</h1>
            </div>
            <div data-role="content">
                <form id="newProject" class="ui-body ui-body-b ui-corner-all" action="proj_man.php" data-ajax="false" method="POST">
                    <input data-role="none" type="hidden" name="cmd" id="cmd" value="newproject">
                    <div data-role="fieldcontain">
                        <label for="project">Project Title:</label>
                        <input type="text" id="project" name="project">
                    </div>
                    <div data-role="fieldcontain">
                        <label for="descrip">Project Description:</label>
                        <input type="text" id="descrip" name="descrip">
                    </div>
                    <button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
                </form>
            </div>
        </div>';
    echo $html;
}
