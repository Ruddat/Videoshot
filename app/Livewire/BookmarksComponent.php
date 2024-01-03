<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Session;

class BookmarksComponent extends Component
{
    public $bookmarks, $name, $link;

    public function mount()
    {
        try {
            // Hier werden die Lesezeichen aus der Datenbank abgerufen
            $this->bookmarks = Bookmark::all();
        } catch (\Exception $e) {
            // Fehlerbehandlung, wenn ein Fehler beim Abrufen der Daten auftritt
            // Zum Beispiel:
            $this->bookmarks = []; // Setze $bookmarks als leeres Array
            // Logge den Fehler oder gib eine Fehlermeldung aus
            logger()->error($e->getMessage());
            // Oder zeige eine Fehlermeldung auf der Benutzeroberfläche an
            session()->flash('error', 'Fehler beim Laden der Lesezeichen.');
        }
        $sessionId = Session::getId();

        $this->bookmarks = Bookmark::where('session_id', $sessionId)->get();
    }

    public function render()
    {
        $count = $this->bookmarks ? count($this->bookmarks) : 0;

        return view('livewire.bookmarks-component', [
            'bookmarks' => $this->bookmarks,
            'count' => $count,
        ]);
    }

    public function addBookmark()
    {
        Bookmark::create([
            'name' => $this->name,
            'link' => $this->link

        ]);


        $this->resetFields();
        $this->bookmarks = Bookmark::all();
        $this->dispatch('bookmarkAdded'); // Sende ein Signal, dass ein Lesezeichen hinzugefügt wurde
    }

    private function resetFields()
    {
        $this->name = '';
        $this->link = '';
    }
}
