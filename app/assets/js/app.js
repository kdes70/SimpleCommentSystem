import { validateCommentForm } from './validation';

document.addEventListener('DOMContentLoaded', () => {
    const commentForm = document.getElementById('comment-form');
    const commentsContainer = document.getElementById('comments-container');

    commentForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!validateCommentForm(commentForm)) {
            return;
        }

        const formData = new FormData(commentForm);
        const response = await fetch('/comments', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            const commentHtml = await response.text();
            commentsContainer.insertAdjacentHTML('beforeend', commentHtml);
            commentForm.reset();
        } else {
            alert('Ошибка при добавлении комментария');
        }
    });
});