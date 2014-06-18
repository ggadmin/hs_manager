<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 6/15/14
 * Time: 3:24 PM
 */

/*
function findContributors($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('project_man', 'contributors');

    $contributors = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $contributors = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $contributors = iterator_to_array($cursor);
    }

    return $contributors;
}
*/

function findContributors($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('project_man', 'contributors');

    $contributors = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $contributors = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $contributors = iterator_to_array($cursor);
    }

    return $contributors;
}

function updateContributors($name, $atts)
{
    if (!isset($name))
    {
        return array("ERROR" => "Contributors requires a name to update.");
    }

    if (!is_array($atts))
    {
        return array("ERROR" => "need a contributor attributes to update.");
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('project_man', 'contributors');

    $collection->findAndModify(
        array('name' => $name),
        array('$set' => $atts)
    );
    return true;
}

function findProjects($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('project_man', 'projects');

    $projects = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $projects = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $projects = iterator_to_array($cursor);
    }

    return $projects;
}

function updateProject($name, $atts)
{
    if (!isset($name))
    {
        return array("ERROR" => "project requires a name to update.");
    }

    if (!is_array($atts))
    {
        return array("ERROR" => "need a project attributes to update.");
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('project_man', 'projects');

    $collection->findAndModify(
        array('name' => $name),
        array('$set' => $atts)
    );
    return array('MSG' => "Project Updated.");
}

function getProject($name = "default")
{
    $m = new MongoClient();
    $collection = $m->selectCollection('project_man', 'projects');

    return $collection->findOne(array('name' => $name));
}

function getContributorStats($contributor)
{

}

function addTask($task, $pName = "default")
{
    if (!is_array($task))
    {
        return array("ERROR" => "task needs to be an array.");
    }
    if (!isset($task['name']))
    {
        return array("ERROR" => "task needs a name.");
    }

    $project = getProject($pName);
    if (!$project)
    {
        return array("ERROR" => "Project not found.");
    }

    if (isset($project['tasks']))
    {
        if (isset($project['tasks'][$task['name']]))
        {
            return array('ERROR' => "Task Exists!");
        }
    }

    $project['tasks'][$task['name']] = $task;

    updateProject($pName, array('tasks' => $project['tasks']));

}

function addProject($project)
{
    if (!isset($project['name']))
    {
        return array('ERROR' => "Project requires name!");
    }

    if (getProject($project['name']))
    {
        return array('ERROR' => "Project already exists!");
    }

    $m = new MongoClient();
    $collection = $m->selectCollection('project_man', 'projects');

    if($collection->insert($project))
    {
        return array('MSG' => "Project added!");
    }
    else
    {
        return array('ERROR' => "Project add failure!");
    }
}

function hasActiveTasks($project)
{
    foreach ($project['tasks'] as $task)
    {
        if (!$task['completed'])
        {
            return true;
        }
    }
    return false;
}

