<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Agendamento;
use App\Models\Services as ModelServices;
use App\Models\Clients as ModelClients;
use App\Models\Schedules as ModelSchedules;
use App\Models\Services;
use Livewire\WithPagination;

class Schedules extends Component
{
    use WithPagination;

    public $client_id, $data, $hora, $observacoes;
    public $servicosSelecionados = [];
    public $valores = [];
    public $total = 0;
    public $agendamentoId;
    public $editMode = false;


    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'data' => 'required|date|after_or_equal:today',
        'hora' => 'required|date_format:H:i',
        'observacoes' => 'nullable|string',
        'servicosSelecionados' => 'required|array|min:1',
        'servicosSelecionados.*' => 'required|exists:services,id',
    ];

    protected $messages = [
        'client_id.required' => 'Selecione um cliente.',
        'data.after_or_equal' => 'A data deve ser hoje ou futura.',
        'servicosSelecionados.required' => 'Adicione pelo menos um serviço.',
        'servicosSelecionados.*.exists' => 'Serviço inválido selecionado.'
    ];

    public function mount()
    {
        $this->adicionarServico(); // inicia com um serviço selecionável
    }

    public function adicionarServico()
    {
        $this->servicosSelecionados[] = null;
        $this->valores[] = 0;
    }

    public function removerServico($index)
    {
        unset($this->servicosSelecionados[$index], $this->valores[$index]);
        $this->servicosSelecionados = array_values($this->servicosSelecionados);
        $this->valores = array_values($this->valores);
        $this->recalcularTotal();
    }


    public function atualizarValor($index)
    {
        $id = $this->servicosSelecionados[$index] ?? null;
    
        if (!$id) return;
    
        $servico = Services::find($id);
        $this->valores[$index] = $servico?->value ?? 0;
    
        $this->recalcularTotal();
    }
    

    public function recalcularTotal()
    {
        $this->total = array_sum($this->valores);
    }

    public function salvar()
    {

        // dd($this->all());
        $this->validate();

        ModelSchedules::updateOrCreate(
            ['id' => $this->agendamentoId],
            [
                'client_id' => $this->client_id,
                'data' => $this->data,
                'hora' => $this->hora,
                'observacoes' => $this->observacoes,
                'valor_total' => $this->total,
            ]
        )->servicos()->sync($this->servicosSelecionados);

        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => empty($this->agendamentoId) ? 'Cadastrado' : 'Atualizado',
            'text'  => empty($this->agendamentoId)
                ? 'Agendamento cadastrado com sucesso!'
                : 'Agendamento atualizado com sucesso!',
        ]);

        $this->resetForm();
    }
    public function confirmDelete($id) {

        $this->dispatch('confirm', id: $id);
    }


    public function edit($id)
    {
        $agendamento = ModelSchedules::with('servicos')->findOrFail($id);
        $this->agendamentoId = $agendamento->id;
        $this->client_id = $agendamento->client_id;
        $this->data = $agendamento->data;
        $this->hora = \Carbon\Carbon::parse($agendamento->hora)->format('H:i');
        
        $this->observacoes = $agendamento->observacoes;
        $this->servicosSelecionados = $agendamento->servicos->pluck('id')->toArray();
        $this->valores = $agendamento->servicos->pluck('value')->toArray();
        $this->recalcularTotal();
        $this->editMode = true;
    }



    protected $listeners = ['delete'];

    public function delete($id)
    {
        // dd($id);
        ModelSchedules::findOrFail($id)->delete();

        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Deletado',
            'text' => 'Agendamento deletado com sucesso!',
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'client_id', 'data', 'hora', 'observacoes',
            'servicosSelecionados', 'valores', 'agendamentoId', 'editMode'
        ]);
        $this->valores = [];
        $this->total = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        $show = ModelSchedules::with('cliente')->paginate(10);
    //    dd($show[0]->data); 

    foreach ($show as $schedule) {
        $schedule->data = \Carbon\Carbon::parse($schedule->data)->format('d/m/Y');
    }
    

        return view('livewire.schedules', [
            'clientes' => ModelClients::where('user_id',auth()->id())->get(),
            'servicos' => ModelServices::where('user_id',auth()->id())->get(),
            'schedules' => $show
        ]);
    }
}
