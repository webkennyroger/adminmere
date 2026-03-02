<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 500 | Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-zinc-900">
    @php
        $currentYear = date('Y');
    @endphp
    <div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">
        <!-- Centered Content -->
        <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
            <h1 class="mb-8 font-bold text-zinc-800 text-4xl dark:text-white/90">
                ERROR 500
            </h1>

            <p class="mt-10 mb-6 text-base text-zinc-700 dark:text-zinc-400 sm:text-lg">
                Ocorreu um erro interno no servidor.
            </p>

            <a href="/"
                class="inline-flex items-center justify-center rounded-lg border border-zinc-300 bg-white px-5 py-3.5 text-sm font-medium text-zinc-700 shadow-md hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white/[0.03] dark:hover:text-zinc-200">
                Voltar à página inicial
            </a>
        </div>
        <!-- Footer -->
        <p class="absolute text-sm text-center text-zinc-500 -translate-x-1/2 bottom-6 left-1/2 dark:text-zinc-400">
            &copy; {{ $currentYear }} - Mere App
        </p>
    </div>
</body>

</html>