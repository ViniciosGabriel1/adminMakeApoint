<?php

namespace App\Livewire;

use App\Models\Clients as ModelsClients;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{

    use WithPagination; // Habilita a paginação


    public $name, $email, $phone, $clientId;
    public $search = '';
    public $editMode = false;
    // protected $paginationTheme = 'bootstrap'; // Opcional - para estilização


    // Regras de validação
    protected $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ];


    public function save()
    {
        $this->validate();

        ModelsClients::updateOrCreate(
            ['id' => $this->clientId], // esse campo deve ser setado no modo de edição
            [
                'user_id' => auth()->id(),
                'name'  => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            ]
        );

        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => empty($this->clientId) ? 'Cadastrado' : 'Atualizado',
            'text'  => empty($this->clientId)
                ? 'Cliente cadastrado com sucesso!'
                : 'Cliente atualizado com sucesso!',
            'position' => 'center'
        ]);

        $this->resetForm();
    }


    public function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'clientId', 'editMode']);
        $this->resetErrorBag();
    }


    public function confirmDelete($id) {

        $this->dispatch('confirm', ClientId: $id);
    }




    public function edit($id)
    {
        $client = ModelsClients::findOrFail($id);
        $this->clientId = $client->id;
        $this->name     = $client->name;
        $this->email    = $client->email;
        $this->phone    = $client->phone;
        $this->editMode = true;
    }

    protected $listeners = ['delete'];
    public function delete($id)
    {
        ModelsClients::findOrFail($id)->delete();
        // session()->flash('message', 'Tarefa deletada com sucesso!');
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Deletado',
            'text' => 'Cliente Deletada com sucesso!',
            'position' => 'center'
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = ModelsClients::where('name', 'like', '%' . $this->search . '%')
            ->where('user_id',auth()->id())
            ->orderBy('name')
            ->paginate(3)
            ->withQueryString(); // <-- Isso mantém a URL base
        // dd($clients);

        return view('livewire.clients', [
            'clients' => $clients
        ]);
    }
}
