<div class="container-fluid pt-5 pb-5">
    <div class="row"
    x-data="{ isUploading: false, progress: 0 }"

    x-on:livewire-upload-start="isUploading = true"

    x-on:livewire-upload-finish="isUploading = false , $wire.fileComplete()"

    x-on:livewire-upload-error="isUploading = false"

    x-on:livewire-upload-progress="progress = $event.detail.progress"
    >
       <div class="col-md-8 mx-auto text-center upload-video pt-5 pb-5">

        <div class="progress my-4" x-show="isUploading" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar progress-bar-striped progress-bar-animated" x-bind:style="'width: ' + progress + '%'"></div>
          </div>
          <h1><i class="fas fa-file-upload text-primary"></i></h1>
          <h4 class="mt-5">Select Video files to upload</h4>
          <p class="land">or drag and drop video files</p>

          <form x-show="!isUploading">
            <input class="btn btn-outline-primary mt-4" type="file" wire:model="videoFile">
           </form>
            <div>
                @error('videoFile')
                    <span class="text-sm text-red-500 italic">{{ $message }}</span>
                @enderror
            </div>
       </div>
    </div>
 </div>
