<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/16/14
 * Time: 8:58 AM
 */
require_once("tasklist.php");
require_once("jqm-head.php");
require_once("jqm-project.php");
require_once("jqm-newproject.php");
require_once("jqm-newtask.php");
require_once("jqm-editproject.php");
require_once("jqm-edittask.php");

function isChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}

if (isset($_POST['cmd']))
{
    $response = NULL;
    if (!isset($_POST['project']))
    {
        exit("Project name required.");
    }
    $projName = $_POST['project'];
    $task = NULL;
    switch ($_POST['cmd'])
    {
        case "newproject":
            $project = array();
            $project['name'] = $projName;
            if (!isset($_POST['descrip']))
            {
                exit("Project requires description.");
            }
            $project['descrip'] = $_POST['descrip'];
            $project['completed'] = false;
            $project['tasks'] = array();
            $response = addProject($project);
            break;
        case "newtask":
            if (!isset($_POST['task']))
            {
                exit("Task requires name.");
            }
            if (!isset($_POST['pointvalue']))
            {
                exit("Task requires pointvalue.");
            }
            $task = array();

            $task['name'] = $_POST['task'];
            $task['pointvalue'] = (int)$_POST['pointvalue'];
            $task['completed'] = false;
            $response = addTask($task, $projName);
            break;
        case "editproject":
            $oldproject = getProject($projName);
            if (!$oldproject)
            {
                exit("Project not found");
            }
            if (!isset($_POST['descrip']))
            {
                exit("Project requires a description.");
            }
            $project = array();
            $project['name'] = $projName;
            $project['descrip'] = $_POST['descrip'];
            if (isChecked('completed', 'true'))
            {
                $project['completed'] = true;
                if ( $project['pid'] == 0 )
                {
                    exit("Cannot close default project.");
                }
                if ( hasActiveTasks($oldproject) )
                {
                    exit("Cannot close project with active tasks.");
                }
            }
            else
            {
                $project['completed'] = false;
            }
            $project['tasks'] = $oldproject['tasks'];
            $response = updateProject($projName, $project);
            break;
        case "edittask":
            $project = getProject($projName);
            if (!$project)
            {
                exit("Project not found");
            }
            if (!isset($_POST['task']))
            {
                exit("Task requires name.");
            }
            if (!isset($_POST['descrip']))
            {
                exit("Task requires a description.");
            }
            if (!isset($_POST['pointvalue']))
            {
                exit("Task requires pointvalue.");
            }

            $task = array();
            $task['name'] = $_POST['task'];
            $task['descrip'] = $_POST['descrip'];
            $task['pointvalue'] = (int)$_POST['pointvalue'];
            if (isChecked('completed', 'true'))
            {
                $task['completed'] = true;
            }
            else
            {
                $task['completed'] = false;
            }
            if (!isset($project['tasks'][$task['name']]))
            {
                exit("Task not found.");
            }
            $project['tasks'][$task['name']] = $task;
            $response = updateProject($projName, $project);
            break;
    }

    if (isset($response['ERROR']))
    {
        exit("ERROR:". $response['ERROR']);
    }
}

echo '<html>';
generateJQMHeader();
echo '<body>';

if (isset($_GET['view']))
{

    switch ($_GET['view'])
    {
        case "newproject":
            generateNewProjectPage();
            break;
        case "newtask":
            $projName = "default";
            if (isset($_GET['project']))
            {
                $projName = $_GET['project'];
            }
            generateNewTaskPage($projName);
            break;
        case "editproject":
            $projName = "default";
            if (isset($_GET['project']))
            {
                $projName = $_GET['project'];
            }
            generateEditProjectPage($projName);
            break;
        case "edittask":
            $projName = "default";
            if (isset($_GET['project']))
            {
                $projName = $_GET['project'];
            }
            $taskName = "default";
            if (isset($_GET['task']))
            {
                $taskName = $_GET['task'];
            }

            generateEditTaskPage($projName, $taskName);
            break;
        default:
            exit("no view available.");
            break;
    }
}
else
{
    generateProjectsPage();
}
echo '</body>';
echo '</html>';

