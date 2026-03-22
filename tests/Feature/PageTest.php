<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageTest extends TestCase
{
    public function test_tentang_page_is_accessible(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
    }

    public function test_kontak_page_is_accessible(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_kebijakan_privasi_page_is_accessible(): void
    {
        $response = $this->get('/kebijakan-privasi');
        $response->assertStatus(200);
    }

    public function test_syarat_ketentuan_page_is_accessible(): void
    {
        $response = $this->get('/syarat-ketentuan');
        $response->assertStatus(200);
    }

    public function test_pengembalian_page_is_accessible(): void
    {
        $response = $this->get('/pengembalian');
        $response->assertStatus(200);
    }

    public function test_bantuan_page_is_accessible(): void
    {
        $response = $this->get('/bantuan');
        $response->assertStatus(200);
    }
}
