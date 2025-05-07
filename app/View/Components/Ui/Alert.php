<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public $dismissable;

    public function __construct($type = 'success', $message = null, $dismissable = true)
    {
        $this->type = $type;
        $this->message = $message;
        $this->dismissable = $dismissable;
    }

    public function render()
    {
        return view('components.ui.alert');
    }
}   