<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Link para o favicon -->
    <link rel="icon" type="image/png" href="/favicon.ico"> 
    
    <title>Custo Parlamentar - Câmara dos Deputados</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Estilos personalizados que não são facilmente substituíveis pelo Tailwind, ou para overrides */
        body { 
            font-family: Arial, sans-serif; 
        }
        /* O restante dos estilos que eram para .container, .deputado-card, etc., 
           serão substituídos por classes Tailwind diretamente no HTML.
           Mantenho alguns aqui para referência, mas o ideal é que tudo seja Tailwind. */

        /* Estilos específicos para o card do deputado, se não puder ser 100% Tailwind */
        .deputado-card img { 
            object-fit: cover; 
        }
    </style>
</head>
<body class="bg-gray-100 p-5 flex justify-center items-start min-h-screen">
    <div class="container max-w-4xl w-full mx-auto bg-white p-6 rounded-lg shadow-lg mt-5">
        <!-- Título em negrito e centralizado com Tailwind -->
        <h1 class="text-3xl text-gray-800 font-bold text-center mb-8">Lista de Deputados Federais</h1>

        <!-- Barra de pesquisa com Tailwind -->
        <div class="search-bar flex justify-center mb-6">
            <form action="{{ route('deputados.index') }}" method="GET" class="flex w-full max-w-2xl">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Pesquisar por nome..." 
                    value="{{ request('search') }}"
                    class="flex-grow p-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                >
                <button 
                    type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 transition duration-300 ease-in-out text-lg"
                >
                    Buscar
                </button>
            </form>
        </div>

        <div class="deputados-list">
            @forelse ($deputados as $deputado)
                <div class="deputado-card flex items-center border border-gray-200 rounded-lg mb-4 p-4 bg-white shadow-sm hover:shadow-md transition duration-200 ease-in-out transform hover:-translate-y-1">
                    <img 
                        src="{{ $deputado->url_foto }}" 
                        alt="Foto de {{ $deputado->nome }}"
                        class="w-20 h-20 rounded-full mr-4 border-2 border-blue-500"
                    >
                    <div class="deputado-info">
                        <h2 class="text-xl text-blue-600 font-semibold mb-1">{{ $deputado->nome }}</h2>
                        <p class="text-gray-600 text-base mb-2">Partido: {{ $deputado->sigla_partido }}</p>
                        <a 
                            href="{{ route('deputados.despesas', $deputado->id) }}"
                            class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 transition duration-300 ease-in-out"
                        >
                            Ver Despesas
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600 italic p-5">Nenhum deputado encontrado.</p>
            @endforelse
        </div>

        <!-- Links de Paginação (serão estilizados pelo Tailwind via Paginator::useTailwind()) -->
        <div class="mt-8 flex justify-center">
            {{ $deputados->links() }}
        </div>

    </div>
</body>
</html>