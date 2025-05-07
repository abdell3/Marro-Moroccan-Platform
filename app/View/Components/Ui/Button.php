<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $color;
    public $href;

    public function __construct($type = 'button', $color = 'primary', $href = null)
    {
        $this->type = $type;
        $this->color = $color;
        $this->href = $href;
    }

    public function render()
    {
        return view('components.ui.button');
    }
}