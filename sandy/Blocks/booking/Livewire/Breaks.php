<?php

namespace Sandy\Blocks\booking\Livewire;

use Livewire\Component;
use Carbon\CarbonPeriod;
use Sandy\Blocks\booking\Helper\Time;
use Sandy\Blocks\booking\Models\BookingService;

class Breaks extends Component
{

    public $user_id;
    public $user;

    public $services;


    public $break_date;
    public $break_start_time;
    public $break_end_time;


    public $mee;


    protected $rules = [

        'services.*.name' => 'required',
        'services.*.duration' => 'required|numeric',
        'services.*.price' => 'required|numeric',

    ];

    public function mount(){

        $this->user = \App\User::find($this->user_id);

        $this->refresh();
    }

    public function create(){
        $this->validate([
            'break_date' => 'required',
            'break_start_time' => 'required',
            'break_end_time' => 'required',
        ]);

        $save = function($date) use ($request){
            $start_time = hour2min($this->break_start_time);
            $end_time = hour2min($this->break_end_time);
            $time = implode('-', [$start_time, $end_time]);
            
            $break = new BarbersWorkingBreak;
            $break->user = $this->user_id;
            $break->date = $date;
            $break->time = $time;
            $break->save();

            return $break;
        };

        $breaks = explode(',', $this->break_date);
        if(!empty($breaks[1])){
            
            $period = CarbonPeriod::create($breaks[0], $breaks[1]);

            foreach ($period as $d) {
                $save($d->format('Y-m-d'));
            }

            return $back();
        }

        $save($breaks[0]);

        $this->refresh();
    }

    public function sort($list){

        foreach ($list as $key => $value) {
            
            $value['value'] = (int) $value['value'];
            $value['order'] = (int) $value['order'];
            $update = BookingService::find($value['value']);
            $update->position = $value['order'];
            $update->save();
        }
        
        $this->refresh();
    }

    public function edit($id, $index){
        foreach ($this->services as $item) {
            $item->save();
        }
    }

    public function delete($id){
        if (!$delete = BookingService::where('id', $id)->where('user', $this->user_id)->first()) {
            return false;
        }
        $delete->delete();
        $this->refresh();
    }
    

    public function refresh(){
        $services = BookingService::where('user', $this->user_id)->orderBy('position', 'ASC')->orderBy('id', 'DESC')->get();

        
        $this->services = $services;
    }

    public function render()
    {

        return view('Blocks-booking::mix.livewire.breaks');
    }
}
