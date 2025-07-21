<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despesas de {{ $deputado->nome }}</title>
    <link rel="icon" type="image/png" href="/favicon.ico"> 
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f4f4f4; 
            display: flex; 
            justify-content: center; 
            min-height: 90vh; 
            align-items: flex-start; 
        }
        .container { 
            max-width: 900px; 
            width: 100%; 
            margin: 20px auto; 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1); 
        }
        h1 { 
            text-align: center; 
            color: #333; 
            margin-bottom: 20px; 
        }
        .deputado-info-header { 
            display: flex; 
            align-items: center; 
            margin-bottom: 20px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 15px; 
        }
        .deputado-info-header img { 
            width: 100px; 
            height: 100px; 
            border-radius: 50%; 
            object-fit: cover; 
            margin-right: 20px; 
            border: 2px solid #007bff; /* Borda colorida na imagem */
        }
        .deputado-info-header h2 { 
            margin: 0; 
            font-size: 1.8em; 
            color: #007bff; 
        }
        .deputado-info-header p { 
            margin: 5px 0 0; 
            color: #555; 
        }
        .back-link { 
            display: inline-block; /* Para o botão de voltar */
            margin-bottom: 15px; 
            text-decoration: none; 
            color: #007bff; 
            padding: 8px 15px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .back-link:hover { 
            background-color: #007bff; 
            color: white; 
            text-decoration: none; 
        }
        .filter-form {
            display: flex;
            gap: 10px; /* Espaço entre os elementos do formulário */
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f0f8ff; /* Cor de fundo suave para o formulário */
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            flex-wrap: wrap; /* Permite que os elementos quebrem linha em telas pequenas */
            justify-content: center; /* Centraliza os itens */
            align-items: center;
        }
        .filter-form label {
            font-weight: bold;
            color: #333;
            margin-right: 5px;
        }
        .filter-form select, .filter-form button {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.95em;
            cursor: pointer;
        }
        .filter-form button {
            background-color: #28a745; /* Cor verde para o botão de filtro */
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }
        .filter-form button:hover {
            background-color: #218838;
        }
        .despesa-item { 
            border: 1px solid #eee; 
            border-radius: 5px; 
            padding: 15px; 
            margin-bottom: 10px; 
            background-color: #f9f9f9; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); /* Sombra suave para os cards */
            transition: transform 0.2s ease; /* Efeito de hover nos cards */
        }
        .despesa-item:hover {
            transform: translateY(-3px); /* Leve levantamento no hover */
        }
        .despesa-item h3 { 
            margin-top: 0; 
            margin-bottom: 10px; 
            color: #333; 
            font-size: 1.1em; 
        }
        .despesa-item p { 
            margin: 5px 0; 
            color: #666; 
            font-size: 0.9em; 
        }
        .despesa-item a { 
            color: #28a745; 
            text-decoration: none; 
            font-weight: bold; 
        }
        .despesa-item a:hover { 
            text-decoration: underline; 
        }
        .no-expenses { 
            text-align: center; 
            color: #888; 
            padding: 20px; 
            font-style: italic;
        }

        /* Estilos da Paginação (repetidos aqui para garantir que funcionem na view de despesas) */
        .pagination { 
            margin-top: 30px; 
            text-align: center; 
            display: flex; 
            justify-content: center;
            flex-wrap: wrap; 
        }
        .pagination ul { 
            list-style: none; 
            padding: 0; 
            display: flex; 
            flex-wrap: wrap;
            justify-content: center;
            margin: 0; 
        }
        .pagination li { 
            margin: 0 4px; 
        }
        .pagination li a, 
        .pagination li span { 
            display: block; 
            padding: 8px 12px; 
            border: 1px solid #ddd; 
            text-decoration: none; 
            color: #007bff; 
            border-radius: 4px; 
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        .pagination li.active span { 
            background-color: #007bff; 
            color: white; 
            border-color: #007bff; 
            font-weight: bold;
        }
        .pagination li a:hover:not(.active) { 
            background-color: #e9ecef; 
            color: #0056b3;
            border-color: #0056b3;
        }
        .pagination .disabled span {
            color: #6c757d; 
            cursor: not-allowed; 
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('deputados.index') }}" class="back-link">&larr; Voltar para a lista de Deputados</a>

        <div class="deputado-info-header">
            <img src="{{ $deputado->url_foto }}" alt="Foto de {{ $deputado->nome }}">
            <div>
                <h2>Despesas de {{ $deputado->nome }}</h2>
                <p>Partido: {{ $deputado->sigla_partido }}</p>
            </div>
        </div>

        <!-- Formulário de Filtro por Ano e Mês -->
        <form action="{{ route('deputados.despesas', $deputado->id) }}" method="GET" class="filter-form">
            <label for="year">Ano:</label>
            <select name="year" id="year">
                <option value="">Todos</option> {{-- Opção para não filtrar por ano --}}
                @foreach ($availableYears as $y)
                    <option value="{{ $y }}" {{ (string)$y === (string)$year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>

            <label for="month">Mês:</label>
            <select name="month" id="month">
                <option value="">Todos</option> {{-- Opção para não filtrar por mês --}}
                @php
                    $meses = [
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                        5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                    ];
                @endphp
                @foreach ($meses as $num => $nome)
                    <option value="{{ $num }}" {{ (string)$num === (string)$month ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>

            <button type="submit">Filtrar Despesas</button>
        </form>

        <h3>Lista de Despesas</h3>

        <div class="despesas-list">
            @forelse ($despesas as $despesa)
                <div class="despesa-item">
                    <h3>{{ $despesa->tipo_despesa }}</h3>
                    <p><strong>Valor:</strong> R$ {{ number_format($despesa->valor_documento, 2, ',', '.') }}</p>
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($despesa->data_documento)->format('d/m/Y') }}</p>
                    <p><strong>Fornecedor:</strong> {{ $despesa->nome_fornecedor }}</p>
                    @if ($despesa->url_documento)
                        <p><a href="{{ $despesa->url_documento }}" target="_blank">Ver Documento</a></p>
                    @endif
                </div>
            @empty
                <p class="no-expenses">Nenhuma despesa encontrada para este deputado com os filtros selecionados.</p>
            @endforelse
        </div>

        <!-- Links de Paginação -->
        {{ $despesas->links() }}
    </div>
</body>
</html>