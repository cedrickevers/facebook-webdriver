<?php


//namespace Facebook\WebDriver;

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once('vendor/autoload.php');

class FusionDirectoryTestCase  extends  TestCase {

    static protected $ldap_base           = 'dc=nodomain';
    static protected $ldap_admin          = 'cn=admin,dc=nodomain';
    static protected $ldap_pwd            = 'sai';
    static protected $ldap_host           = 'localhost';
    //static protected $fd_host             = 'selenium-fd';
    static protected $ignore_ldif_errors  = 0;
    static protected $ldap_verbose        = FALSE;
    /* vnu.jar path, from https://github.com/validator/validator.github.io/releases */
    //static protected $vnu_jar_path        = '/opt/validator/vnu/vnu.jar';
  

    private function insertLDIF($filename)
    {
      $file = fopen($filename, 'r');
      $tmp_file = fopen('tmp.ldif', 'w');
      while (($line = fgets($file)) !== FALSE) {
        fwrite($tmp_file, preg_replace(array('/<LDAP_BASE>/', '/<LDAP_HOST>/', '/<LDAP_PWD>/'), array(self::$ldap_base, self::$ldap_host, self::$ldap_pwd), $line));
      }
      fclose($file);
      fclose($tmp_file);
      if (self::$ldap_verbose) {
        $cmd = 'ldapadd -h '.self::$ldap_host.' -D "'. self::$ldap_admin.'" -w "'. self::$ldap_pwd .'"  -f tmp.ldif && rm tmp.ldif';
      } else {
        $cmd = 'ldapadd -h '.self::$ldap_host.' -D "'. self::$ldap_admin.'" -w "'. self::$ldap_pwd .'"  -f tmp.ldif > /dev/null && rm tmp.ldif';
      }
      passthru($cmd, $result);
      if (self::$ignore_ldif_errors == 0) {
        if ($result !== 0) {
          $this->fail('Error while inserting LDIF file "'.$filename.'", ldapadd returned code '.$result);
        }
      }
    }
  
    /**
     * \fn Remove ldap entry recursively
     * \param[in] ds ldap connection
     * \param[in] dn dn to remove
     * \param[in] recursive use recursive search
     */
    static private function deleteLdapEntry($ds, $dn, $recursive = FALSE)
    {
      if ($recursive == FALSE) {
          return ldap_delete($ds, $dn);
      } else {
        // Searching for sub entries
        $sr = ldap_list($ds, $dn, "ObjectClass=*", array(""));
        $info = ldap_get_entries($ds, $sr);
        for ($i = 0; $i < $info['count']; $i++) {
          // Deleting recursively sub entries
          $result = self::deleteLdapEntry($ds, $info[$i]['dn'], $recursive);
          if (! $result) {
              // Return result code, if delete fails
              return $result;
          }
        }
        return ldap_delete($ds, $dn);
      }
    }
  
    /** \fn Function that remove all ldap entry expect base and admin */
    static private function emptyLdap()
    {
      $ds = ldap_connect(self::$ldap_host)
            or die("Could no connect to ".self::$ldap_host);
  
      // Set ldap version
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  
      $ldapbind = ldap_bind($ds, self::$ldap_admin, self::$ldap_pwd);
  
      if (! $ldapbind) {
        echo "Fail connection to ldap in admin";
      } else {
        $filter = '(objectclass=*)';
  
        $list = ldap_list($ds, self::$ldap_base, $filter, array('dn'));
        $result = ldap_get_entries($ds, $list);
  
        for ($i = 0; $i < $result['count']; $i++) {
          if ($result[$i]['dn'] != 'cn=admin,'.self::$ldap_base) {
            self::deleteLdapEntry($ds, $result[$i]['dn'], TRUE);
          }
        }
  
        // Close ldap connection
        ldap_unbind($ds);
      }
    }
  
    /** \fn Function that reset gosaAclEntry */
    static private function resetGosaAclEntry()
    {
      $ds = ldap_connect(self::$ldap_host)
            or die("Could no connect to $ldaphost");
  
      // Set ldap version
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  
      $ldapbind = ldap_bind($ds, self::$ldap_admin, self::$ldap_pwd);
  
      if (! $ldapbind) {
        echo "Fail connection to ldap in admin";
      } else {
        $filter = '(objectclass=*)';
  
        // Find gosaAclEntry
        $aclList = ldap_read($ds, self::$ldap_base, $filter);
        $aclResult = ldap_get_entries($ds, $aclList);
        // Remove gosaAclEntry and replace
        // Replace entry
        $gosaAclEntry = '0:subtree:'.base64_encode('cn=admin,ou=aclroles,'.self::$ldap_base).':'.base64_encode('uid=fd-admin,ou=people,'.self::$ldap_base);
        if (isset($aclResult[0]['gosaaclentry'])) {
          if (! ldap_mod_replace($ds, self::$ldap_base, array('gosaaclentry' => $gosaAclEntry))) {
            echo "Failed replacing gosaAclEntry";
          }
        } else {
          $objectClasses    = $aclResult[0]['objectclass'];
          unset($objectClasses['count']);
          $objectClasses[]  = 'gosaAcl';
          if (! ldap_modify($ds, self::$ldap_base, array('objectclass' => $objectClasses, 'gosaaclentry' => $gosaAclEntry))) {
            echo "Failed adding gosaAclEntry";
          }
        }
  
        // Close ldap connection
        ldap_unbind($ds);
      }
    }  



    //

    protected function login($username, $password)
    {
      $this->driver->get("http://localhost/fusiondirectory/index.php");
  
      /* Fill login and password */
      $this->fillFields(
        array(
          'username' => $username,
          'password' => $password
        )
      );
  
      /* Insist because it sometimes fail the first time */
      $this->fillFields(
        array(
          'username' => $username,
          'password' => $password
        )
      );
  
      /* Check that filling worked */
      $this->verifyIdFields(
        array(
          'username' => $username,
          'password' => $password
        )
      );
  
      $this->driver->findElement(WebDriverBy::name('login'))->click();
    }
  
    // static public function run(){
    //     self::emptyLdap();
    //     self::insertLDIF("ldifs/default.ldif");
    //     self::resetGosaAclEntry();
    // }

} 

// FusionDirectoryTestCase::run();
