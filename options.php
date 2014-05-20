<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/16/14
 * Time: 7:41 AM
 */

function getOptions($name)
{
    if (!$name)
    {
        return NULL;
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'options');

    $options = $collection->findone(array('oName' => $name));

    return $options;
}
