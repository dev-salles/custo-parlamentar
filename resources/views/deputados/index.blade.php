<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deputados</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .deputado-card { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 15px; padding: 10px; background-color: #fff; }
        .deputado-card img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 15px; }
        .deputado-info h2 { margin: 0; font-size: 1.2em; color: #007bff; }
        .deputado-info p { margin: 5px 0; color: #555; }
        .deputado-info a { text-decoration: none; color: #007bff; font-weight: bold; }
        .deputado-info a:hover { text-decoration: underline; }
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
        <h1>Lista de Deputados Federais</h1>

        <div class="deputados-list">
            @forelse ($deputados as $deputado)
                <div class="deputado-card">
                    <img src="{{ $deputado->url_foto }}" alt="Foto de {{ $deputado->nome }}">
                    <div class="deputado-info">
                        <h2>{{ $deputado->nome }}</h2>
                        <p>Partido: {{ $deputado->sigla_partido }}</p>
                        <a href="{{ route('deputados.despesas', $deputado->id) }}">Ver Despesas</a>
                    </div>
                </div>
            @empty
                <p>Nenhum deputado encontrado.</p>
            @endforelse
        </div>

        <div class="pagination">
            {{ $deputados->links() }}
        </div>
    </div>
</body>
</html>