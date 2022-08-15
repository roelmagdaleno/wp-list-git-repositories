<?php

/**
 * Plugin Name: Git Repositories
 * Plugin URI:  https://github.com/roelmagdaleno/wp-list-github-repositories
 * Description: WordPress plugin listing your git public repositories.
 * Version:     0.1.0
 * Author:      Roel Magdaleno
 * Author URI:  https://roelmagdaleno.com
 */

use Roel\WP\GitRepos\Repositories;

require 'vendor/autoload.php';

$repositories = new Repositories();
$repositories->hooks();
