<div>
@if($channel->image)
    <img src="{{ asset('/images'. '/' . $channel->image) }}" class="img-thumbnail">
@endif

<form wire:submit.prevent="update">


    <div class="form-group">
        <label for="channel.name">Channel Name</label>
        <input id="channel.name" name="channel.name" type="text" class="form-control" wire:model="channel.name">
    </div>
    <div class="form-group">
        <label for="channel.slug">Slug</label>
        <input id="channel.slug" name="channel.slug" type="text" wire:model="channel.slug" class="form-control">
    </div>

    <div class="form-group">
        <input type="file" wire:model="image" class="">
        <div>
            @error('image') <span class="text-sm text-red-500 italic">{{ $message }}</span>@enderror
        </div>
        <div wire:loading wire:target="image" class="text-sm text-gray-500 italic">Uploading...</div>
    </div>

    <div class="form-group">
        <label for="channel.description">Description</label>
        <textarea id="channel.description" name="channel.description" cols='30' rows='4' class="form-control" wire:model="channel.description"></textarea>
        @error('channel.description') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        @if ($image)
        Photo Preview:
        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail">
    @endif

    </div>



    <div class="form-group">
        <button class="btn btn-primary" type="submit">Update</button>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</form>

</div>
