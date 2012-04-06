<?php
/**
 * 
 * 
 * @package
 * @copyright
 */
class IssueData {
  /* integer */
  public $id;
  /* ObjectRef */
  public $view_state;
  /* dateTime */
  public $last_updated;
  /* ObjectRef */
  public $project;
  /* string */
  public $category;
  /* ObjectRef */
  public $priority;
  /* ObjectRef */
  public $severity;
  /* ObjectRef */
  public $status;
  /* AccountData */
  public $reporter;
  /* string */
  public $summary;
  /* string */
  public $version;
  /* string */
  public $build;
  /* string */
  public $platform;
  /* string */
  public $os;
  /* string */
  public $os_build;
  /* ObjectRef */
  public $reproducibility;
  /* dateTime */
  public $date_submitted;
  /* integer */
  public $sponsorship_total;
  /* AccountData */
  public $handler;
  /* ObjectRef */
  public $projection;
  /* ObjectRef */
  public $eta;
  /* ObjectRef */
  public $resolution;
  /* string */
  public $fixed_in_version;
  /* string */
  public $target_version;
  /* string */
  public $description;
  /* string */
  public $steps_to_reproduce;
  /* string */
  public $additional_information;
  /* AttachmentDataArray */
  public $attachments;
  /* RelationshipDataArray */
  public $relationships;
  /* IssueNoteDataArray */
  public $notes;
  /* CustomFieldValueForIssueDataArray */
  public $custom_fields;
  /* dateTime */
  public $due_date;
  /* AccountDataArray */
  public $monitors;
  /* boolean */
  public $sticky;
  /* ObjectRefArray */
  public $tags;
}

?>
