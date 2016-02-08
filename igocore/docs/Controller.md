## Controller

## Overview

This section covers use of controller classes within your application.  Codeigniter includes the CI_Controller, but the below controller classes provide more flexibility.

Each controller type is meant to serve a specific purpose, and they are all easily adaptable to fit your needs.  Important Note: be sure to capitalize the first letter of your controller, or otherwise CI will not find them.

### Base_Controller

All of the custom controllers extend from the `Base_Controller`. This class extends the MX_Controller from [WireDesign’s HMVC](https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home).

This controller is the place that you want to setup anything that should happen for every page, like:

*   Setup environment-specific settings, like turning the profiler on for development and off for production and testing.
*   Get the cache setup correctly. This is currently setup to only use a file-based cache, but you can easily tell it to use APC if available, and fallback to the file system if not.
*   This controller also sets up certain events that will get executed just before and just after the Base_Controller’s constructor runs.

Some of the things that would normally be auto-loaded are handled here so that any AJAX controllers you may write don't need to process any of these other settings.

By default, the Base_Controller class provides the following features for any of your classes that extend it:

*   `$previous_page` and `$requested_page` class vars that help you know where you came from. These are auto-populated for you.
*   `$current_user` class var that, if logged in, will contain all of the information from the users table. This same information is automatically made available to the view files that are rendered with the Template class.
*   Loads the cache drivers. For development environments, we simply harness the 'dummy' driver which always returns FALSE. Production and test environments default to APC caching with a file-based backup, if that's not available.
*   Gets the `activity model` loaded and ready.
*   Loads the `application language` file.

[]( )

### Front_Controller

The `Front_Controller` is intended to be used as the base for any public-facing controllers. As such, anything that needs to be done for the front-end can be done here. The Template library is loaded.

### Api_Controller

This controller class is for use as a REST API server.

### Admin_Controller

This controller class is for use within the Admin area.

### Additional Resources

*   [What is a Controller?](#what-is-a-controller)
*   [Methods](#methods)
*   [Passing URI Segments to your methods](#passing-uri-segments-to-your-methods)
*   [Remapping Method Calls](#remapping-method-calls)
*   [Processing Output](#processing-output)
*   [Class Constructors](#class-constructors)
*   [Reserved method names](#reserved-method-names)