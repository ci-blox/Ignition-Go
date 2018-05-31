<?php

/* destination folder for new blox */
$config['buildablox']['toolblox_path'] = APPPATH . '/toolblox/';


/* destination folder for new blox */
$config['buildablox']['output_path'] = APPPATH . '/modules/';

/* Form actions to appear in the "Controller Types" list */
$config['buildablox']['controller_types'] = array(
    'Front'  => 'Public',
    'Auth' => 'Authenticated',
    'Admin'   => 'Admin',
);

/* Form actions to appear in the "Controller Actions" list */
$config['buildablox']['form_action_options'] = array(
    'index'  => 'List',
    'create' => 'Create',
    'edit'   => 'Edit',
    'delete' => 'Delete',
    'listing'  => 'List Ajax'
);

/* "Validation Rules" in each field's details/options */
$config['buildablox']['validation_rules'] = array(
    'required',
    'unique',
    'trim',
);

/* "Input Limitations" in each field's details/options */
$config['buildablox']['validation_limits'] = array(
    'alpha',                'numeric',           'alpha_numeric',
    'alpha_dash',           'alpha_numeric_spaces',  'decimal',     
    'integer',              'is_natural',           'is_natural_no_zero',
    'valid_base64',         'valid_email',          'valid_emails',
    'valid_ip',             'valid_url',   
    'none_of_the_above',
);

/* Default primary key field */
$config['buildablox']['primary_key_field'] = 'id';

/* Default form error delimiters */
$config['buildablox']['form_error_delimiters'] = array(
    '<span class="error">', '</span>'
);

/* Default languages */
$config['buildablox']['languages_available'] = array(
    'english',
    'french',
    'italian',
    'russian',
    'spanish_am'
);

/* MySQL database types */
$config['buildablox']['database_types'] = array(
    'BIGINT'        => array('numeric', 'integer'),
    'BINARY'        => array('binary'),
    'BIT'           => array('numeric', 'integer', 'bit'),
    'BLOB'          => array('binary', 'object'),
    'BOOL'          => array('numeric', 'integer', 'boolean'),
    'BOOLEAN'       => array('numeric', 'integer', 'boolean'),
    'CHAR'          => array('string'),
    'DATE'          => array('date'),
    'DATETIME'      => array('date', 'time'),
    'DEC'           => array('numeric', 'real'),
    'DECIMAL'       => array('numeric', 'real'),
    'DOUBLE'        => array('numeric', 'real'),
    'ENUM'          => array('string', 'list'),
    'FLOAT'         => array('numeric', 'real'),
    'INT'           => array('numeric', 'integer'),
    'INTEGER'       => array('numeric', 'integer'),
    'LONGBLOB'      => array('binary', 'object'),
    'LONGTEXT'      => array('string', 'object'),
    'MEDIUMBLOB'    => array('binary', 'object'),
    'MEDIUMINT'     => array('numeric', 'integer'),
    'MEDIUMTEXT'    => array('string', 'object'),
    'NUMERIC'       => array('numeric', 'real'),
    'REAL'          => array('numeric', 'real'),
    'SET'           => array('string', 'list'),
    'SMALLINT'      => array('numeric', 'integer'),
    'TIME'          => array('time'),
    'TIMESTAMP'     => array('date', 'time'),
    'TINYBLOB'      => array('binary', 'object'),
    'TINYINT'       => array('numeric', 'integer'),
    'TINYTEXT'      => array('string', 'object'),
    'TEXT'          => array('string', 'object'),
    'VARBINARY'     => array('binary'),
    'VARCHAR'       => array('string'),
    'YEAR'          => array('year', 'integer'),
);