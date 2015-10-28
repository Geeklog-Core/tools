<?php
/**
 * MantisConnect class file
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */

/**
 * ObjectRef class
 */
require_once 'ObjectRef.php';
/**
 * AccountData class
 */
require_once 'AccountData.php';
/**
 * AttachmentData class
 */
require_once 'AttachmentData.php';
/**
 * ProjectAttachmentData class
 */
require_once 'ProjectAttachmentData.php';
/**
 * RelationshipData class
 */
require_once 'RelationshipData.php';
/**
 * IssueNoteData class
 */
require_once 'IssueNoteData.php';
/**
 * IssueData class
 */
require_once 'IssueData.php';
/**
 * IssueHeaderData class
 */
require_once 'IssueHeaderData.php';
/**
 * ProjectData class
 */
require_once 'ProjectData.php';
/**
 * ProjectVersionData class
 */
require_once 'ProjectVersionData.php';
/**
 * FilterData class
 */
require_once 'FilterData.php';
/**
 * CustomFieldDefinitionData class
 */
require_once 'CustomFieldDefinitionData.php';
/**
 * CustomFieldLinkForProjectData class
 */
require_once 'CustomFieldLinkForProjectData.php';
/**
 * CustomFieldValueForIssueData class
 */
require_once 'CustomFieldValueForIssueData.php';
/**
 * TagData class
 */
require_once 'TagData.php';
/**
 * TagDataSearchResult class
 */
require_once 'TagDataSearchResult.php';
/**
 * ProfileData class
 */
require_once 'ProfileData.php';
/**
 * ProfileDataSearchResult class
 */
require_once 'ProfileDataSearchResult.php';

