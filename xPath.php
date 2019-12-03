<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

function createByxPath($driver){


// navigate to  
    $driver->get('http://demo-fixes.fusiondirectory.org/fusiondirectory/');

    $driver->findElement(WebDriverBy::xpath('//*[@id="username"]'))->sendKeys("fd-admin");
    $driver->findElement(WebDriverBy::xpath('//*[@id="password"]'))->sendKeys("tester");
    $driver->findElement(WebDriverBy::xpath('//*[@id="window-footer"]/div[2]/input[1]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="menuitem_icon_userManagement"]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="pulldown"]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="actionmenu_create"]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="actionmenu_new_user"]/a'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="sn"]'))->sendKeys("createUser");
    $driver->findElement(WebDriverBy::xpath('//*[@id="givenName"]'))->sendKeys("createUuser");
    $driver->findElement(WebDriverBy::xpath('//*[@id="uid"]'))->sendKeys("usercreate");
    $driver->findElement(WebDriverBy::xpath('//*[@id="userPassword_password"]'))->sendKeys("fusion");
    $driver->findElement(WebDriverBy::xpath('//*[@id="userPassword_password2"]'))->sendKeys("fusion");
    $driver->findElement(WebDriverBy::xpath('//*[@id="maincell"]/div/p/input[1]'))->click();
    $driver->wait()->until(
        WebDriverExpectedCondition::urlIs("http://demo-fixes.fusiondirectory.org/fusiondirectory/main.php?plug=212")
      );
}
function deleteUserByXPath($driver){
    $driver->findElement(WebDriverBy::xpath('//*[@id="t_nscrollbody"]/tr[3]/td[7]/input[6]'))->click();
    $driver->findElement(WebDriverBy::xpath('//*[@id="maincell"]/div/div/div[2]/p[4]/input[1]'))->click();
 }
     
 $host = 'http://localhost:4444/wd/hub'; // this is the default
 $capabilities = DesiredCapabilities::chrome();
 $driver = RemoteWebDriver::create($host, $capabilities, 5000);

createByxPath($driver); 
deleteUserByXPath($driver);

     



 










 

