<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FormationEndpointsTest extends WebTestCase
{
    public function testHealthEndpoint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/health');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($client->getResponse()->getContent());
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(['status' => 'ok'], $data);
    }

    public function testFormationsListDefaultPagination(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJson($client->getResponse()->getContent());
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('items', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('page', $data);
        $this->assertArrayHasKey('limit', $data);
        $this->assertEquals(1, $data['page']);
        $this->assertEquals(10, $data['limit']);
    }

    public function testFormationsListWithCustomPagination(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations?page=2&limit=20');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(2, $data['page']);
        $this->assertEquals(20, $data['limit']);
    }

    public function testFormationsListWithSearchFilter(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations?q=java');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data['items']);
    }

    public function testFormationsListWithDepartementFilter(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations?departement=21');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data['items']);
        
        foreach ($data['items'] as $item) {
            if (!empty($data['items'])) {
                $this->assertEquals('21', $item['departement']);
            }
        }
    }

    public function testFormationsListWithModaliteFilter(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations?modalite=hybride');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data['items']);
        
        foreach ($data['items'] as $item) {
            if (!empty($data['items'])) {
                $this->assertEquals('hybride', $item['modalite']);
            }
        }
    }

    public function testFormationsListWithAllFilters(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations?q=web&departement=21&modalite=presentiel&page=1&limit=5');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($data['items']);
        $this->assertEquals(1, $data['page']);
        $this->assertEquals(5, $data['limit']);
    }

    public function testFormationNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/formations/00000000-0000-0000-0000-000000000000');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}