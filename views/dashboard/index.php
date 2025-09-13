<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Controle de Estoque</title>
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
                                    <a href="/" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Dashboard</a>
                                    <a href="/categorias" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Categorias</a>
                                    <a href="/produtos" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Produtos</a>
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
                    <h1 class="text-3xl font-bold tracking-tight text-white">Dashboard</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <p class="truncate text-sm font-medium text-gray-500">Total de Produtos</p>
                            <p class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $stats['total_produtos'] ?></p>
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <p class="truncate text-sm font-medium text-gray-500">Itens em Estoque</p>
                            <p class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $stats['total_itens_estoque'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                    <h2 class="text-xl font-semibold leading-7 text-gray-900 mb-4">Últimas Movimentações</h2>
                    <table class="min-w-full divide-y divide-gray-300">
                         <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Produto</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipo</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantidade</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Data</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (empty($stats['ultimos_movimentos'])): ?>
                                <tr><td colspan="4" class="py-4 text-center text-gray-500">Nenhuma movimentação registrada.</td></tr>
                            <?php else: ?>
                                <?php foreach ($stats['ultimos_movimentos'] as $movimento): ?>
                                    <tr>
                                        <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900"><?= htmlspecialchars($movimento['nome_produto']) ?></td>
                                        <td class="px-3 py-4 text-sm">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?= $movimento['tipo'] === 'entrada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= htmlspecialchars(ucfirst($movimento['tipo'])) ?>
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500"><?= htmlspecialchars($movimento['quantidade']) ?></td>
                                        <td class="px-3 py-4 text-sm text-gray-500"><?= date('d/m/Y H:i', strtotime($movimento['data_movimento'])) ?></td>
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