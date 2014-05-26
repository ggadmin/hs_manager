<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 5/21/14
 * Time: 10:45 PM
 */

class jqm_menu_component
{
    public $id;
    public $type;
    public $theme;
    public $value;
    public $children;

    public function __construct($id, $type, $theme = "a", $value = "")
    {
        $this->$id = $id;
        $this->$type = $type;
        $this->$theme = $theme;
        $this->$value = $value;
    }

    public function insertComponent(jqm_menu_component $component)
    {
        if (!$this->children)
        {
            $this->children = array();
        }

        $this->children[] = $component;
    }
}

function createPage($id)
{
    $page = new jqm_menu_component($id, "page");
    return $page;
}




class jqm_menu
{
    private $mainPage;
    private $pages;

    public function __construct(jqm_menu_component $mainPage)
    {
        $this->mainPage = $mainPage;
    }

    public function insertPage(jqm_menu_component $page)
    {
        if (!$this->pages)
        {
            $this->pages = array();
        }

        $this->pages[] = $page;
    }
}

function generateComponent($component)
{
    if (!isset($component['type']))
    {
        return;
    }

    $type = $component['type'];

    switch ($type)
    {
        case 'page':
            break;
        case 'selector':
    }

}

function generateMenu(jqm_menu $menu)
{

}


function findMenu($sCriteria = NULL)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'menus');

    $menus = NULL;

    if ($sCriteria)
    {
        $cursor = $collection->find($sCriteria);
        $menus = iterator_to_array($cursor);
    }
    else
    {
        $cursor = $collection->find();
        $menus = iterator_to_array($cursor);
    }

    return $menus;
}

function getMenu($menuID)
{
    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'menus');

    $menu = $collection->findOne(array('id' => $menuID));

    return $menu;
}

function updateMenu($menuID, $atts)
{
    if ( !$menuID )
    {
        return false;
    }
    elseif (!is_array($atts))
    {
        return false;
    }

    $m = new MongoClient();

    $collection = $m->selectCollection('gg_admin', 'menus');

    $collection->findAndModify(
        array('id' => $menuID),
        array('$set' => $atts)
    );
    return true;
}


