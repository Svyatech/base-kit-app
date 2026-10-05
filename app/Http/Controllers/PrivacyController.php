<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Class PrivacyController
 */
class PrivacyController extends Controller
{
    /**
     * @return View
     */
    public function __invoke(): View
    {
        return view('privacy');
    }
}
