<?php

namespace App\Livewire\Channel;

use Image;
use App\Models\Channel;

use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditChannel extends Component
{

    use AuthorizesRequests;
    use WithFileUploads;

    public $channel;
    public $image;


    protected function rules()
    {
        return [
            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'required|max:1000',
            'image' => 'nullable|image|max:1024',
        ];
    }



    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }


    public function render()
    {
        return view('livewire.channel.edit-channel');
    }

    public function update()
    {

        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([
            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,
         //   'image' => $this->channel->image,
        ]);

        // if image is uploaded
    if ($this->image) {


       // $name = md5($this->image . microtime()).'.'.$this->image->extension();

        $uid = md5($this->image . microtime());
        $name = $uid . '.' . $this->image->extension();
        // save image to storage
        $this->image->storeAs('images', $name);
        $imageImage = explode('/', $name);

        // resice image and convert to png format

        $manager = new ImageManager();

        $image = $manager->make(public_path('/images/' . $name))
        ->encode('png')
        ->fit(80, 60, function ($constraint) {
            $constraint->upsize();
        });
        $image->save(public_path('/images/' . $name));

       // dd($imageImage);

        // update channel image and uid
        $this->channel->update([
        'image' => $name,
        'uid' => $uid,
        ]);

        // resize image

        //$image = Image::make(public_path('storage/images/' . $name))->fit(1000, 1000);
        //$image->save();

   }
        session()->flash('success', 'Channel updated successfully.');

     return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);


    }
}
