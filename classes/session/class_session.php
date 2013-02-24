<?php
/*
* Filename.......: class_session.php
* Author.........: Troy Wolf [troy@troywolf.com]
* Last Modified..: Date: 2005/06/18 14:20:00
* Description....: A session management and password protection class.
                   This class can be used to perform 2 major functinos:
                      1. Create and maintain session state between page hits.
                         This class does this using simple session cache files
                         into which the session is stored as a serialized array.
                         This is similar to how PHP's built-in sessions store
                         session data.  One big advantage of this class is that
                         you have full control over the session time-out.
                      2. Password protect PHP pages by requiring authentication.
                         Simply pass in "true" when creating a new session
                         object to use this functionality. You'll also need to
                         create your own login.php script. A sample login.php
                         is packaged with this class.

                   Be sure you look at the cleanAll() method in this class.
*/
class session {

  var $id;
  var $data;
  var $log;
  var $dir;
  var $filename;
  var $login_page;

  /*
  The class constructor.
  */
  function session($login_required=false) {
    $this->log = "session() called<br />";
    $ret = true;

    /*
    All the session variables are available in the data[] array. Unless you
    know what you are doing, Do not use these array keys as they are used
    internally by the class:
        logged_in
        page_destination
    */
    $this->data = array();

    /*
    If you will have some pages that require login, set your login page here.
    Defaults to login.php in current dir.
    */
    $this->login_page = "login.php";

    /*
    Define the directory to save session files in. This defaults to the current
    dir, but this is probably not what you want. For one thing, it is INSECURE!
    It also will prevent your sessions from working between scripts in different
    dirs. It is highly recommended that you set this to a non web-accessible
    dir. End this value with a "/".
    */
    $this->dir = realpath("/var/www/clients/client1/web23/tmp")."/";

    if ($this->exists()) {
      $this->log .= "sid: ".$this->id."<br />";
      if (!$this->load()) {
        /*
        This is not necessarily a show-stopper. This will happen if you've
        previously started a session, but never saved it. This would also occur
        if you delete the session's cache file during a live session.
        */
        $this->log .= "Could not restore session.<br />";
        $ret = true;
      }
    } else {
      if (!$this->newId()) {
        $this->log .= "Could not create new session.<br />";
        $ret = false;
      }
      $this->log .= "sid: ".$this->id."<br />";
    }

    if ($login_required) {
      $this->log .= "Require login requested<br />";
      if (!$this->data['logged_in']) {
        $this->log .= "Not logged in, redirecting to "
          .$this->login_page."<br />";
        $this->data['page_destination'] = $_SERVER['SCRIPT_NAME'];
        $this->save();
        header("Location: ".$this->login_page);
      }
    }
    return $ret;
  }

  /*
  expire() is useful for a logout feature. It will empty the session data,
  delete the session file, and expire the sid cookie.
  */
  function expire() {
    $this->log .= "expire() called<br />";
    $ret = true;
    $this->data = array();
    if (!file_exists($this->filename)) {
      $this->log .= $this->filename." does not exist.<br />";
      $ret = false;
    } else {
      if (!@unlink($this->filename)) {
        $this->log .= "session file delete failed for "
          .$this->filename."<br />";
        $ret = false;
      }
    }
    if (!setcookie('sid' ,$this->id, time()-3600, "/")) {
      $this->log .= "sid cookie expire failed. This may be due to browser"
        ." output started prior.<br />";
      $ret = false;
    }
    return $ret;
  }

  /*
  exists() checks if sid cookie exists on user's computer. If so, set id.
  */
  function exists() {
    $this->log .= "exists() called<br />";
    if (!isset($_COOKIE['sid'])) {
      $this->log .= "sid cookie does not exist.<br />";
      return false;
    }
    $this->id = $_COOKIE['sid'];
    $this->filename = $this->dir."sid_".$this->id;
    return true;
  }

  /*
  newId() generates a 32 character identifier that is extremely difficult to
  predict. Save to a cookie to persist between pages.
  */
  function newId() {
    $this->log .= "newId() called<br />";
    $this->id = sha1(uniqid(rand(), true));
    $this->filename = $this->dir."sid_".$this->id;
    if (!setcookie('sid' ,$this->id, null, "/")) {
      $this->log .= "sid cookie save failed. This may be due to browser"
        ." output started prior or the user has disabled cookies.<br />";
      return false;
    }
    return true;
  }

  /*
  load() reads in session data stored in session file.
  */
  function load() {
    $this->log .= "load() called<br />";
    if (!file_exists($this->filename)) {
      $this->log .= $this->filename." does not exist.<br />";
      return false;
    }
    if (!$x = @file_get_contents($this->filename)) {
      $this->log .= "Could not read ".$this->filename."<br />";
      return false;
    }
    if (!$this->data = unserialize($x)) {
      $this->log .= "unserialize failed<br />";
      $this->data = array();
      return false;
    }
    return true;
  }

  /*
  save() stores session data in session file to persist data between pages.
  */
  function save() {
    $this->log .= "save() called<br />";
    if (count($this->data) < 1) {
      $this->log .= "Nothing to save.<br />";
      return false;
    }
    //create file pointer
    if (!$fp=@fopen($this->filename,"w")) {
      $this->log .= "Could not create or open ".$this->filename."<br />";
      return false;
    }
    //write to file
    if (!@fwrite($fp,serialize($this->data))) {
      $this->log .= "Could not write to ".$this->filename."<br />";
      fclose($fp);
      return false;
    }
    //close file pointer
    fclose($fp);
    return true;
  }

  /*
  cleanAll() will clean up your session dir removing all 'sid_' files with a
  modified date older than the number of minutes passed in. This method is here
  as a convenience. You probably want to create a cron job that cleans this up
  on a daily basis.
  */
  function cleanAll($minutes) {
    $this->log .= "cleanAll() called to delete sessions older than "
      .$minutes." minutes<br />";
    chdir($this->dir);
    $ret = shell_exec("find -type f -name 'sid_*' -maxdepth 1 -mmin +".$minutes." -exec rm -f {} \;");
  }

}

?>
