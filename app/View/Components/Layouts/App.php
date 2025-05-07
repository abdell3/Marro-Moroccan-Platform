<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class App extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name', 'Marro');
    }

    public function render()
    {
        return view('layouts.app');
    }
}