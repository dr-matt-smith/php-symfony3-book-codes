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

class AdminControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();

    }

    public function testSecuredAdminHome()
    {
        $crawler = $this->client->request('GET', '/admin');
        $this->client->followRedirects();

        var_dump($this->client->getResponse());
        die();

        // should be redirected to login form - now login with valid admin/admin
        $this->loginValidAdmin($crawler);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Admin page!")')->count());
    }

    /**
     * @param $crawler
     *
     * based on
     * http://symfony.com/doc/current/testing.html#forms
     */
    public function loginValidAdmin($crawler)
    {
        $buttonCrawlerNode = $crawler->selectButton('login');
        $form = $buttonCrawlerNode->form();
        $form = $buttonCrawlerNode->form(array(
            '_username' => 'admin',
            '_password' => 'admin',
        ));

        $this->client->submit($form);
    }

    private function logInMattSmithValid()
    {
        $username = 'matt';
        $password = '$2y$12$4UWrrc1pkskcCMDpcj4XzeLVsn5Tlk4zkQJAyrSaoDnOnY1wgHUH2';

        $this->client->request('GET', '/login', array(), array(), array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $password
        ));

    }
    private function logInMattSmithInValid()
    {
        $username = 'matt';
        $password = 'bad-password';

        $this->client->request('GET', '/login', array(), array(), array(
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $password
        ));

    }
}