<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações de Estoque</title>
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
                                <a href="/" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Dashboard</a>
                                <a href="/categorias" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Categorias</a>
                                <a href="/produtos" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Produtos</a>
                                <a href="/movimentos" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Movimentações</a>
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
        <header class="bg-white shadow-sm">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <h1 class="text-lg font-semibold leading-6 text-gray-900">Movimentações de Estoque</h1>
            </div>
        </header>
        <main class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="mb-8 rounded-lg bg-white p-6 shadow">
                <h2 class="text-xl font-semibold mb-4">Registrar Nova Movimentação</h2>
                <?php if (isset($erro)): ?>
                    <div class="mb-4 rounded-md bg-red-50 p-4">
                        <p class="text-sm font-medium text-red-800"><?= htmlspecialchars($erro) ?></p>
                    </div>
                <?php endif; ?>
                <form action="/movimentos" method="POST" class="grid grid-cols-1 gap-6 sm:grid-cols-4">
                    <div class="sm:col-span-2">
                        <label for="produto_id" class="block text-sm font-medium text-gray-700">Produto</label>
                        <select id="produto_id" name="produto_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Selecione um produto</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto['id'] ?>"><?= htmlspecialchars($produto['nome']) ?> (Estoque: <?= $produto['quantidade'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select id="tipo" name="tipo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                        <input type="number" name="quantidade" id="quantidade" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div class="sm:col-span-4 flex justify-end">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Registrar</button>
                    </div>
                </form>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <h2 class="text-xl font-semibold mb-4">Histórico</h2>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Produto</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipo</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Quantidade</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (empty($movimentos)): ?>
                            <tr><td colspan="4" class="py-4 text-center text-gray-500">Nenhuma movimentação registrada.</td></tr>
                        <?php else: ?>
                            <?php foreach ($movimentos as $movimento): ?>
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
        </main>
    </div>
</body>
</html>