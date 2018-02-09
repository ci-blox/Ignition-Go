# Module Blox Builder

Module Blox Builder is available in the Admin section and requires some knowledge of database table design, column types and form layout. It is intended to create some skeleton code for you that you can then continue working with. It cannot modify existing files and will overwrite files if you try.

## Building a Module Blox

The builder generates the code for a module based on the inputs to a few form fields and can build a DB based module or a module without DB access. The builder can create a DB table for you or you can use an existing db table to create the module.

To create a new module which does not require DB access requires you to fill out one form field (the module name field) and pressing the "Build" button.

This will generate a module in the _application/modules_ folder with config, controllers, language, migrations (for permissions) and view files. Amazing for one form field and a button click.

Of course that's just the basic module. To get more you have to give more!

If you want to use a DB table then you need to fill out more fields. You can choose to build a new DB table or choose an existing table.

<a name="new-db-table"></a>

### With a new database table

You must choose the number of fields you would like in the table, excluding the primary key field which is automatically included.

Then for every field you fill in the form Label, table field name, form input element, table field type, table field length and the form validation settings you would like.

The primary key is assumed to be "id" but this is editable before (and of course after) the form is submitted.

Once the field details have been entered then just click the "Build" button.

Hey presto! Now you have a brand new shiny module with all files mentioned above as well as a new model file and a migration file to create the table in the database. The migration file is even run automatically so you can use the module straight away.

### With an existing database table

You must choose the name of the table which you would like to use to build your module.

The table name must include the prefix used for your site which is "igo_" by default. If your table does not have this prefix then please rename it to include the prefix. Now click on the "Build" button.

This reads the structure of the database table and picks out the field characteristics including the primary field.

The page returned includes settings for each of the fields and sets up the field label for you.

For every field you can change this data but it is advisable to only change the Label and Validation settings as anything else may cause errors.

When you are finished editing the fields just click the "Build" button again.

Now you have a new module based on your previous database table with all files mentioned above as well as a new model file. The migration file is not created in this case as the table already exists but there is a migration file for the permission settings which is processed automatically so you can use the module straight away.

## Module Builder Options

There are lots of options which you can use when building your module. These options are hidden by default but to see them you just click on the "Toggle Advanced Options" links.

Clicking on the link will display the options below the link. Then for every field you fill in the form Label, table field name, form input element, table field type, table field length and the form validation settings you would like.

There are two sets of options, Module Options and Table Options which we will describe below.

<a name="module-options"></a>

### Module Options

The Module Options allow you to customize the module functionality. The options are:

*   **Module Description** - The module description is placed in the module config file and appears on the module list in the main Module Builder page.
*   **Controllers Required** - Lists the available contexts (controller names), you choose which to create for your module. All contexts are selected by default.
*   **Controller Actions** - Lists the CRUD actions which the builder can create for you. All actions are selected by default.

<a name="table-options"></a>

### Table Options

The Table Options are related to the DB table if you chose to build the module with DB access. The options are:

*   **Table Name** - This is the name given to the table in the database. This is defaulted to the lowercase and underscored version of the module name.
*   **Form Error Delimiters**
*   **Use "Soft" Deletes** - Default value: FALSE
*   **Use "Created" Field** - Default value: FALSE
*   **"Created_on" Field Name_** _- Default value: 'created_on'
*   **Use "Modified" Field** - Default value: FALSE
*   **"Modified" Field Name** - Default value: 'modified_on'
*   **Primary Key** - Default value: 'id'

<a name="known-issues"></a>

## Known Issues

The Module Builder is a great way to get started but there are a couple of issues which you should be aware of:

*   This module is undergoing changes.
*   Error messaging is not the best when something goes wrong.
*   Building from existing tables shows some fields in the form which are not applicable.

<a name="addl-resources"></a>

## Additional Resources

Q. What are modules, why should I use them?

A. ([http://en.wikipedia.org/wiki/Module](http://en.wikipedia.org/wiki/Module))

([http://en.wikipedia.org/wiki/Modular_programming](http://en.wikipedia.org/wiki/Modular_programming))

([http://blog.fedecarg.com/2008/06/28/a-modular-approach-to-web-development](http://blog.fedecarg.com/2008/06/28/a-modular-approach-to-web-development))

Q. What is Modular HMVC, why should I use it?

A. Modular HMVC = Hierarchy of multiple MVC triads

This is most useful when you need to load a view and its data within a view. Think about adding a shopping cart to a page. The shopping cart needs its own controller which may call a model to get cart data. Then the controller needs to load the data into a view. So instead of the main controller handling the page and the shopping cart, the shopping cart MVC can be loaded directly in the page. The main controller doesn’t need to know about it, and is totally isolated from it.

In CI we can’t call more than 1 controller per request. Therefore, to achieve HMVC, we have to simulate controllers. It can be done with libraries, or with this “Modular Extensions HMVC” contribution.

The differences between using a library and a “Modular HMVC” HMVC class is: 1\. No need to get and use the CI instance within an HMVC class 2\. HMVC classes are stored in a modules directory as opposed to the libraries directory.

Q. Is Modular Extensions HMVC the same as Modular Separation?

A. Yes and No. Like Modular Separation, Modular Extensions makes modules “portable” to other installations. For example, if you make a nice self-contained model-controller-view set of files you can bring that MVC into another project by copying just one folder - everything is in one place instead of spread around model, view and controller folders.

Modular HMVC means modular MVC triads. Modular Separation and Modular Extensions allows related controllers, models, libraries, views, etc. to be grouped together in module directories and used like a mini application. But, Modular Extensions goes one step further and allows those modules to "talk" to each other. You can get controller output without having to go out through the http interface again.