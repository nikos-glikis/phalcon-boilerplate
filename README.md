Phalcon Boilerplate 
-------------------

Two of the best things that happened to php is, PhalconPHP and Symfony.

PhalconPHP a full-stack PHP framework delivered as a C-extension. That means incredible performance for you project.

On the other side Symfomy 3.0. is probably a lot slower, but better engineered framework with a lot more features. It is developed as a set of 30 components that anyone can use separatelly on their projects.

Where Symfony lacks:

- Performance.
	- There is an overhead or 30ms to load start loading your code in Symfony for the simplest request.
	- The same time for Phalcon is 3ms.

Where Phalcon lacks:

- Lack for support for multiple environments.
- Default structure like Symfony - Testing/Commands must be created by the developer.
- Orm is simpler (and faster at the same time)
- Migrations in environments.
- No support for PHPStorm. There is some support for autocomplete, but nothing like Symfonys PHPStorm plugin.

Its good to have options. A dev must be flexiple depending on the job at hand.

I have found that PhalconPHP is flexiple but it doesn't enforce specific architectures. It has the nessary tools for you to glue together your project. 

This is my attempt to making Phalcon Framework more Symfony-Like, the way I prefer my environment to be setup on each project, without comprimising performance. The goal is to create a template framework to start working with so that I don't research the same issues each time I start a new project.

What I have added:

- Setup tests for API and CLI.
- Support multiple environments for HTTP and CLI, with inheritance.
- Tweeked the settings for migrations so that it supports multiple environments.
	- Runned migrations are saved in databases.
	- Migrations settings added to the default config.php so that migration files are created with timestamps instead of versions. 
- Wrapper commands for multiple tasks that enable the use of environments
	- ./build.sh prod/test
	- ./migration_create.sh prod/test
	- ./migration_run.sh prod/test
	- ./run_tests.sh
		- Runs php build in web server
		- Runs tests
		- Shuts down php server.
	- ./server script (Runs php build in sever usefull for dev and tests)
		- ./start.sh
		- ./stop.sh
- Included the cli support suggested by the docs but not included in the projects.
- Config example.
- Compatible Docker file.
	- ./build_docker.sh
	- ./run_docker.sh
		- Your app is running on port 81 with 
			- apache
			- phalcon 
			- php 7
			- pdo_mysql
			- composer
			- mod_rewrite
			- Composer cache volune
- Edited .hrouter.php so that all requests work with the PHP build in server.


Resources:
-----------

Making sense with migrations:
    
    https://forum.phalconphp.com/discussion/14865/working-with-migrations
    
