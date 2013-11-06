<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['project_title'] = 'Marker CMS';
$config['project_copyright'] = 'Marker CMS - <a target="_blank" href="http://ahmadmoussawi.com/">Ahmad Moussawi</a> &copy ' . date('Y');
$config['ga_code'] = '';

$config['private_table_prefix'] = '';

/**
 * Membership settings
 */
$config['marker_tables'] = array(
    'members' => $config['private_table_prefix'] . 'members',
    'membersinroles' => $config['private_table_prefix'] . 'membersinroles',
    'roles' => $config['private_table_prefix'] . 'roles',
    'lists' => $config['private_table_prefix'] . 'lists',
    'fields' => $config['private_table_prefix'] . 'fields',
    'fields_types' => $config['private_table_prefix'] . 'fields_types',
    'pages' => $config['private_table_prefix'] . 'pages',
    'sessions' => $config['private_table_prefix'] . 'sessions',
);