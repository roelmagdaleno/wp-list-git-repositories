<?php

/**
 * Plugin Name: GitHub Repositories
 * Plugin URI:  https://github.com/roelmagdaleno/wp-list-github-repositories
 * Description: WordPress plugin listing your GitHub public repositories.
 * Version:     0.1.0
 * Author:      Roel Magdaleno
 * Author URI:  https://roelmagdaleno.com
 */

use Roel\WP\GitHubRepositories\Repositories;

require 'vendor/autoload.php';

$repositories = new Repositories();
$repositories->hooks();
