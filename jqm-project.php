<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 9:00 AM
 */

function generateActiveTaskList($project)
{
    $html =
        '<li data-role="list-divider">Active Tasks</li>';
    foreach ($project['tasks'] as $task)
    {
        if (!$task['completed'])
        {
            $html .= '<li>
                            <a
                                data-transition="slide"
                                href="proj_man.php?view=edittask&project=' . $project['name'] . '&task=' . $task['name'] .'">'
                . $task['name']
                .'</a>
                      </li>';
        }
    }

    echo $html;
}

function generateCompletedTaskList($project)
{
    $html =
        '<li data-role="list-divider">Completed Tasks</li>';
    foreach ($project['tasks'] as $task)
    {
        if ($task['completed'] == true)
        {
            $html .= '<li>
                            <a
                                data-transition="slide"
                                href="proj_man.php?view=edittask&project=' . $project['name'] . '&task=' . $task['name'] .'">'
                . $task['name']
                .'</a>
                      </li>';
        }
    }

    echo $html;
}

function generateProjectControls($project)
{
    $html .=
        '<li>
           <a
               data-transition="slide"
               href="proj_man.php?view=editproject&project=' . $project['name'] . '">
                Edit Project
            </a>
         </li>';

    if(!$project['completed'])
    {
        $html =
            '<li>
                <a
                    data-transition="slide"
                    href="proj_man.php?view=newtask&project=' . $project['name'] . '">
                Add Task
            </a>
         </li>';
    }

    echo $html;
}

function generateProjectContainer($project)
{
    $html = '<li>
                <div data-role="collapsible" data-theme="b" data-content-theme="b">
                    <h3>' . $project['name'] . '</h3>
                    <ul data-role="listview" data-filter="false">';
    echo $html;
}

function generateActiveProjectList($projects)
{
    echo '<li data-role="list-divider">Active Projects</li>';

    foreach ($projects as $project)
    {
        if (!$project['completed'])
        {
            generateProjectContainer($project);
            generateActiveTaskList($project);
            generateCompletedTaskList($project);
            generateProjectControls($project);
            echo '</ul></div></li>';
        }
    }
}

function generateCompletedProjectList($projects)
{
    echo '<li data-role="list-divider">Completed Projects</li>';

    foreach ($projects as $project)
    {
        if ($project['completed'])
        {
            generateProjectContainer($project);
            generateActiveTaskList($project);
            generateCompletedTaskList($project);
            generateProjectControls($project);
            echo '</ul></div></li>';
        }
    }
}

function generateProjectPageHeader()
{
    $html =
        '<div data-role="page" id="projectPage" data-theme="b" data-title="Project Manager">
            <div data-role="header">
                <h1>Project Manager</h1>
            </div>
            <ul data-role="listview" data-inset="true">';
    echo $html;
}

function generateProjectPageFooter()
{
    $html =
        '</ul>
        <div data-role="footer" class="ui-bar">
            <a data-role="button" href="proj_man.php?view=newtask&project=default" data-transition="pop" >New Task</a>
            <a data-role="button" href="proj_man.php?view=newproject" data-transition="pop" >Create Project</a>
        </div>
    </div>'; // end of main page
    echo $html;
}

function generateProjectsPage()
{
    $projects = findProjects();
    generateProjectPageHeader();
    generateActiveProjectList($projects);
    generateCompletedProjectList($projects);
    generateProjectPageFooter();
}






