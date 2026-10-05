<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @return void
     */
    public function test_root_redirects_russian_browser_to_ru(): void
    {
        $this->withHeader('Accept-Language', 'ru-RU,ru;q=0.9')->get('/')->assertRedirect('/ru');
    }

    /**
     * @return void
     */
    public function test_root_without_language_header_defaults_to_ru(): void
    {
        $this->withHeader('Accept-Language', '')->get('/')->assertRedirect('/ru');
    }

    /**
     * @return void
     */
    public function test_root_respects_accept_language(): void
    {
        $this->withHeader('Accept-Language', 'en-US,en;q=0.9')->get('/')->assertRedirect('/en');
    }

    /**
     * @return void
     */
    public function test_home_page_responds_in_both_locales(): void
    {
        $this->get('/ru')->assertOk()->assertSee('Движок запущен');
        $this->get('/en')->assertOk()->assertSee('Engine is running');
    }
}
