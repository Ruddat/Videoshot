<div>
    <button wire:click="addOpeningHours">Add Opening Hours</button>

    @foreach ($openingHours as $parentIndex => $hours)
        <div>
            <select wire:model="openingHours.{{ $parentIndex }}.day">
                <option value="">Select Day</option>
                @foreach ($daysOfWeek as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
            @foreach ($hours['times'] as $childIndex => $time)
                <div>
                    <input type="time" wire:model="openingHours.{{ $parentIndex }}.times.{{ $childIndex }}.from" placeholder="From">
                    <input type="time" wire:model="openingHours.{{ $parentIndex }}.times.{{ $childIndex }}.to" placeholder="To">
                    @if ($childIndex > 0)
                        <button wire:click="removeTime({{ $parentIndex }}, {{ $childIndex }})">Remove Time</button>
                    @endif
                </div>
            @endforeach
            <button wire:click="addTime({{ $parentIndex }})">Add Time</button>
            <button wire:click="removeOpeningHours({{ $parentIndex }})">Remove</button>
        </div>
    @endforeach
</div>
