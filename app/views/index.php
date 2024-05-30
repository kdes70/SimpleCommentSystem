<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment System</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
        <img src="/path/to/logo.png" alt="Company Logo" class="h-10">
        <h1 class="text-2xl font-bold">Simple SPA Commenting System</h1>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <article class="prose lg:prose-xl mx-auto">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
        <p>Phasellus lacinia interdum magna...</p>
    </article>
    <section class="mt-8">
        <form id="commentForm" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Имя пользователя</label>
                <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Заголовок комментария</label>
                <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-6">
                <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Текст комментария</label>
                <textarea id="comment" name="comment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Добавить комментарий</button>
            </div>
        </form>
    </section>
    <section id="comments" class="mt-8 space-y-4">
        <?php foreach ($comments as $comment): ?>
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($comment->getTitle()) ?></h3>
                <p class="mb-2"><?= htmlspecialchars($comment->getComment()) ?></p>
                <small class="text-gray-500"><?= htmlspecialchars($comment->getUsername()) ?>, <?= htmlspecialchars($comment->getEmail()) ?>, <?= $comment->getCreatedAt()->format('Y-m-d H:i:s') ?></small>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<footer class="bg-white shadow-sm mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-center space-x-4">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
</footer>

<script src="/js/app.js"></script>
</body>
</html>