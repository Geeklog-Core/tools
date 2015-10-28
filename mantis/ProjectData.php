<?php
/**
 * 
 * 
 * @package
 * @copyright
 */
class ProjectData {
  /* integer */
  public $id;
  /* string */
  public $name;
  /* ObjectRef */
  public $status;
  /* boolean */
  public $enabled;
  /* ObjectRef */
  public $view_state;
  /* ObjectRef */
  public $access_min;
  /* string */
  public $file_path;
  /* string */
  public $description;
  /* ProjectDataArray */
  public $subprojects;
  /* boolean */
  public $inherit_global;
}

?>
