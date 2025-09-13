<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria - Controle de Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
             <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="/" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Categorias</a>
                                <a href="/produtos" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Produtos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Editar Categoria</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <form action="/categorias/atualizar" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($categoria['id']) ?>">
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="col-span-full">
                                    <label for="nome" class="block text-sm font-medium leading-6 text-gray-900">Nome da Categoria</label>
                                    <div class="mt-2">
                                        <input type="text" name="nome" id="nome" required value="<?= htmlspecialchars($categoria['nome']) ?>" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="descricao" class="block text-sm font-medium leading-6 text-gray-900">Descrição</label>
                                    <div class="mt-2">
                                        <textarea id="descricao" name="descricao" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300"><?= htmlspecialchars($categoria['descricao']) ?></textarea>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-gray-600">Escreva uma breve descrição sobre a categoria.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <a href="/" class="text-sm font-semibold leading-6 text-gray-900">Cancelar</a>
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>