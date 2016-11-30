<?php

defined('BASEPATH') || exit('No direct script access allowed');
/**
 *Menu Model.
 *
 * menu definitions
 */
class Menu_model extends IGO_Model
{
    /** @var string Name of the table. */
    protected $table_name = 'menu';

    /** @var string Name of the primary key. */
    protected $key = 'id';

    /** @var bool Use soft deletes (if true). */
    protected $soft_deletes = false;

    /** @var string The date format to use. */
    protected $date_format = 'datetime';

    /** @var bool Set the created time automatically (if true). */
    protected $set_created = false;

    /** @var bool Set the modified time automatically (if true). */
    protected $set_modified = false;

    //--------------------------------------------------------------------------
}
