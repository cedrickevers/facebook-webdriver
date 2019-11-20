<?php
 
 require_once('./vendor/autoload.php');
 
 use PHPUnit\Framework\TestCase;
 use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once("./a.php");
    class Login extends TestCase {

        /**
         * @var \RemoteWebDriver
         */
        protected $webDriver;
        
        public function setUp() : void
        {
            $capabilities = DesiredCapabilities::firefox();
            $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        }
    
        protected $url = 'http://demo-fixes.fusiondirectory.org/fusiondirectory/main.php?global_check=1';
    
        public function fd_login(){
            // navigate to  
            $this->webDriver->get('http://demo-fixes.fusiondirectory.org/fusiondirectory/');
            
            $this->webDriver->findElement(
                WebDriverBy::id('username')
            )->sendKeys("fd-admin");
            
            
            $this->webDriver->findElement(
                WebDriverBy::id('password')
            )->sendKeys("tester");
            
            $this->webDriver->findElement(
                WebDriverBy::name('login')
            )->click();    
            
        
 
         }
         
         public function getLoginNameValue() {
            $element = $this->webDriver->findElement(WebDriverBy::tagName('b'));
            $headerText = $element->getText();
         }
      
         public function testIfLoginIsSuccessfull()
        {
            $this->fd_login();
            //$this->webDriver->get($this->url);
            // checking that page title contains word 'GitHub'
            $element = $this->webDriver->findElement(WebDriverBy::tagName('b'));
            $headerText = $element->getText();          
            $this->assertStringContainsString('fd-admin',  $headerText );


               // $value = $this->webDriver->get($this->url);
            // $testArray = ['FusionDirectory - Bienvenue System Administrator !'];
            //  $this->assertContains($value, $testArray, " test");
            //  $this->webDriver->quit();
         
             $this->webDriver->quit();
        }    
  
    }
   // element.getAtribute("value");
 
 //