<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    protected function createAuthenticatedClient($username = 'admin@admin.com', $password = '12345')
    {
        $client = static::createClient();
        $client->enableProfiler();
        $client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password,
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        print_r($client->getResponse());
//        print_r($client->getResponse());

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * test getPagesAction
     */
    public function testGetUsers()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/v1/users/all');

        print_r($client->getResponse());
    }

    /**
     * test getPagesAction
     */
    public function testGetAuctions()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/v1/auctions/all');

        print_r($client->getResponse());
    }
}