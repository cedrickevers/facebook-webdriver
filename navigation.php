<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
require_once('vendor/autoload.php');
function testNavigate(){
    // start Chrome with 5 seconds timeout
    
    $host = 'http://localhost:4444/wd/hub'; // this is the default
    $capabilities = DesiredCapabilities::firefox();
    $driver = RemoteWebDriver::create($host, $capabilities, 5000);


    // navigate to  
    $driver->get('https://www.google.fr');
    $driver->navigate()->to("https://gitlab.fusiondirectory.org/demonstration/demo-fixes");
    $driver->navigate()->back();
    $driver->navigate()->forward();
    $driver->navigate()->refresh();
}
 

testNavigate();

