<?php
if (class_exists('OH_Opening_Hours\OH_Opening_Hours')) {
  $GLOBALS['op'] = OH_Opening_Hours\OH_Opening_Hours::getInstance();
  register_activation_hook(__FILE__, array($GLOBALS['op'], 'activate'));
  register_deactivation_hook(__FILE__, array($GLOBALS['op'], 'deactivate'));
  require_once __DIR__ . '/functions.php';
}
