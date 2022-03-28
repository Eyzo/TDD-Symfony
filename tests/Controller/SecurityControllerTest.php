<?php
namespace App\Tests\Controller;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\PantherTestCase;

class SecurityControllerTest extends PantherTestCase
{

  public function testLoginForm()
  {
    $client = self::createPantherClient();
    $client->request('GET','/login');
    $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#remember_me'))->click();
    $this->assertSelectorExists('h1');
  }

}
