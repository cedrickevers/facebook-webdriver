<?php

namespace Facebook\WebDriver;

Use Facebook\WebDriver\Remote\DesiredCapabilities;
Use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once ("vendor/autoload.php");

function getLink() {
    $host = "http://localhost:4444/wd/hub";
    $capabilities = DesiredCapabilities::chrome();
    $driver = RemoteWebDriver::create($host, $capabilities, 5000);

    $driver->get("http://demo.guru99.com/test/block.html");					
    $driver->findElement(WebDriverBy::partialLinkText("Inside"))->click();
    $driver->navigate()->back();			
    $driver->findElement(WebDriverBy::partialLinkText("Outside"))->click();					
    $driver->quit();	
}

getLink();