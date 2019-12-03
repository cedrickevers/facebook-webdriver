 
<?php
 
 require_once('./vendor/autoload.php');
 require_once( "a.php");
 

 
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

    class createDeleteUser extends TestCase {
        /**
         * @var \RemoteWebDriver
         */
        protected $driver;
 
        public function setUp() : void
        {
            $capabilities = DesiredCapabilities::chrome();
            $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        }
    
        protected $url = 'http://demo-fixes.fusiondirectory.org/fusiondirectory/main.php?global_check=1';
    
//Function that simulate login
        public function testCreateAndDeleteuser(){
            // navigate to  
            $this->driver->get('http://demo-fixes.fusiondirectory.org/fusiondirectory/');
            $username = $this->driver->findElement(WebDriverBy::xpath('//*[@id="username"]'))->sendKeys("fd-admin");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="password"]'))->sendKeys("tester");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="window-footer"]/div[2]/input[1]'))->click();
            $this->assertEquals("fd-admin", $this->driver->findElement(WebDriverBy::cssSelector('b'))->getText()); 

            $this->driver->findElement(WebDriverBy::xpath('//*[@id="menuitem_icon_userManagement"]'))->click();
             
            if($this->driver->wait()->until(
                WebDriverExpectedCondition::urlContains("main.php?plug=212&reset=1")
              )){
                $this->assertFalse(false);

              }
              else {
                $this->assertFalse(true);

              }
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="pulldown"]'))->click();
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="actionmenu_create"]'))->click();
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="actionmenu_new_user"]/a'))->click();
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="sn"]'))->sendKeys("createUser");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="givenName"]'))->sendKeys("createUuser");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="uid"]'))->sendKeys("usercreate");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="userPassword_password"]'))->sendKeys("fusion");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="userPassword_password2"]'))->sendKeys("fusion");
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="maincell"]/div/p/input[1]'))->click();
            #
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="t_nscrollbody"]/tr[3]/td[7]/input[6]'))->click();
            $this->driver->findElement(WebDriverBy::xpath('//*[@id="maincell"]/div/div/div[2]/p[4]/input[1]'))->click(); 
          
        }
   
  
    }
