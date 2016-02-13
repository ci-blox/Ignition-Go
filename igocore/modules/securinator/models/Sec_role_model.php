<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Securinator / Security Role Model
 *
 * Role definitions
 */
class Sec_role_model extends IGO_Model
{
    /** @var string Name of the table. */
    protected $table_name = 'sec_roles';

    /** @var string Name of the primary key. */
    protected $key = 'role';

    /** @var bool Use soft deletes (if true). */
    protected $soft_deletes = true;

    /** @var string The date format to use. */
    protected $date_format = 'datetime';

    /** @var bool Set the created time automatically (if true). */
    protected $set_created = false;

    /** @var bool Set the modified time automatically (if true). */
    protected $set_modified = false;

    //--------------------------------------------------------------------------

    /**
     * Returns the the default role.
     *
     * @return string|bool ID of the default role or false.
     */
    public function default_role()
    {
        $this->where('default', 1);
        $query = $this->db->get($this->table_name);

        $row = $query->row();
        if (empty($row) || ! isset($row->role)) {
            return false;
        }

        return (string)$row->role;
    }

    
}