<?php

/**
 * Some utility static methods
 *
 * 
 *
 * @package lib.model
 */ 
class Util
{
  /**
   * transform an array of any objects into an array of Primary Keys
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function transformIntoPKs($objects)
  {
    // creates a callback function able to invoke the object's getPrimaryKey method
    $getPK_callback = create_function('$e', 'return call_user_func(array($e, "getPrimaryKey"));');
    return array_map($getPK_callback, $objects);
  }
    
}