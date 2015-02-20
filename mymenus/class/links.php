<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package         Mymenus
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: links.php 12408 2014-03-25 08:47:48Z beckmi $
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');
include_once dirname(__DIR__) . '/include/common.php';

/**
 * Class MymenusLinks
 */
class MymenusLinks extends XoopsObject
{
    /**
     * @var Module_skeletonModule_skeleton
     * @access private
     */
    private $mymenus = null;

    /**
     * constructor
     */
    function __construct()
    {
        $this->mymenus = MymenusMymenus::getInstance();
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('id', XOBJ_DTYPE_INT);
        $this->initVar('pid', XOBJ_DTYPE_INT);
        $this->initVar('mid', XOBJ_DTYPE_INT);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('alt_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('visible', XOBJ_DTYPE_INT, 1);
        $this->initVar('link', XOBJ_DTYPE_TXTBOX);
        $this->initVar('weight', XOBJ_DTYPE_INT, 255);
        $this->initVar('target', XOBJ_DTYPE_TXTBOX);
        $this->initVar('groups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
        $this->initVar('hooks', XOBJ_DTYPE_ARRAY, serialize(array()));
        $this->initVar('image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('css', XOBJ_DTYPE_TXTBOX);
    }

    /**
     * @return bool
     */
    function checkAccess()
    {
        $hooks = $this->getHooks();
        $hooks['mymenus'][] = 'checkAccess';
        foreach ($hooks as $hookname => $hook) {
            if (!mymenus_hook($hookname, 'checkAccess', array('links' => $this))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    function getHooks()
    {
        $ret = array();
        $data = $this->getVar('hooks', 'n');
        if (!$data) return $ret;
        $lines = explode("\n", $data);
        foreach ($lines as $line) {
            $line = trim($line);
            $line = explode('|', $line);
            $hook = trim($line[0]);
            $method = isset($line[1]) ? trim($line[1]) : '';
            //$info = split(',', trim($line[0]));
            $ret[$hook][] = $method;
        }

        return $ret;
    }
}

/**
 * Class MymenusLinksHandler
 */
class MymenusLinksHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var MymenusMymenus
     * @access private
     */
    private $mymenus = null;

    /**
     * @param null|object   $db
     */
    function __construct($db)
    {
        parent::__construct($db, 'mymenus_links', 'MymenusLinks', 'id', 'title');
        $this->mymenus = MymenusMymenus::getInstance();
    }

    /**
     * @param $obj
     */
    function update_weights(&$obj)
    {
        $sql = "UPDATE " . $this->table . " SET weight = weight+1";
        $sql .= " WHERE";
        $sql .= " weight >= " . $obj->getVar('weight');
        $sql .= " AND";
        $sql .= " id <> " . $obj->getVar('id');
        //$sql .= " AND pid = " . $obj->getVar('pid');
        $sql .= " AND";
        $sql .= " mid = " . $obj->getVar('mid');
        $this->db->queryF($sql);

        $sql = "SELECT id FROM " . $this->table;
        $sql .= " WHERE mid = " . $obj->getVar('mid');
        //$sql .= " AND pid = " . $obj->getVar('pid');
        $sql .= " ORDER BY weight ASC";
        $result = $this->db->query($sql);
        $i = 1;  //lets start at 1 please!
        while (list($id) = $this->db->fetchrow($result)) {
            $sql = "UPDATE " . $this->table;
            $sql .= " SET weight = {$i}";
            $sql .= " WHERE id = {$id}";
            $this->db->queryF($sql);
            ++$i;
        }
    }
}
