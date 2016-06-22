# Blox Hook Methods for Actions and Filters

## Overview

There are two types of hooks that Blox can use to interact on pages, actions and filters.  There are methods used that implement the actions and filters.  
These methods are the same methods found in Wordpress.
This section covers the hooks methods for carrying out actions and filters.

**Topics**

*   [Hooks Methods List](#hooksmethodlist)

Methods
=======
**ACTIONS:**

**add_action** Hooks a function on to a specific action.

     - @access public
     - @since 0.1
     - @param string $tag The name of the action to which the $function_to_add is hooked.
     - @param callback $function_to_add The name of the function you wish to be called.
     - @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     - @param int $accepted_args optional. The number of arguments the function accept (default 1).

**do_action** Execute functions hooked on a specific action hook.

     - @access public
     - @since 0.1
     - @param string $tag The name of the action to be executed.
     - @param mixed $arg,... Optional additional arguments which are passed on to the functions hooked to the action.
     - @return null Will return null if $tag does not exist

**remove_action** Removes a function from a specified action hook.


     - @access public
     - @since 0.1
     - @param string $tag The action hook to which the function to be removed is hooked.
     - @param callback $function_to_remove The name of the function which should be removed.
     - @param int $priority optional The priority of the function (default: 10).
     - @return boolean Whether the function is removed.

**has_action** Check if any action has been registered for a hook.

     -  @access public
     -  @since 0.1
     -  @param string $tag The name of the action hook.
     -  @param callback $function_to_check optional.
     -  @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
      When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
      When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false (e.g.) 0, so use the === operator for testing the return value.


**did_action**  Retrieve the number of times an action is fired.

     -  @access public
     -  @since 0.1
     -  @param string $tag The name of the action hook.
     -  @return int The number of times action hook <tt>$tag</tt> is fired

**FILTERS:**

**add_filter** Hooks a function or method to a specific filter action.

     - @access public
     -  @since 0.1
     -  @param string $tag The name of the filter to hook the $function_to_add to.
     -  @param callback $function_to_add The name of the function to be called when the filter is applied.
     -  @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     -  @param int $accepted_args optional. The number of arguments the function accept (default 1).
     -  @return boolean true

**remove_filter** Removes a function from a specified filter hook.

     -  @access public
     -  @since 0.1
     -  @param string $tag The filter hook to which the function to be removed is hooked.
     -  @param callback $function_to_remove The name of the function which should be removed.
     -  @param int $priority optional. The priority of the function (default: 10).
     -  @param int $accepted_args optional. The number of arguments the function accepts (default: 1).
     -  @return boolean Whether the function existed before it was removed.


**has_filter** Check if any filter has been registered for a hook.

     -   @access public
     -   @since 0.1
     -   @param string $tag The name of the filter hook.
     -   @param callback $function_to_check optional.
     -   @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
       When checking a specific function, the priority of that hook is  returned, or false if the function is not attached.
       When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false (e.g.) 0, so use the === operator for testing the return value.

**apply_filters** Call the functions added to a filter hook.

     -  @access public
     -  @since 0.1
     -  @param string $tag The name of the filter hook.
     -  @param mixed $value The value on which the filters hooked to <tt>$tag</tt> are applied on.
     -  @param mixed $var,... Additional variables passed to the functions hooked to <tt>$tag</tt>.
     -  @return mixed The filtered value after all hooked functions are applied to it.

