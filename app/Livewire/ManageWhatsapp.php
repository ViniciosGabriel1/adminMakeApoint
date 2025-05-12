<?php

namespace App\Livewire;

use App\Models\WhatsappInstance;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ManageWhatsapp extends Component
{

    public $phoneNumber;
    public $instanceId;
    public $qrCode;
    public $status;
    public $last_updated;



    public function connect()
    {
        $serverUrl = env('WHATSAPP_SERVER_URL'); // Ex: https://api.exemplo.com

        $this->status = 'connecting';
        // dd($phoneNumber);
        $payload = json_encode([
            'instanceName'     => auth()->user()->name . auth()->user()->phone,
            'number'           => auth()->user()->phone, // <- aqui            'qrcode'           => true,
            'integration'      => 'WHATSAPP-BAILEYS',
            'reject_call'      => true,
            'msgCall'          => 'Ligações não são permitidas',
            'groupsIgnore'     => true,
            'alwaysOnline'     => true,
            'readMessages'     => true,
            'readStatus'       => true,
            'syncFullHistory'  => true,
            'webhook' => [
                'url' => 'https://3a7b-2804-3124-800c-cfa0-19f7-54e1-32d3-3598.ngrok-free.app/api/webhook/baileys',
                'byEvents'  => false,
                'base64'    => true,
                'headers'   => [
                    'autorization' => 'Bearer TOKEN',
                    'Content-Type' => 'application/json',
                ],
                'events'    => [
                    // 'APPLICATION_STARTUP',
                    'QRCODE_UPDATED',
                    'CONNECTION_UPDATE'
                ],
            ],

        ]);

        // $url = "{$serverUrl}/instance/create";
        // dd($url);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('WHATSAPP_URL_CREATE_INSTANCE'),
            // CURLOPT_URL => "http://localhost:8080/message/sendText/Vini",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "apikey: 429683C4C977415CAAFCCE10F7D57E11",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->status = 'error';
            // opcional: log do erro
            // \Log::error("Erro no cURL: " . $err);
        } else {
            // dd('aqui');
            $data = json_decode($response, true);
            // dd(auth()->id());
            // dd($this->phoneNumber);
            $instance = WhatsappInstance::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'user_id'        => auth()->id(), // ← garanta isso aqui
                    'instance_name'  => $data['instance']['instanceName'] ?? null,
                    'status'         => $data['instance']['status'] ?? 'connecting',
                    'status_reason'  => $data['statusReason'] ?? null,
                    'sender'         => $sender ?? null,
                    'number'         => auth()->user()->phone,
                    'last_event'     => json_encode($data),
                    'last_event_at'  => now(),
                ]
            );


            if (isset($data['qrcode']['base64']) && is_string($data['qrcode']['base64'])) {
                $this->qrCode = $data['qrcode']['base64'];  // Atribua o valor base64
                // dd($this->qrCodeUrl);

                $this->status = 'waiting';
                $this->dispatch('qrCodeGenerated', qrCode: $this->qrCode);
            } else {
                $this->status = 'error';
            }
        }
    }

    public function getQRCode()
    {
        $serverUrl = 'http://localhost:8080'; // Ex: https://api.exemplo.com
        $instance = auth()->user()->name . auth()->user()->phone ?? 'default-instance'; // ou defina como preferir

        $url = "{$serverUrl}/instance/connect/{$instance}";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "apikey: 429683C4C977415CAAFCCE10F7D57E11",
            ],
        ]);

        $response = curl_exec($curl);
        // dd($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Log::error("Erro no cURL (getQRCode): " . $err);
            session()->flash('error', 'Erro ao buscar o QR Code.');
        } else {
            $data = json_decode($response, true);
            // dd($data);
            if (isset($data['base64'])) {
                $this->qrCode = $data['base64'];
                session()->flash('success', 'QR Code obtido com sucesso.');
            } else {
                Log::error("Resposta sem QR Code: " . $response);
                session()->flash('error', 'QR Code não encontrado na resposta.');
            }
        }
    }

    public function mount()
    {
        $instance = WhatsappInstance::where('user_id', auth()->id())->first();
        if (!$instance) {
            try {
                $this->connect();
            } catch (\Exception $e) {
                Log::error("Erro ao conectar instância automática: " . $e->getMessage());
                $this->status = 'error';
            }
        } else {
            $this->status = $instance->status;
            $this->phoneNumber = (string) $instance->number;
            $this->last_updated = $instance->updated_at;

            $decoded = json_decode($instance->last_event);
            $this->qrCode = $decoded->qrcode->base64 ?? null;
        }
    }

    public function disconnect()
    {
        $serverUrl = 'http://localhost:8080'; // Ex: https://api.exemplo.com
        $instance = auth()->user()->name . auth()->user()->phone ?? 'default-instance'; // ou defina como preferir

        $url = "{$serverUrl}/instance/logout/{$instance}";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                "apikey: 429683C4C977415CAAFCCE10F7D57E11",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            session()->flash('error', "Erro ao desconectar: $err");
        } else {
            session()->flash('success', 'Desconectado com sucesso.');
        }
    }





    //     public function checkConnectionStatus()
    // {
    //     $instance = auth()->user()->name . $this->phoneNumber;
    //     $status = Cache::get("whatsapp_connection_status_{$instance}");

    //     if ($status === 'open') {
    //         $this->status = 'connected';
    //     } elseif ($status === 'close') {
    //         $this->status = 'disconnected';
    //     }
    // }


    public function render()
    {
        return view('livewire.manage-whatsapp');
    }
}
