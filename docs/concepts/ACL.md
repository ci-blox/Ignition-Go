## Securinator ACL - Users, Roles and Permissions

The ACL mechanism named Securinator in Ignition Go utilizes a Role-Based Access Control (RBAC) system for authorization. This simple mechanism provides enough granularity and flexibility for most situations.

*   [Roles](#roles)
*   [Role Permissions](#permissions)
*   [Access Control](#access)

[]( )

## Roles

A user id is assigned to a role and the role is tied to permissions. Two roles are required in the core system. They are Administrator and User. Two additional roles are provided: Support (intended to be a subset of administrator) and Manager. Here is a suggested role setup:

### User

This is the default role that anyone registering to the site is given. As such, it will typically have very limited rights to most of the site.

### Administrator

The Administrator is the highest level user of the site. This is often the client that you are creating the site for. This is the 'owner' of the site and, as such, is typically given the most power of the site operators. By default, this role usually gets tied to permissions over the entire site.

### Support

The Support role typically has near-Adminstrator capability, but there are still some sensitive areas that the Administrator might not want them to have access to.

### Manager

This role is intended to have more capability than a basic user.

The attributes of the role are:

*   **Role** - The internal alphanumeric id key of the role.
*   **Role Name** - The name of the role as you want it to appear to users. It should not have spaces or special characters, though you can use underscores in their place.
*   **Description** - can be used for a full description and/or comments if needed.
*   **Login Destination** - This is the relative path that a user is directed to when they login. For example, you can force all admins to be directed to the main admin page by setting this value to `/admin/dashboard`. Alternatively, you could have other roles be directed to their own dashboard or account management page by entering the appropriate relative URL here.
*   **Default** - The role assigned to new users when they register.
*   **Can Delete**Give the power to delete certain roles, while keeping some safe from accidental or malicious removal.
*   **Deleted** - Tag deleted role.

[]( )

## Permissions

Permissions are typically described in 3-part, human-readable formats that allow for nearly any type of permission to be created.

### Naming Permissions

Permissions are named based on three parts. Core permissions follow this format:

    App.action.permission
        e.g. Site.Signin.Allow

Modules use the following naming convention:

    module.controllertype.action
        e.g. App.Roles.View

*   **Module** is typically the name of your module, or a portion of it.
*   **Context** can be one of several things depending on your needs.
*   **Action** is a single action that can be checked. Common actions are View, Add, and Manage, but can be whatever you need. Common actions are Manage, View, Edit, Delete.

[]( )

### Permissions

Permissions can easily be created.

Each permission has the following three attributes:

*   **Name** is the permission itself, following the naming scheme outlined above.
*   **Description** is a short string describing the permission and it’s use. This is only used for display in the Permissions overview page.
*   **Status** allows permissions to still be available in the system, but not to actually be used. This can be used as a placeholder for in-development features.

[]( )

### Assigning Permissions

Permissions can be assigned to roles through the `Edit Role` screen. Alternatively, they can be assigned to all roles at once by viewing the `Permission Matrix`, available from both the Roles and Permissions screen.

## Restricting Access

The `Auth` library provides several useful methods to restrict access, or check access, from any place in your application. If not already loaded, you can load the Auth library with the following code:

    $this->load->library('users/auth');

[]( )

### `restrict()`

The `restrict()` method can be used to protect an entire method or even class. If used without any parameters, it will simply verify that the user is logged in. If they are not, it will redirect them to the login page.

    $this->auth->restrict();

You can require that a user has a certain Permission granted by passing the name of the permission as the first parameter. You do not have to match the case of the original permission string, as it will be converted to lowercase prior to checking.

    $this->auth->restrict('App.Users.Manage');

If a user does not have the required permission granted to them, they will be directed to their previous page. You can change the URI they are redirected to by passing it in as the second parameter. This can be either a relative or full URI path.

    $this->auth->restrict('App.Users.Manage', '/get-outtat-here.html');

### `has_permission()`

The `has_permission()` method allows you to check if the current logged-in user has a specified permission. You pass the name of the permission to check in as the first parameter.

    if ( ! has_permission('App.Users.Manage'))
        {
            . . .
        }



### `permission_exists()`

This function allows you to quickly check whether a permission exists in the databse or not. Simply pass in the permission name to check as the first parameter.

    if (permission_exists('App.Users.Manage'))
        {
            . . .
        }
