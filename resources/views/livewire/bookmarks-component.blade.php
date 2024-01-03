@if (isset($bookmarks) && count($bookmarks) > 0)
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="bookmarksDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bookmark fa-fw"></i>
            <span class="badge badge-success">{{ count($bookmarks) }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bookmarksDropdown">
            <h6 class="dropdown-header">Bookmarks</h6>
            <div wire:poll.30000ms>
                @foreach ($bookmarks as $bookmark)
                    <a class="dropdown-item" href="{{ $bookmark->link }}">
                        {{ substr($bookmark->name, 0, 25) }}
                    </a>
                @endforeach
            </div>
            <div class="dropdown-divider"></div>
        </div>
    </li>
@else
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="bookmarksDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bookmark fa-fw"></i>
            <span class="badge badge-success"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bookmarksDropdown">
            <h6 class="dropdown-header">Bookmarks</h6>
            <h5> Noch keine Bookmarks</h5>
            <div class="dropdown-divider"></div>
        </div>
    </li>
@endif
