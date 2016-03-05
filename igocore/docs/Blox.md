# Blox 

## Overview

Blox can be standalone modules or more complex plugins, which can interact while Ignition Go is running, much like Wordpress plugins. 
There are two types of hooks that Blox can use to interact on pages, actions and filters. Actions are generally events or operations in controllers and models.  Filters generally interact in view elements, for example a button click.

**Topics**

*   [Blox Metadata](#bloxmeta)

*   [Blox Hooks - Actions and Filters](#bloxhooks)


## Blox Metadata

Blox metadata is stored in config.php in the module config subfolder.

### Required

name     Name of the Blox
version  Version
uri      where the Blox source is 

### Optional

TODO

### Example

$config['module_config'] = array(
    'name'        => 'A Blox',
    'version'     => '0.9.0',
    'uri'      => 'http://ciblox.com/blox/example',
    'author'      => 'IGO Team',
    'authoruri'      => 'http://mysite.com',
    'description' => 'Does something good.'
    )
);

## Blox Hooks - Actions and Filters

Many Ignition Go Blox will accomplish their goals by connecting to one or more Ignition Go "hooks". The way hooks work is that at various times while Ignition Go is running, Ignition Go checks to see if any Blox have registered functions to run at that time, and if so, the functions are run. These functions can modify the default behavior.

For instance, Ignition Go has an "action" hook called "footer_set". Just before the end of the  page generating, it checks to see whether any Blox have registered functions for the "footer_set" action hook, and runs them in turn.

You can learn more about how to register functions for both filter and action hooks, and what  hooks are available, in the other Blox documents. If you find a spot in the Ignition Go code where you'd like to have an action or filter, but Ignition Go doesn't have one, you can also suggest new hooks (suggestions will generally be taken).



