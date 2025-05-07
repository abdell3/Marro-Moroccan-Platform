<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Input extends Component
{
    public $disabled;
    public $icon;
    public $togglePassword;
    public $type;

    public function __construct($disabled = false, $icon = null, $togglePassword = false, $type = 'text')
    {
        $this->disabled = $disabled;
        $this->icon = $icon;
        $this->togglePassword = $togglePassword;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.ui.input');
    }
}