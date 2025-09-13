<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Controle de Estoque</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Acesse sua conta</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <?php if (isset($_SESSION['erro_login'])): ?>
                    <div class="mb-4 rounded-md bg-red-50 p-4">
                        <p class="text-sm font-medium text-red-800"><?= htmlspecialchars($_SESSION['erro_login']) ?></p>
                        <?php unset($_SESSION['erro_login']); ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-6" action="/login" method="POST">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Endereço de e-mail</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                        </div>
                    </div>

                    <div>
                        <label for="senha" class="block text-sm font-medium leading-6 text-gray-900">Senha</label>
                        <div class="mt-2">
                            <input id="senha" name="senha" type="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300">
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Entrar</button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Não tem uma conta?
                    <a href="/registrar" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Crie uma agora</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>