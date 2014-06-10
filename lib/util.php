<?php
class Utils
{
  public  function checkGetKey($key,$default='')
  { return (array_key_exists($key,$_GET)&&($_GET[$key]!=''))?$_GET[$key]:$default;
  }
}
?>
