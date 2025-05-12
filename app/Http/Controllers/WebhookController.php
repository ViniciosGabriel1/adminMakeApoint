<?php

namespace App\Http\Controllers;

use App\Models\WhatsappInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        if (
            $request->input('event') === 'connection.update' &&
            $request->input('data.state') === 'open'
        ) {
            Log::info('Conexão realizada com sucesso!');
            Log::info($request->all());

            // Atualizando o status da instância para 'open'
            $instance = WhatsappInstance::where('instance_name', $request['instance'])->first();
            Log::info("INSTANCIA ->" . $instance);
            if ($instance) {
                $instance->update([
                    'status' => 'open',
                ]);
            }
        } else if (
            $request->input('event') === 'connection.update' &&
            $request->input('data.state') === 'close'
        ) {
            Log::info('Conexão desconectada com sucesso!');

            // Atualizando o status da instância para 'close'
            $instance = WhatsappInstance::where('instance_name', $request['instance'])->first();

            if ($instance) {
                $instance->update([
                    'status' => 'close',
                    'status_reason' => $request->input('data.statusReason') ?? null,
                ]);
            }
        }


        return response()->json(['success' => true]);
    }
}
