<?php

namespace App\Livewire;

use Livewire\Component;

class OpeningHoursForm extends Component
{
    public $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $openingHours = [];

    public function addOpeningHours()
    {
        $this->openingHours[] = [
            'day' => '',
            'times' => [
                ['from' => '', 'to' => '']
            ]
        ];
    }

    public function addTime($index)
    {
        $this->openingHours[$index]['times'][] = ['from' => '', 'to' => ''];
    }

    public function removeOpeningHours($index)
    {
        unset($this->openingHours[$index]);
        $this->openingHours = array_values($this->openingHours);
    }

    public function removeTime($parentIndex, $childIndex)
    {
        unset($this->openingHours[$parentIndex]['times'][$childIndex]);
        $this->openingHours[$parentIndex]['times'] = array_values($this->openingHours[$parentIndex]['times']);
    }

    public function render()
    {
        return view('livewire.opening-hours-form');
    }
}
