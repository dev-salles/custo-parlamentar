<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.ico"> 
    <title>Custo Parlamentar - Câmara dos Deputados</title>   
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body { 
            font-family: Arial, sans-serif; 
        }

        .deputado-card img { 
            object-fit: cover; 
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100"> 
    <div class="flex-grow flex justify-center items-start pt-5 pb-5"> 
        <div class="container max-w-4xl w-full mx-auto bg-white p-6 rounded-lg shadow-lg"> 
            <h1 class="text-3xl text-gray-800 font-bold text-center mb-8">Lista de Deputados Federais</h1>

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
                        class="px-6 py-3 bg-green-700 text-white rounded-r-md hover:bg-green-500 transition duration-400 ease-in-out text-lg"
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

            <div class="mt-8 flex justify-center">
                {{ $deputados->links() }}
            </div>

        </div>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center w-full">
                <p>Desenvolvido por <a href="https://www.linkedin.com/in/thesalles/">Davi Sales Barcelos</a> <br>&copy; {{ date('Y') }} Custo Parlamentar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>