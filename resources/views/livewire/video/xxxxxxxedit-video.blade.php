<div wire:poll.visible>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-sm-4">

                        <img src="{{ asset($this->video->thumbnail) }}" alt="{{ $video->title }}" class="img-fluid rounded-4">
                    </div>
                    <div class="col-sm-8">
                        <p>Video Encoding in Progress</p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="{{ $this->video->processing_percentage }}" aria-valuemin="0"
                                aria-valuemax="100" style="width: {{ $this->video->processing_percentage }}%">
                                {{ $this->video->processing_percentage }}%</div>
                                <p class="text-start">The video is now being prepared for streaming. Take this time to add a brief description and choose a title. You can also make changes to this later in your video overview.</p>
                        </div>
                    </div>
                </div>

                <br>
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="update">
                            <div class="form-group">
                                <label for="video.title">Title</label>
                                <input id="video.title" name="video.title" type="text" class="form-control"
                                    wire:model="video.title">
                            </div>
                            @error('video.title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror



                            <div class="form-group">
                                <label for="video.description">Description</label>
                                <textarea id="video.description" name="video.description" cols='30' rows='4' class="form-control"
                                    wire:model="video.description"></textarea>
                                @error('video.description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="video.visibility">Visibility</label>
                                <select id="video.visibility" name="video.visibility" class="form-control"
                                    wire:model="video.visibility">
                                    <option value="private">Private</option>
                                    <option value="public">Public</option>
                                    <option value="unlisted">Unlisted</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
