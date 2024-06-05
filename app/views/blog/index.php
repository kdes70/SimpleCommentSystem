<?php $view->extend('layouts/main', ['title' => 'The Perfect Weekend Getaway']) ?>

<?php $view->start('styles') ?>
    <style>
        /* Custom styles here */
    </style>
<?php $view->stop() ?>

<?php $view->start('content') ?>
    <header class="bg-white shadow-sm py-4">
        <!-- Header content -->
    </header>

    <main class="container mx-auto py-8">
        <article class="max-w-3xl mx-auto">
            <!-- Blog post content -->
        </article>

        <div class="max-w-3xl mx-auto mt-16">
            <h2 class="text-2xl font-bold mb-4">Comments</h2>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form id="comment-form">
                    <!-- Comment form fields -->
                </form>
            </div>

            <div id="comments-list" class="bg-white rounded-lg shadow-md p-6">
                <!-- Comments list -->
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 py-6 mt-16">
        <!-- Footer content -->
    </footer>

    <script>
        // JavaScript for AJAX comment submission and rendering
    </script>
<?php $view->stop() ?>
