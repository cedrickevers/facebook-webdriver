<?php
 
 require_once('./vendor/autoload.php');
 
 use PHPUnit\Framework\TestCase;
 use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

require_once("./a.php");
    class GitHubTest extends TestCase {

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
    
        public function t(){
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
            
            
            
            // close the browser
            $this->webDriver->quit();
            }

        public function testGitHubHome()
        {
            $this->t();
            //$this->webDriver->get($this->url);
            // checking that page title contains word 'GitHub'
            //$this->assertContains('GitHub', $this->webDriver->getTitle());
            //$this->webDriver->quit();
        }    
    
    }
 
 