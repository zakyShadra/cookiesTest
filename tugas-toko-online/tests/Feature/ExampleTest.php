<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_root_dialihkan_ke_barang(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/barang');
    }
}
