  
<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once('./vendor/autoload.php');
require_once('phpunit/FusionDirectoryTestCase.php');

class testLogin extends  FusionDirectoryTestCase  {
        /**
         * @var \RemoteWebDriver
         */
        protected $driver;
        
        public function setUp() : void
        {
            $capabilities = DesiredCapabilities::chrome();
            $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        }
        public function testVersion() 
        {
            //$this->driver->wait();
            $this->driver->get("http://localhost/fusiondirectory/index.php");

            try {
                $element = $this->driver->findElement(WebDriverBy::xpath("//div[contains(@class, 'copynotice')]"))->findElement(WebDriverBy::tagName("a"));
                $this->assertStringEndsWith('1.3.1', $element->getText());

            }
            catch( Exception $e){
             $this->fail('Could not find version information');
            }

            $this->driver->quit();

        }
        public function testGoodLogin()
        {
           $this->login('fd-admin', 'adminpwd');
           $this->assertLoggedIn('fd-admin');
           $this->driver->quit();
        }

        
    }

    
    // public function testGoodLogin()
    // {
    //   $this->login('fd-admin', 'adminpwd');
    //   $this->assertLoggedIn('fd-admin');
    // }
  
