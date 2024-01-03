<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card"
                    x-data="{ isUploading: false, progress: 0 }"

                    x-on:livewire-upload-start="isUploading = true"

                    x-on:livewire-upload-finish="isUploading = false , $wire.fileComplete()"

                    x-on:livewire-upload-error="isUploading = false"

                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                    <div class="card-body">

                    <div class="progress my-4" x-show="isUploading" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" x-bind:style="'width: ' + progress + '%'"></div>
                      </div>

                       <form x-show="!isUploading">

                        <input type="file" wire:model="videoFile">

                       </form>


                        <div>
                            @error('videoFile')
                                <span class="text-sm text-red-500 italic">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
