<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos - Controle de Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        <div class="bg-gray-800 pb-32">
            <nav class="bg-gray-800">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center">
                            <div class="hidden md:block">
                                <div class="ml-10 flex items-baseline space-x-4">
                                    <a href="/" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Categorias</a>
                                    <a href="/produtos" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Produtos</a>
                                    <a href="/movimentos" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Movimentações</a>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-4 flex items-center md:ml-6">
                                <?php if (isset($_SESSION['usuario_nome'])): ?>
                                    <span class="text-gray-400 mr-4">Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>
                                    <form action="/logout" method="POST">
                                        <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                                            Sair
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">Produtos</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold leading-7 text-gray-900">Lista de Produtos</h2>
                        <a href="/produtos/novo" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Cadastrar Novo Produto
                        </a>
                    </div>
                    
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nome</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">SKU</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Preço</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantidade</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Categoria</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Ações</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php if (empty($produtos)): ?>
                                <tr>
                                    <td colspan="6" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">Nenhum produto cadastrado.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= htmlspecialchars($produto['nome']) ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($produto['sku']) ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($produto['quantidade']) ?></td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($produto['nome_categoria'] ?? 'Sem Categoria') ?></td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex items-center justify-end">
                                            <a href="/produtos/editar?id=<?= $produto['id'] ?>" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="/produtos/excluir" method="POST" class="inline" onsubmit="return confirm('Você tem certeza que deseja excluir este produto?');">
                                                <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                                    Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>