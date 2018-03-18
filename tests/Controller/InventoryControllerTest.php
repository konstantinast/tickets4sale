<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InventoryControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        $client->request('GET', '/inventory/show/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowSubmitValidData()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/inventory/show/');

        $form = $crawler->selectButton('Submit')->form();
        $form["form[showDate]"] = '2018-03-27';

        // submit the form
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains(
            'ELF THE MUSICAL',
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            'COMEDY OF ERRORS',
            $client->getResponse()->getContent()
        );
    }

    public function testShowSubmitInvalidData()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/inventory/show/');

        $invalidShowDateString = 'NOT a VALID DATE VALUE';
        $form = $crawler->selectButton('Submit')->form();
        $form["form[showDate]"] = $invalidShowDateString;

        // submit the form
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertContains(
            'This value is not valid.',
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            $invalidShowDateString,
            $client->getResponse()->getContent()
        );
    }
}