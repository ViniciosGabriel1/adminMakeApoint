<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Confirmação de Agendamento</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fff1f2;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #fecdd3;
        }

        .header {
            background-color: #e11d48;
            padding: 40px 30px 20px;
            text-align: center;
            color: #ffffff;
        }

        .logo-img {
            max-width: 160px;
            height: auto;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 26px;
            margin: 10px 0 0;
        }

        .content {
            padding: 35px 30px;
        }

        .content p {
            margin: 0 0 18px;
            font-size: 16px;
        }

        .highlight {
            color: #e11d48;
            font-weight: 600;
        }

        .details {
            background-color: #fff0f3;
            padding: 25px;
            border-left: 5px solid #e11d48;
            border-radius: 10px;
            margin: 30px 0;
        }

        .details-item {
            display: flex;
            margin-bottom: 15px;
        }

        .details-label {
            font-weight: 600;
            color: #9f1239;
            width: 140px;
        }

        .details-value {
            flex: 1;
        }

        .service-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .service-item {
            padding: 6px 0;
            border-bottom: 1px dashed #fda4af;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .total {
            margin-top: 12px;
            font-size: 16px;
            font-weight: bold;
            color: #9f1239;
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
            <!-- Substitua a URL abaixo pela URL real da sua imagem -->
            <img src="{{ Vite::asset('resources/images/Gleyce.png') }}" alt="Fulana MakeUp" class="logo-img" />
            {{-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAAH0CAYAAADL1t+KAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAErGlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSfvu78nIGlkPSdXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQnPz4K... --}}
" alt="Fulana MakeUp" class="logo-img" style="max-width: 120px; display: block; margin: 0 auto;">


            <h1>Confirmação de Agendamento</h1>
        </div>

        <div class="content">
            <p>Olá <span class="highlight">{{ $data['clienteNome'] }}</span>,</p>

            <p>Estamos felizes em informar que seu agendamento foi realizado com sucesso! Abaixo estão todos os
                detalhes:</p>

            <div class="details">
                <div class="details-item">
                    <div class="details-label">Nome:</div>
                    <div class="details-value">{{ $data['clienteNome'] }}</div>
                </div>
                <div class="details-item">
                    <div class="details-label">Serviços:</div>
                    <div class="details-value">
                        <ul class="service-list">
                            @foreach ($data['servicos'] as $servico)
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
                <div class="details-item">
                    <div class="details-label">Observações:</div>
                    <div class="details-value">{{ $data['observacoes'] }}</div>
                </div>
            </div>

            <p>Por favor, caso precise reagendar ou cancelar, pedimos que nos avise com pelo menos 24 horas de
                antecedência.</p>

            <p>Atenciosamente,<br><strong>Fulana</strong></p>
        </div>

        <div class="footer">
            © {{ date('Y') }} FulanaMakeUp - Todos os direitos reservados<br>
            aaalgum local -MG<br>
            (11) 98765-4321 | contato@FUlanaMake.com.br
        </div>
    </div>
</body>

</html>
