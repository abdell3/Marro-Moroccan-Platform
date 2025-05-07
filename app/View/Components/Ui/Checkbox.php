<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $disabled;

    public function __construct($disabled = false)
    {
        $this->disabled = $disabled;
    }

    public function render()
    {
        return view('components.ui.checkbox');
    }
}