<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

// An example of using php-webdriver.
// Do not forget to run composer install before and also have Selenium server started and listening on port 4444.

namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');



function fd_login(){
    // start Chrome with 5 seconds timeout
    
    $host = 'http://localhost:4444/wd/hub'; // this is the default
    $capabilities = DesiredCapabilities::firefox();
    $driver = RemoteWebDriver::create($host, $capabilities, 5000);
// navigate to  
$driver->get('http://demo-fixes.fusiondirectory.org/fusiondirectory/');

$driver->findElement(
    WebDriverBy::id('username')
)->sendKeys("fd-admin");


$driver->findElement(
    WebDriverBy::id('password')
)->sendKeys("tester");

$driver->findElement(
    WebDriverBy::name('login')
)->click();



// close the browser
$driver->quit();
}

fd_login();