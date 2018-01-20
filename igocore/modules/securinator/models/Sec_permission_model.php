<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Securinator / Security Permission Model
 *
 * Permission definitions - permissions are assigned to roles
 */
class Sec_permission_model extends IGO_Model
{
    /** @var string Name of the table. */
    protected $table_name = 'sec_permissions';

    /** @var string Name of the primary key. */
    protected $key = 'permission_id';

    /** @var bool Use soft deletes (if true). */
    protected $soft_deletes = false;

    /** @var string The date format to use. */
    protected $date_format = 'datetime';

    /** @var bool Set the created time automatically on a new record (if true). */
    protected $set_created = false;

    /** @var bool Set the modified time automatically on editing a record (if true). */
    protected $set_modified = false;


    //--------------------------------------------------------------------------

    function insert_default_permissions($module, $controller) {

        $acts = array('Create', 'Edit', 'Delete', 'View');
        $ret = array();
        foreach ($acts as $act) {
            $idata = array('name'=> $module. '.' . $controller . '.' . $act,
                            'description' => $act . ' for ' . $module,
                            'status' => 'active'
            );
            $this->insert($idata);
            $ret[] =  $this->db->insert_id();
        }
        return $ret;
    }
}