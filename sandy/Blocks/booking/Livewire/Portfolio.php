<?php

namespace Sandy\Blocks\booking\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Sandy\Blocks\booking\Models\BookingService;

class Portfolio extends Component
{
    use WithFileUploads;

    public $user_id;
    public $user;
    public $photos = [];

    public function mount(){

        $this->refresh();
    }


    public function updatedPhotos(){
        $this->validate([
            'photos.*' => 'image|max:2048',
        ]);
        
        $booking = $this->user->booking;
        foreach ($this->photos as $photo) {

            
            $filesystem = sandy_filesystem('media/booking');
            $thumbnail = $photo->storePublicly('media/booking', $filesystem);
            $thumbnail = str_replace('media/booking', "", $thumbnail);

            $booking['gallery'][] = $thumbnail;
        }


        $this->user->booking = $booking;
        $this->user->update();

        $this->refresh();
    }

    public function delete($id){
        $booking = $this->user->booking;
        if (is_array($gallery = ao($this->user->booking, 'gallery'))) {
            foreach ($gallery as $key => $value) {
                if ($value == $id) {
                    \UserStorage::remove('media/booking', $value);
                    unset($booking['gallery'][$key]);
                }
            }
        }

        $this->user->booking = $booking;
        $this->user->update();

        $this->refresh();
    }
    

    public function refresh(){

        $this->user = \App\User::find($this->user_id);
    }

    public function render()
    {

        return view('Blocks-booking::mix.livewire.portfolio');
    }
}
