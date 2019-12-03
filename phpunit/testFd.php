 
<?php
 
 require_once('./vendor/autoload.php');
 
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
require_once("./fd.php");
    class Login extends TestCase {
        /**
         * @var \RemoteWebDriver
         */
        protected $webDriver;
        
        public function setUp() : void
        {
            $capabilities = DesiredCapabilities::chrome();
            $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        }
        public function testGoodLogin()
        {
            $this->login('fd-admin', 'adminpwd');
            $this->assertLoggedIn('fd-admin');
        }

    }    