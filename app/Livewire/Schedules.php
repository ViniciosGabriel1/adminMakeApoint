<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Agendamento;
use App\Models\Services as ModelServices;
use App\Models\Clients as ModelClients;
use App\Models\Schedules as ModelSchedules;
use App\Models\Services;
use App\Mail\ScheduleEmail;
use Illuminate\Support\Facades\Mail;
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

    // public function salvar()
    // {

    //     // dd($this->all());
    //     $this->validate();

    //     $show = ModelSchedules::updateOrCreate(
    //         ['id' => $this->agendamentoId],
    //         [
    //             'client_id' => $this->client_id,
    //             'data' => $this->data,
    //             'hora' => $this->hora,
    //             'observacoes' => $this->observacoes,
    //             'valor_total' => $this->total,
    //         ]
    //     )->servicos()->sync($this->servicosSelecionados);

    //     $this->dispatch('alert', [
    //         'icon' => 'success',
    //         'title' => empty($this->agendamentoId) ? 'Cadastrado' : 'Atualizado',
    //         'text'  => empty($this->agendamentoId)
    //             ? 'Agendamento cadastrado com sucesso!'
    //             : 'Agendamento atualizado com sucesso!',
    //     ]);

    //     if (empty($this->agendamentoId)) {
    //         $cliente = $schedule->client; // busca o cliente via relacionamento
    
    //         if ($cliente && $cliente->email) {
    //             $mensagem = "Olá {$cliente->nome}, seu agendamento foi realizado com sucesso para o dia {$this->data} às {$this->hora}.";
    
    //             Mail::to($cliente->email)->send(new ScheduleEmail($mensagem));
    //         }
    //     }

    //     $this->resetForm();
    // }


    public function salvar()
{
    $this->validate();

    $schedule = ModelSchedules::updateOrCreate(
        ['id' => $this->agendamentoId],
        [
            'client_id' => $this->client_id,
            'data' => $this->data,
            'hora' => $this->hora,
            'observacoes' => $this->observacoes,
            'valor_total' => $this->total,
        ]
    );

    $schedule->servicos()->sync($this->servicosSelecionados);

    $this->dispatch('alert', [
        'icon' => 'success',
        'title' => empty($this->agendamentoId) ? 'Cadastrado' : 'Atualizado',
        'text'  => empty($this->agendamentoId)
            ? 'Agendamento cadastrado com sucesso!'
            : 'Agendamento atualizado com sucesso!',
    ]);

    // Envia o e-mail apenas se for novo agendamento
    if (empty($this->agendamentoId)) {
        
        $dataFormatada = \Carbon\Carbon::parse($schedule->data)->format('d/m/Y');
        $horaFormatada = \Carbon\Carbon::parse($schedule->hora)->format('H:i');
        
        $cliente = $schedule->cliente;
        
        if ($cliente && $cliente->email) {
            // Preparar dados para a view
            $emailData = [
                'clienteNome' => $cliente->name,
                'data' => $dataFormatada,
                'hora' => $horaFormatada,
                'servicos' => $schedule->servicos->map(function($servico) {
                    return [
                        'nome' => $servico->title,
                        'preco' => number_format($servico->value, 2, ',', '.')
                    ];
                }),
                'observacoes' => $schedule->observacoes,
                'valorTotal' => number_format($schedule->servicos->sum('value'), 2, ',', '.'),
                'local' => 'Studio Bella Make - Rua das Flores, 123, Sala 302', // Pode ser dinâmico também
                'duracao' => '3 horas' // Calcular com base nos serviços ou pegar do agendamento
            ];

            // dd($emailData);
    
            Mail::to($cliente->email)->send(new ScheduleEmail($emailData));
            
        }
    }

    $this->resetForm();
}

public function confirmDelete($id)
{
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


public function confirmConclusion($id)
{
    $this->dispatch('confirm', [
        'id' => $id,
        'action' => 'conclusion',
        'title' => 'Deseja concluir este agendamento?',
        'text' => 'Após concluir, não será possível editar o agendamento.',
        'confirmButtonText' => 'Sim, concluir!',
        'cancelButtonText' => 'Cancelar',
        'icon' => 'info'
    ]);
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



    protected $listeners = ['delete','conclusion'];

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

    
    public function conclusion($id)
    {
        $schedule = ModelSchedules::findOrFail($id);
        $schedule->status = 'confirmed'; // Define o status como concluído
        $schedule->save();
    
        $this->dispatch('alert', [
            'icon' => 'success',
            'title' => 'Concluído',
            'text' => 'Agendamento concluído com sucesso!',
        ]);
    }
    

    public function resetForm()
    {
        $this->reset([
            'client_id',
            'data',
            'hora',
            'observacoes',
            'servicosSelecionados',
            'valores',
            'agendamentoId',
            'editMode'
        ]);
        $this->valores = [];
        $this->total = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        $schedules = ModelSchedules::with('cliente')->paginate(10);
        //    dd($schedules[0]->data); 

        foreach ($schedules as $schedule) {
            $schedule->data = \Carbon\Carbon::parse($schedule->data)->format('d/m/Y');
        }


        return view('livewire.schedules', [
            'clientes' => ModelClients::where('user_id', auth()->id())->get(),
            'servicos' => ModelServices::where('user_id', auth()->id())->get(),
            'schedules' => $schedules
        ]);
    }
}
