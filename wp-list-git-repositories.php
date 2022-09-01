<?php

/**
 * Plugin Name: Git Repositories
 * Plugin URI:  https://github.com/roelmagdaleno/wp-list-github-repositories
 * Description: List your public Bitbucket, GitHub or Gitlab repositories.
 * Version:     0.1.0
 * Author:      Roel Magdaleno
 * Author URI:  https://roelmagdaleno.com
 */

use Roel\WP\GitRepos\Repositories;

require 'vendor/autoload.php';
require 'includes/constants.php';
require 'includes/helpers.php';

( new Repositories() )->hooks();
