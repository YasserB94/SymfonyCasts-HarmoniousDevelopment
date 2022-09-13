# Harmonious Development With Symfony 6
This repository contains my road trough the [symfonycasts' Harmonious Development with Symfony 6](https://symfonycasts.com/screencast/symfony) course.

## Hello Symfony
- The secret sauce of symfony
    - It starts tiny
    - It uses a unique recipe system to scale into huge applications
    - It's fast
- The Symfony Binary
    - This cli is optional
        - But not really....
- What can the CLI do ?
    - Help us start symfony projects
    - Provides Symfony development tools

```zsh
# See everything the CLI can do by running
$ symfony list
```
- Creating a new Symfony App
    - `$ symfony new mixed_vinyl`
    - This command uses composer to create a new symfony project
- Version control
    - The CLI command automaticly initialises a git repository
    - It also automaticly commits all files
- Starting small
    - Run `$ git show --name-only` to show all files in the project
    - There are only 17 files to start in the project!
- Is my system ready to work with Symfony 6 ?
    - There is a handy command to check!
        - `$ symfony check:requirements`
- Running the project on a local server
    - `$ symfony serve -d`

- End of chapter Challenge notes
```
The symfony binary was created by the Symfony organization... but it's mostly just a command-line tool with helpful commands for things like (A) downloading a new Symfony project and (B) starting a handy development web server.
You could absolutely create & build a new Symfony project without the binary... but we like it!
```
```
Running symfony new is just a shortcut for running the composer create-project command.

If you want to get geeky about it, when you start a new Symfony app (using either method), the following happens behind the scenes:

    You clone the repository at https://github.com/symfony/skeleton
    You run composer install to download vendor libraries.

If you're still new to composer, don't worry. We're going to talk more about all of this soon.
```
***
## Meet our Tiny App
How do things work ? 
- The only directories we have to worry about
    - ./public
        - The document root
        - Any file that has to be publicly accessable has to live here!
            - Example: Images,Css,...
        - Now it contains index.php
            - `It's job is to launch make sure symfony gets started and shouldnt be changed`
        - Most of the time we do not touch this directory that much!
    - ./config
        - Holds all the configuration files
    - ./src
        - Holds all the php classes
        - This is where the backend developer lives!
- But where is Symfony ? 
    - the `composer.json` file contains all of the packages/libraries that build up symfony.
    - these libraries live in the ./vendor folder.
- What are the other directories ? 
    - ./var
        - holds things like caches and logs
    - ./bin
        - Makes the CLI work ? :p
- IDE setup
    - Instead of using my old trustworthy 'extension bombed' VScode, I will use PHPstorm as it's used in the course.
        - The only reason I am going to use PHPStorm is because apparently there is a nice plugin made just for Symfony on the Jetbrains marketplace, and I want to see if the plugin is worth the big price of Symfony
    - I will probably get back to vsCode very soon tough for a simple reason
        - In first place an IDE is a text editor, and vsCode just shines there!
        - IMO: The shortcuts for moving, copying lines, using multi cursors(much handy for css frameworks!) just make a lot more sense and are more accessible in vsCode....
            - 
***
## Routes, Controllers & Responses
- Web Framework
    - Every web framework has the job to help us create pages
    - Commonly these use Routes and Controllers!
        - Route
            - Defines the URL and points to a controller
        - Controller
            - A php function that builds the page.
In Symfony they are kind of built in reverse. We create a controller first, then the route to it

- The `src` folder can be organised however the developer wants. But there are TWO important rules to the structure.
    - Namespaces
        - Ex: `namespace App\Controller;`
        - The namespace of the class must match the directory structure starting with App
            - App points to the src directrory.
            - Without the namespace the app will not find the class!
    - File naming
        - The name of the file MUST match the classname in the file and vice versa!
- `HttpFoundation`
    - A Symfony library that gives access to: Response,Session,Request,...
        - Response can contain anythign we want to return to the client. JSON,Text, full on html,...
```
The only rule of a Symfony controller method (or "action") is that it must return a Symfony Response object. That's nice because, at the end of the day, our only job as developers is to return a response to the user! But ultimately, Symfony doesn't care if you render a template, generate some JSON or do something else in order to create the Response.

Oh, and fun fact: in reality, it's not an absolute rule that a controller must return a Response - there is a way around this. It's not important now (and maybe not ever), but it is possible!
```
***
## Wildcard Routes
```php
 //Instead of using this extra route the parameter in thecategory route is optional now
//    #[Route('/browse')]
//    public function browse(): Response
//    {
//        return new Response('Nothing to browse trough...... yet!');
//    }

    #[Route('/browse/{category}')]
    public function browseByCategory(string $category = null): Response
    {
        //Replacing any dashes with spaces
        //str_replace('-', ' ', $category);
        if ($category) {
            //u is a symfony library that helps with string transformations - in this case we uppercase any letters like in a title
            $title = u(str_replace('-', ' ', $category))->title(true);
            return new Response('Nothing to browse in the category: ' . $title
            );
        }
        //This could also just return all categories! Which might make more sense
        return new Response('Nothing to browse trough...... yet!');
    }
}
```
```php
Each route {wildcard} is matched to the controller arguments by name not position. And, adding the argument is optional. Check out this example:

#[Route("/articles/{category}/{page}/{highlight}")]
public function article($page, $category): Response
{
}

That is totally allowed! Even though {category} appears before {page} in the route, you can order the argument names however you want. And even though {highlight} is in the route, you do not need to have an argument for that
```

## Symfony Flex: Aliases, Packs and Recipes
Symfony flex extends `composer` with aliases that easely let's us install symfony packages.
Symfony packs(packages) is like a bundle of libraries needed for one feature
Recipes is behaviour executed by flex that allows packs to update,create files. for example in this case a couple files were changed:
```js
On branch main
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
	modified:   .gitignore
	modified:   composer.json
	modified:   composer.lock
	modified:   config/bundles.php
	modified:   src/Controller/VinylController.php
	modified:   symfony.lock

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	config/packages/twig.yaml
	templates/

no changes added to commit (use "git add" and/or "git commit -a")
```
Running `composer recipes` shows available recipes, adding the name of a bundle as a paramter will return more information about that specific recipe.
***
## Twig
- Controllers do not have to inherit anythign!
    - !BUT! you probably want to extend from `AbstractController`
        - This abstract controller provides shortcuts, like the `render` method to render twig templates
- `Render()`
    - The render method takes up to three parameters
        - What to render
        - With what paramaters
        - Another response ? 
- `Convention`
    - It's common use to have a folder within templates for every controller
    - And to name templates after the function that renders it and vice versa
- **Twig Syntax**
    - Say something
        - `{{ thisIsAVariableFromParameters }}`
        - `{{ 'I am a string' }}`
        - This syntax just prints out whats in there
    - Comment somethign
        - `{{# This is a comment! #}}`
    - Do Something
        - `{% WhatShouldIDo? %}`
        - Example for For:
            - `{% for instrument in symfony %} <p>Hello {{ instrument }}!{% endfor %}`
        - In loops associative array's values can be accessed with a dot.
            - `['language' => 'HTML','usecase'=>'Markup']`
                - `{{ var.language }} is used for {{ var.usecase }}`
```
Remember: a Symfony controller must always return a Response object. So, even without looking, we can assume that $this->render() must also do that. And... it does! It renders the template and puts the string into a Response object for convenience.

OK... Technically a controller does not NEED to return a Response... but let's save that fun fact for later (it's not very important anyway!).
```
```
To iterate over an array in Twig, you need to use the {% for comment in comments %} syntax.

The index, part of {% for index, comment in comments %} is optional: you only need that if you also need access to the index.
```
***
## Twig Inheritance
- [Twig Documentation](twig.symfony.com)
- There are a lot of twig 'Tags' like
    - `for`
    - `if`
    - `do`
    - ....
- there are also twig 'Filters' that alter what is displayed like
    - `date`
    - `capitalize`
    - `filter`
    - ...
- Last but not least there are twig 'Functions' like
    - `min`
    - `max`
    - `range`
    - Tough Twig prefers using filters!
- Filters
    - Filters work like in the command line
        - We pipe what we want to transform into the filter
        - Example the name variable's value is uppercased then displayed:
            - `{{ name | uppercase }}`
- **Template Inheritance**
    - A layout system
    - We use the 'do something' tag called `extends`
    - Twig uses `blocks`
    - When we extend a template, we extend it with a `block`, when the tempalte is rendered the content in the child's `block` is rendered in the assigned `block` in the parent!
- Adding to a block
    - We can also make a child add content instead of replacing the whole block!
```twig
{# The parent function will render the content of the parent's block #}
{% block title %}My First Symfony page @ {{ parent() }}{% endblock %}
```
- Tip: When using Twig inheritance, think of Object Oriented Inheritance!
```
As soon as you extend another template, you must surround all of your content in one or more blocks. Otherwise, Twig yells:

    Hey! I have no idea where inside of base.html.twig to put this <h1> tag!?

We tell Twig where to put it by placing all content inside of a block.

```
```
remember that template inheritance is a lot like object-oriented inheritance. Declaring a block that your parent template never uses is like creating a sub-class of another class... and adding a new method that... nobody ever calls! Your new method doesn't cause any errors, but it's utterly useless.
```
***
## Debugging
- We can easily add all the debugging tools we need just by running
    - `$ composer require debug`
- What does it install ? 
```js
On branch main
Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git restore <file>..." to discard changes in working directory)
	modified:   composer.json
	modified:   composer.lock
	modified:   config/bundles.php
	modified:   symfony.lock

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	config/packages/debug.yaml
	config/packages/monolog.yaml
	config/packages/web_profiler.yaml
	config/routes/web_profiler.yaml

no changes added to commit (use "git add" and/or "git commit -a")
```
- A nice little toolbar containing a lot of handy info!
    - You can click any of the icons in this toolbar to get an extended profile!
- Within our controller we can talk o the debugging tool!
    - ```dd($variable)``` allows us to dump out a variable in a much more readable version of a variable (stands for dump and die!)
    - In php at least one parameter is required
    - In Twig
        - ```{{ dump() }}``` Dumps all variables accesible in the template! 
```
Calling dump() without arguments will print all the available variables only when you call it from inside of a Twig template! If you call this function in a PHP file, it will throw an error:

    Too few arguments to function dump(), 0 passed and exactly 1 expected
```
***
