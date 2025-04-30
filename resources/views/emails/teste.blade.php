<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Agendamento</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff1f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #e11d48;
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .details {
            background-color: #fecdd3;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .details-item {
            margin-bottom: 15px;
            display: flex;
        }
        .details-label {
            font-weight: bold;
            color: #9f1239;
            width: 120px;
            flex-shrink: 0;
        }
        .details-value {
            flex: 1;
        }
        .service-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .service-item {
            padding: 8px 0;
            border-bottom: 1px dashed #fb7185;
        }
        .service-item:last-child {
            border-bottom: none;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #fecdd3;
            font-size: 14px;
            color: #9f1239;
        }
        .button {
            display: inline-block;
            background-color: #e11d48;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: bold;
            margin-right: 10px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
        .highlight {
            color: #e11d48;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            color: #9f1239;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Bella Make</div>
            <h1>Confirmação de Agendamento</h1>
        </div>
        
        <div class="content">
            <p>Olá <span class="highlight">{{ $data['clienteNome'] }}</span>,</p>
            
            <p>Estamos felizes em informar que seu agendamento foi realizado com sucesso! Abaixo estão todos os detalhes:</p>
            
            <div class="details">
                <div class="details-item">
                    <div class="details-label">Nome:</div>
                    <div class="details-value">{{ $data['clienteNome'] }}</div>
                </div>
                <div class="details-item">
                    <div class="details-label">Serviços:</div>
                    <div class="details-value">
                        <ul class="service-list">
                            @foreach($data['servicos'] as $servico)
                            <li class="service-item">{{ $servico['nome'] }} (R$ {{ $servico['preco'] }})</li>
                            @endforeach
                        </ul>
                        <div class="total">Valor Total: R$ {{ $data['valorTotal'] }}</div>
                    </div>
                </div>
                <div class="details-item">
                    <div class="details-label">Data:</div>
                    <div class="details-value">{{ $data['data'] }}</div>
                </div>
                <div class="details-item">
                    <div class="details-label">Horário:</div>
                    <div class="details-value">{{ $data['hora'] }}</div>
                </div>
              
            </div>
            
            <p>Por favor, chegue com 10 minutos de antecedência. Caso precise reagendar ou cancelar, pedimos que nos avise com pelo menos 24 horas de antecedência.</p>
                        
            <p>Atenciosamente,<br>
            <strong>Equipe Murrinha</strong></p>
            
        </div>
        
        <div class="footer">
            © {{ date('Y') }} MurrinhaMake - Todos os direitos reservados<br>
            Rua das Flores, 123 - São Paulo/SP<br>
            (11) 98765-4321 | contato@murrinhaMake.com.br
        </div>
    </div>
</body>
</html>