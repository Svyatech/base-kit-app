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
        $this->get('/ru')->assertOk()->assertSee('Путеводитель');
        $this->get('/en')->assertOk()->assertSee('Travel guide');
    }

    /**
     * @return void
     */
    public function test_preview_pages_respond(): void
    {
        $this->get('/ru/preview/city')->assertOk()->assertSee('Нячанг');
        $this->get('/ru/preview/article')->assertOk()->assertSee('Рынки Нячанга');
        $this->get('/ru/preview/arrival')->assertOk()->assertSee('Советы по прилёту');
        $this->get('/ru/preview/my')->assertOk()->assertSee('Моё');
    }
}
