<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 14/03/2017
 * Time: 08:02
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecuritryControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();

        // always follow ALL redirects
        $this->client->followRedirects();
    }

    public function testSecuredAdminHome()
    {
        // arrange
        $crawler = $this->client->request('GET', '/login');
        $contentToFind = 'h1:contains("Login")';

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter($contentToFind)->count());
    }


}