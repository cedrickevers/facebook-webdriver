<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;


require_once('vendor/autoload.php');

function navigation() {
 
    $host = 'http://localhost:4444/wd/hub'; // this is the default
    $capabilities = DesiredCapabilities::chrome();
    $driver = RemoteWebDriver::create($host, $capabilities, 5000);

    $driver->get("http://demo-fixes.fusiondirectory.org/fusiondirectory/");
    $driver->navigate()->to("https://google.fr");
    $driver->navigate()->back();
    $driver->navigate()->forward();
    $driver->navigate()->back();

    $driver->findElement(WebDriverBy::id("username"))->sendKeys("test");
    $driver->wait();
    $driver->navigate()->refresh();


}

navigation();


 
