<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Despesas de {{ $deputado->nome }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        .deputado-info-header { display: flex; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .deputado-info-header img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-right: 20px; }
        .deputado-info-header h2 { margin: 0; font-size: 1.8em; color: #007bff; }
        .deputado-info-header p { margin: 5px 0 0; color: #555; }
        .back-link { display: block; text-align: right; margin-bottom: 15px; text-decoration: none; color: #007bff; }
        .back-link:hover { text-decoration: underline; }
        .despesa-item { border: 1px solid #eee; border-radius: 5px; padding: 15px; margin-bottom: 10px; background-color: #f9f9f9; }
        .despesa-item h3 { margin-top: 0; margin-bottom: 10px; color: #333; font-size: 1.1em; }
        .despesa-item p { margin: 5px 0; color: #666; font-size: 0.9em; }
        .despesa-item a { color: #28a745; text-decoration: none; font-weight: bold; }
        .despesa-item a:hover { text-decoration: underline; }
        .no-expenses { text-align: center; color: #888; padding: 20px; }
        .pagination { margin-top: 20px; text-align: center; }
        .pagination ul { list-style: none; padding: 0; display: inline-flex; }
        .pagination li { margin: 0 5px; }
        .pagination li a, .pagination li span { display: block; padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; border-radius: 4px; }
        .pagination li.active span { background-color: #007bff; color: white; border-color: #007bff; }
        .pagination li a:hover:not(.active) { background-color: #f0f0f0; }
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
                <p class="no-expenses">Nenhuma despesa encontrada para este deputado.</p>
            @endforelse
        </div>

        <div class="pagination">
            {{ $despesas->links() }}
        </div>
    </div>
</body>
</html>