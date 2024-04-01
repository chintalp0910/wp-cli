<h1 align="center">WP CLI Plugin</h1>

Create WP CLI custom below command 

# WP CLI custom command.

1. Simple cli command.
```bash
wp sample
```
Output: Thank you for running the sample command.

2. Display Arguments cli command.
```bash
wp display_arguments
wp display_arguments John Doe 'Jane Doe' 32 --title='Moby Dick' --author='Herman Melville' --published=1851 --publish --no-archive
```
Arguments are as per below. As we set default value as per above, if we run wp display_arguments command, we get the same output.

First four arguments display in four lines 
Associated Arguments like title, author and published 
Associated Arguments as flag like publish - Default true  and no-archive - Default false

Output: 
John
Doe
Jane Doe
32
Moby Dick
Herman Melville
1851
1


3. Display Messages cli command.
```bash
Run command wp display_messages.
Run command wp display_messages --debug.
Run command wp display_messages --error.
```

Display diffent style output lines
Associated Arguments debug when passed display with WP_CLI::debug lines display.
Associated Arguments error when passed display with WP_CLI::error lines display.

Output: 
Standard line return.
Standard line returned that wont be silenced.
Blue text
Magenta text
Underline text
Success: Post updated!
Warning: No match was found.
    Error found!      
	Post not updated! 
	User not updated!
For secound command add like below line and other debug lines.
Debug: Breakpoint comment. (0.199s)
For yhird command add like below line and other error lines.
Error: Error found!

4. Progress Bar cli command.
```bash
Run command wp generate_post_progress_bar 5 cli command
```

Argument pass 5 which we set dynamic based on display progress as per below.

Output: 
0
Generating Posts  20 % [========>                                  ] 0:00 / 0:001
2
3
4
Generating Posts  100% [===========================================] 0:00 / 0:00

5. generate posts cli command for perform any task using cli.
```bash
Run command wp generate_posts 5 Test 1 cli command
```

Above command 3 argument need to passed as per below.
first argument as number how many post generate
second argument as text which is title for above Test1,Test2,...,Test5 Post Create
thirf argument as number author-id generate post author assign. 

Output: 
Success: 5 posts generated!

# PHPCLI

WP-CLI is the command-line interface for WordPress. You can update plugins, configure multisite installations and much more, without using a web browser.

## Installation

Before installing WP-CLI, please make sure your environment meets the minimum requirements:

* UNIX-like environment (OS X, Linux, FreeBSD, Cygwin); limited support in Windows environment
* PHP 5.6 or later
* WordPress 3.7 or later. Versions older than the latest WordPress release may have degraded functionality

Once you’ve verified requirements, download the [wp-cli.phar](https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar) file using wget or curl:

```bash
$ curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
```

Next, check the Phar file to verify that it’s working:
```bash
$ wget https://phar.phpunit.de/phpunit-X.Y.phar
```
Next, check the Phar file to verify that it’s working:
```bash
php wp-cli.phar --info
```

To use WP-CLI from the command line by typing wp, make the file executable and move it to somewhere in your PATH. For example:
```bash
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
```
If WP-CLI was installed successfully, you should see something like this when you run wp --info:
```bash
$ wp --info
```