<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lembrete de Agendamentos</title>
  <style>

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff1f2;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      max-width: 700px;
      margin: auto;
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      border: 1px solid #fecdd3;
      overflow: hidden;
    }

    .header {
      background-color: #e11d48;
      color: #fff;
      padding: 35px 30px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
    }

    .logo {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .content {
      padding: 30px;
    }

    .agendamento {
      border-left: 5px solid #e11d48;
      background-color: #fff0f3;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .agendamento p {
      margin: 8px 0;
    }

    .servicos {
      margin-top: 10px;
    }

    .servicos ul {
      list-style: none;
      padding-left: 0;
    }

    .servicos li {
      border-bottom: 1px dashed #fda4af;
      padding: 5px 0;
    }

    .footer {
      background-color: #fecdd3;
      text-align: center;
      padding: 18px;
      font-size: 13px;
      color: #9f1239;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div class="logo">Fulana MakeUp</div>
      <h1>Seus Agendamentos de Hoje</h1>
    </div>
    <div class="content">
      <p>Olá Gleyce,</p>
      <p>Aqui estão os agendamentos do dia <strong>{{ $data['data'] }}</strong>:</p>

      @foreach($data['agendamentos'] as $agendamento)
      <div class="agendamento">
        <p><strong>Cliente:</strong> {{ $agendamento['cliente_nome'] }}</p>
        <p><strong>Horário:</strong> {{ $agendamento['hora'] }}</p>
        <p><strong>Observações:</strong> {{ $agendamento['observacoes'] ?? 'Nenhuma' }}</p>

        <div class="servicos">
          <strong>Serviços:</strong>
          <ul>
            @foreach($agendamento['servicos'] as $servico)
            <li>{{ $servico['nome'] }} - R$ {{ $servico['preco'] }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      @endforeach

      <p>Tenha um ótimo dia de atendimentos! ✨</p>
      <p><strong>AgendaShow</strong></p>
    </div>

    <div class="footer">
      © {{ date('Y') }} FulanaMakeUp - Todos os direitos reservados<br>
      aaalgum local - MG<br>
      (11) 98765-4321 | contato@fulanamake.com.br
    </div>
  </div>
</body>
</html>
