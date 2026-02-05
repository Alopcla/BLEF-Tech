<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    /** Variables que se veran en el Blade. Para que se vean, tienen que ser
     * publicas.
     */
    public $employee;
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-card');
    }
}
