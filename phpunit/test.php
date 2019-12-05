 
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
            $capabilities = DesiredCapabilities::chrome();
            $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
        }
    
        protected $url = 'http://demo-fixes.fusiondirectory.org/fusiondirectory/main.php?global_check=1';
    
//Function that simulate login
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
         
   //Function that test if the login redirect to the correct page
        public function testIfLoginIsSuccessfull() {
            $this->fd_login();
            $element = $this->webDriver->findElement(WebDriverBy::tagName('b'));
            $headerText = $element->getText();
// is the welcome text returning  username ?
            $this->assertStringContainsString('fd-admin', $headerText );
                
            $this->webDriver->quit();
        }    
    }