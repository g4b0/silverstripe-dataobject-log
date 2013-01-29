<?php

class LogAdmin extends ModelAdmin {
  public static $managed_models = array('Log'); // Can manage multiple models
  static $url_segment = 'logs'; // Linked as /admin/products/
  static $menu_title = 'Logs Admin';
}
