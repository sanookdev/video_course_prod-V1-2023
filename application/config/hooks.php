<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$hook['pre_controller'] = array(
    'function' => 'MyTrimer',
    'filename' => 'utilities.php',
    'filepath' => 'hooks'
    );
   
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
