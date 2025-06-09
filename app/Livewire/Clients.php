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
        'email' => 'email|max:255',
        'phone' => 'required',
    ];

    protected $messages = [
        'name.required'  => 'O nome é obrigatório.',
        'name.string'    => 'O nome deve ser um texto.',
        'name.max'       => 'O nome não pode ultrapassar 255 caracteres.',

        // 'email.required' => 'O e-mail é obrigatório.',
        'email.email'    => 'Informe um e-mail válido.',
        'email.max'      => 'O e-mail não pode ultrapassar 255 caracteres.',

        'phone.required' => 'O telefone é obrigatório.',
        'phone.digits'   => 'O telefone deve conter exatamente 11 dígitos numéricos.',
    ];

    public function save()
    {

        $this->validate();
        // dd($this->phone);

        ModelsClients::updateOrCreate(
            ['id' => $this->clientId], // esse campo deve ser setado no modo de edição
            [
                'user_id' => auth()->id(),
                'name'  => $this->name,
                'email' => $this->email,
                'phone' => $this->phone
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


    public function confirmDelete($id)
    {
        // dd($id);
        // $this->dispatch('confirm', id: $id);
         $this->dispatch('confirm', [
        'id' => $id,
        'action' => 'delete',
        'title' => 'Tem certeza que deseja excluir?',
        'text' => 'Essa ação não poderá ser desfeita!',
        'confirmButtonText' => 'Sim, excluir!',
        'cancelButtonText' => 'Cancelar',
        'icon' => 'warning'
    ]);
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

    public function placeholder()
    {
        return view('livewire.placeholders.loading');
    }

   public function render()
{
    $query = ModelsClients::where('user_id', auth()->id())
                ->orderBy('name');
    
    // Busca mais abrangente e eficiente
    if (!empty($this->search)) {
        $query->where(function($q) {
            $q->where('name', 'like', '%'.$this->search.'%')
              ->orWhere('email', 'like', '%'.$this->search.'%')
              ->orWhere('phone', 'like', '%'.$this->search.'%');
        });
    }
    
    // Seleciona apenas os campos necessários
    $clients = $query->select(['id', 'name', 'email', 'phone', 'created_at'])
               ->paginate($this->perPage ?? 10)
               ->withQueryString();

    return view('livewire.clients', [
        'clients' => $clients
    ])->layout('layouts.default');
}
}