/**
 * MantisConnect class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class MantisConnect extends SoapClient {

  public function MantisConnect($wsdl = "http://project.geeklog.net/tracking/api/soap/mantisconnect.php?wsdl", $options = array()) {
    parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param  
   * @return string
   */
  public function mc_version() {
    return $this->__call('mc_version', array(),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for statuses. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_status($username, $password) {
    return $this->__call('mc_enum_status', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for priorities. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_priorities($username, $password) {
    return $this->__call('mc_enum_priorities', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for severities. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_severities($username, $password) {
    return $this->__call('mc_enum_severities', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for reproducibilities. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_reproducibilities($username, $password) {
    return $this->__call('mc_enum_reproducibilities', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for projections. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_projections($username, $password) {
    return $this->__call('mc_enum_projections', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for ETAs. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_etas($username, $password) {
    return $this->__call('mc_enum_etas', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for resolutions. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_resolutions($username, $password) {
    return $this->__call('mc_enum_resolutions', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for access levels. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_access_levels($username, $password) {
    return $this->__call('mc_enum_access_levels', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for project statuses. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_project_status($username, $password) {
    return $this->__call('mc_enum_project_status', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for project view states. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_project_view_states($username, $password) {
    return $this->__call('mc_enum_project_view_states', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for view states. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_view_states($username, $password) {
    return $this->__call('mc_enum_view_states', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for custom field types. 
   *
   * @param string $username
   * @param string $password
   * @return ObjectRefArray
   */
  public function mc_enum_custom_field_types($username, $password) {
    return $this->__call('mc_enum_custom_field_types', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the enumeration for the specified enumeration type. 
   *
   * @param string $username
   * @param string $password
   * @param string $enumeration
   * @return string
   */
  public function mc_enum_get($username, $password, $enumeration) {
    return $this->__call('mc_enum_get', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($enumeration, 'enumeration')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Check there exists an issue with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @return boolean
   */
  public function mc_issue_exists($username, $password, integer $issue_id) {
    return $this->__call('mc_issue_exists', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the issue with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @return IssueData
   */
  public function mc_issue_get($username, $password, $issue_id) {
    return $this->__call('mc_issue_get', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the latest submitted issue in the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return integer
   */
  public function mc_issue_get_biggest_id($username, $password, integer $project_id) {
    return $this->__call('mc_issue_get_biggest_id', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the id of the issue with the specified summary. 
   *
   * @param string $username
   * @param string $password
   * @param string $summary
   * @return integer
   */
  public function mc_issue_get_id_from_summary($username, $password, $summary) {
    return $this->__call('mc_issue_get_id_from_summary', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($summary, 'summary')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit the specified issue details. 
   *
   * @param string $username
   * @param string $password
   * @param IssueData $issue
   * @return integer
   */
  public function mc_issue_add($username, $password, IssueData $issue) {
    return $this->__call('mc_issue_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue, 'issue')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Update Issue method. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issueId
   * @param IssueData $issue
   * @return boolean
   */
  public function mc_issue_update($username, $password, integer $issueId, IssueData $issue) {
    return $this->__call('mc_issue_update', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issueId, 'issueId'),
            new SoapParam($issue, 'issue')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Sets the tags for a specified issue. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param TagDataArray $tags
   * @return boolean
   */
  public function mc_issue_set_tags($username, $password, integer $issue_id, TagDataArray $tags) {
    return $this->__call('mc_issue_set_tags', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($tags, 'tags')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the issue with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @return boolean
   */
  public function mc_issue_delete($username, $password, integer $issue_id) {
    return $this->__call('mc_issue_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit a new note. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param IssueNoteData $note
   * @return integer
   */
  public function mc_issue_note_add($username, $password, integer $issue_id, IssueNoteData $note) {
    return $this->__call('mc_issue_note_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($note, 'note')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the note with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_note_id
   * @return boolean
   */
  public function mc_issue_note_delete($username, $password, integer $issue_note_id) {
    return $this->__call('mc_issue_note_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_note_id, 'issue_note_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Update a specific note of a specific issue. 
   *
   * @param string $username
   * @param string $password
   * @param IssueNoteData $note
   * @return boolean
   */
  public function mc_issue_note_update($username, $password, IssueNoteData $note) {
    return $this->__call('mc_issue_note_update', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($note, 'note')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit a new relationship. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param RelationshipData $relationship
   * @return integer
   */
  public function mc_issue_relationship_add($username, $password, integer $issue_id, RelationshipData $relationship) {
    return $this->__call('mc_issue_relationship_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($relationship, 'relationship')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the relationship for the specified issue. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param integer $relationship_id
   * @return boolean
   */
  public function mc_issue_relationship_delete($username, $password, integer $issue_id, integer $relationship_id) {
    return $this->__call('mc_issue_relationship_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($relationship_id, 'relationship_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit a new issue attachment. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param string $name
   * @param string $file_type
   * @param base64Binary $content
   * @return integer
   */
  public function mc_issue_attachment_add($username, $password, integer $issue_id, $name, $file_type, $content) {
    return $this->__call('mc_issue_attachment_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($name, 'name'),
            new SoapParam($file_type, 'file_type'),
            new SoapParam($content, 'content')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the issue attachment with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_attachment_id
   * @return boolean
   */
  public function mc_issue_attachment_delete($username, $password, integer $issue_attachment_id) {
    return $this->__call('mc_issue_attachment_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_attachment_id, 'issue_attachment_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the data for the specified issue attachment. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_attachment_id
   * @return base64Binary
   */
  public function mc_issue_attachment_get($username, $password, integer $issue_attachment_id) {
    return $this->__call('mc_issue_attachment_get', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_attachment_id, 'issue_attachment_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Add a new project to the tracker (must have admin privileges) 
   *
   * @param string $username
   * @param string $password
   * @param ProjectData $project
   * @return integer
   */
  public function mc_project_add($username, $password, ProjectData $project) {
    return $this->__call('mc_project_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project, 'project')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Add a new project to the tracker (must have admin privileges) 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return boolean
   */
  public function mc_project_delete($username, $password, integer $project_id) {
    return $this->__call('mc_project_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Update a specific project to the tracker (must have admin privileges) 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param ProjectData $project
   * @return boolean
   */
  public function mc_project_update($username, $password, integer $project_id, ProjectData $project) {
    return $this->__call('mc_project_update', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($project, 'project')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the id of the project with the specified name. 
   *
   * @param string $username
   * @param string $password
   * @param string $project_name
   * @return integer
   */
  public function mc_project_get_id_from_name($username, $password, $project_name) {
    return $this->__call('mc_project_get_id_from_name', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_name, 'project_name')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the issues that match the specified project id and paging details. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param integer $page_number
   * @param integer $per_page
   * @return IssueDataArray
   */
  public function mc_project_get_issues($username, $password, $project_id, $page_number, $per_page) {
    return $this->__call('mc_project_get_issues', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the issue headers that match the specified project id and paging details. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param integer $page_number
   * @param integer $per_page
   * @return IssueHeaderDataArray
   */
  public function mc_project_get_issue_headers($username, $password, integer $project_id, integer $page_number, integer $per_page) {
    return $this->__call('mc_project_get_issue_headers', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get appropriate users assigned to a project by access level. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param integer $access
   * @return AccountDataArray
   */
  public function mc_project_get_users($username, $password, integer $project_id, integer $access) {
    return $this->__call('mc_project_get_users', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($access, 'access')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the list of projects that are accessible to the logged in user. 
   *
   * @param string $username
   * @param string $password
   * @return ProjectDataArray
   */
  public function mc_projects_get_user_accessible($username, $password) {
    return $this->__call('mc_projects_get_user_accessible', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the categories belonging to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return StringArray
   */
  public function mc_project_get_categories($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_categories', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Add a category of specific project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param string $p_category_name
   * @return integer
   */
  public function mc_project_add_category($username, $password, integer $project_id, $p_category_name) {
    return $this->__call('mc_project_add_category', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($p_category_name, 'p_category_name')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete a category of specific project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param string $p_category_name
   * @return integer
   */
  public function mc_project_delete_category($username, $password, integer $project_id, $p_category_name) {
    return $this->__call('mc_project_delete_category', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($p_category_name, 'p_category_name')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Rename a category of specific project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param string $p_category_name
   * @param string $p_category_name_new
   * @param integer $p_assigned_to
   * @return integer
   */
  public function mc_project_rename_category_by_name($username, $password, integer $project_id, $p_category_name, $p_category_name_new, integer $p_assigned_to) {
    return $this->__call('mc_project_rename_category_by_name', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($p_category_name, 'p_category_name'),
            new SoapParam($p_category_name_new, 'p_category_name_new'),
            new SoapParam($p_assigned_to, 'p_assigned_to')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the versions belonging to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return ProjectVersionDataArray
   */
  public function mc_project_get_versions($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_versions', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit the specified version details. 
   *
   * @param string $username
   * @param string $password
   * @param ProjectVersionData $version
   * @return integer
   */
  public function mc_project_version_add($username, $password, ProjectVersionData $version) {
    return $this->__call('mc_project_version_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($version, 'version')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Update version method. 
   *
   * @param string $username
   * @param string $password
   * @param integer $version_id
   * @param ProjectVersionData $version
   * @return boolean
   */
  public function mc_project_version_update($username, $password, integer $version_id, ProjectVersionData $version) {
    return $this->__call('mc_project_version_update', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($version_id, 'version_id'),
            new SoapParam($version, 'version')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the version with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $version_id
   * @return boolean
   */
  public function mc_project_version_delete($username, $password, integer $version_id) {
    return $this->__call('mc_project_version_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($version_id, 'version_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the released versions that belong to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return ProjectVersionDataArray
   */
  public function mc_project_get_released_versions($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_released_versions', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the unreleased version that belong to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return ProjectVersionDataArray
   */
  public function mc_project_get_unreleased_versions($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_unreleased_versions', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the attachments that belong to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return ProjectAttachmentDataArray
   */
  public function mc_project_get_attachments($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_attachments', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the custom fields that belong to the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return CustomFieldDefinitionDataArray
   */
  public function mc_project_get_custom_fields($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_custom_fields', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the data for the specified project attachment. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_attachment_id
   * @return base64Binary
   */
  public function mc_project_attachment_get($username, $password, integer $project_attachment_id) {
    return $this->__call('mc_project_attachment_get', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_attachment_id, 'project_attachment_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Submit a new project attachment. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param string $name
   * @param string $title
   * @param string $description
   * @param string $file_type
   * @param base64Binary $content
   * @return integer
   */
  public function mc_project_attachment_add($username, $password, integer $project_id, $name, $title, $description, $file_type, $content) {
    return $this->__call('mc_project_attachment_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($name, 'name'),
            new SoapParam($title, 'title'),
            new SoapParam($description, 'description'),
            new SoapParam($file_type, 'file_type'),
            new SoapParam($content, 'content')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Delete the project attachment with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_attachment_id
   * @return boolean
   */
  public function mc_project_attachment_delete($username, $password, integer $project_attachment_id) {
    return $this->__call('mc_project_attachment_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_attachment_id, 'project_attachment_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the subprojects ID of a specific project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return StringArray
   */
  public function mc_project_get_all_subprojects($username, $password, integer $project_id) {
    return $this->__call('mc_project_get_all_subprojects', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the filters defined for the specified project. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @return FilterDataArray
   */
  public function mc_filter_get($username, $password, integer $project_id) {
    return $this->__call('mc_filter_get', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the issues that match the specified filter and paging details. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param integer $filter_id
   * @param integer $page_number
   * @param integer $per_page
   * @return IssueDataArray
   */
  public function mc_filter_get_issues($username, $password, integer $project_id, integer $filter_id, integer $page_number, integer $per_page) {
    return $this->__call('mc_filter_get_issues', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($filter_id, 'filter_id'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the issue headers that match the specified filter and paging details. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param integer $filter_id
   * @param integer $page_number
   * @param integer $per_page
   * @return IssueHeaderDataArray
   */
  public function mc_filter_get_issue_headers($username, $password, integer $project_id, integer $filter_id, integer $page_number, integer $per_page) {
    return $this->__call('mc_filter_get_issue_headers', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($filter_id, 'filter_id'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the value for the specified configuration variable. 
   *
   * @param string $username
   * @param string $password
   * @param string $config_var
   * @return string
   */
  public function mc_config_get_string($username, $password, $config_var) {
    return $this->__call('mc_config_get_string', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($config_var, 'config_var')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Notifies MantisBT of a check-in for the issue with the specified id. 
   *
   * @param string $username
   * @param string $password
   * @param integer $issue_id
   * @param string $comment
   * @param boolean $fixed
   * @return boolean
   */
  public function mc_issue_checkin($username, $password, integer $issue_id, $comment, $fixed) {
    return $this->__call('mc_issue_checkin', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($issue_id, 'issue_id'),
            new SoapParam($comment, 'comment'),
            new SoapParam($fixed, 'fixed')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get the value for the specified user preference. 
   *
   * @param string $username
   * @param string $password
   * @param integer $project_id
   * @param string $pref_name
   * @return string
   */
  public function mc_user_pref_get_pref($username, $password, integer $project_id, $pref_name) {
    return $this->__call('mc_user_pref_get_pref', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($project_id, 'project_id'),
            new SoapParam($pref_name, 'pref_name')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Get profiles available to the current user. 
   *
   * @param string $username
   * @param string $password
   * @param integer $page_number
   * @param integer $per_page
   * @return ProfileDataSearchResult
   */
  public function mc_user_profiles_get_all($username, $password, integer $page_number, integer $per_page) {
    return $this->__call('mc_user_profiles_get_all', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Gets all the tags. 
   *
   * @param string $username
   * @param string $password
   * @param integer $page_number
   * @param integer $per_page
   * @return TagDataSearchResult
   */
  public function mc_tag_get_all($username, $password, integer $page_number, integer $per_page) {
    return $this->__call('mc_tag_get_all', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($page_number, 'page_number'),
            new SoapParam($per_page, 'per_page')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Creates a tag. 
   *
   * @param string $username
   * @param string $password
   * @param TagData $tag
   * @return integer
   */
  public function mc_tag_add($username, $password, TagData $tag) {
    return $this->__call('mc_tag_add', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($tag, 'tag')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

  /**
   * Deletes a tag. 
   *
   * @param string $username
   * @param string $password
   * @param integer $tag_id
   * @return boolean
   */
  public function mc_tag_delete($username, $password, integer $tag_id) {
    return $this->__call('mc_tag_delete', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password'),
            new SoapParam($tag_id, 'tag_id')
      ),
      array(
            'uri' => 'http://futureware.biz/mantisconnect',
            'soapaction' => ''
           )
      );
  }

}

?>
