<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Auth extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name', 'Marro');
    }

    public function render()
    {
        return view('layouts.auth');
    }
}