<?php

namespace Esign\InlineEdit\Tests\Http\Controllers;

use Esign\InlineEdit\Tests\TestCase;

class InlineEditController extends TestCase
{
    /** @test */
    public function it_can_start_an_inline_editing_session()
    {
        $this->refreshApplication();
        $response = $this
            ->get(route('inline-editing.start'));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('is_editing', true);
    }

    /** @test */
    public function it_can_stop_an_inline_editing_session()
    {
        $this->refreshApplication();
        $response = $this
            ->get(route('inline-editing.stop'));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('is_editing', false);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $this->refreshApplication();
        $response = $this
            ->get(route('inline-editing.update'));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('is_editing', false);
    }
}
