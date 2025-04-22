<?php

namespace App\Livewire;

use App\Models\Services as ModelsServices;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{

    use WithPagination; // Habilita a paginação


    public $title, $value, $description, $serviceId;
    public $search = '';
    public $editMode = false;

    // Regras de validação
    protected $rules = [
        'title'       => 'required|string|max:255',
        'value'       => 'required|numeric|min:0',
        'description' => 'nullable|string|max:1000',
    ];


    public function save()
    {
        $this->validate();

        ModelsServices::updateOrCreate(
            ['id' => $this->serviceId], // usado no modo de edição
            [
                'user_id'     => auth()->id(), // garante que o serviço pertence à maquiadora logada
                'title'       => $this->title,
                'value'       => $this->value,
                'description' => $this->description,
            ]
        );

        $this->dispatch('alert', [
            'icon'     => 'success',
            'title'    => empty($this->serviceId) ? 'Cadastrado' : 'Atualizado',
            'text'     => empty($this->serviceId)
                ? 'Serviço cadastrado com sucesso!'
                : 'Serviço atualizado com sucesso!',
            'position' => 'center',
        ]);

        $this->resetForm();
    }


    public function resetForm()
    {
        $this->reset(['title', 'value', 'description', 'serviceId', 'editMode']);
        $this->resetErrorBag();
    }

    public function confirmDelete($id)
    {

        $this->dispatch('confirm', ClientId: $id);
    }




    public function edit($id)
    {
        $service = ModelsServices::findOrFail($id);

        $this->serviceId  = $service->id;
        $this->title      = $service->title;
        $this->value      = $service->value;
        $this->description = $service->description;
        $this->editMode   = true;
    }

    protected $listeners = ['delete'];
    public function delete($id)
    {
        ModelsServices::findOrFail($id)->delete();
        // session()->flash('message', 'Tarefa deletada com sucesso!');
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Deletado',
            'text' => 'Serviço Deletado com sucesso!',
            'position' => 'center'
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        // return view('livewire.services');

        $services = ModelsServices::where('title', 'like', '%' . $this->search . '%')
            ->where('user_id',auth()->id())
            ->orderBy('title')
            ->paginate(3)
            ->withQueryString(); // <-- Isso mantém a URL base
        // dd($services);

        return view('livewire.services', [
            'services' => $services
        ]);
    }
}
