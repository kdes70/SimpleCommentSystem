export function validateCommentForm(form)
{
    const nameInput = form.querySelector('input[name="name"]');
    const emailInput = form.querySelector('input[name="email"]');
    const titleInput = form.querySelector('input[name="title"]');
    const contentInput = form.querySelector('textarea[name="content"]');

    let isValid = true;

    // Валидация имени
    if (nameInput.value.trim() === '') {
        nameInput.classList.add('is-invalid');
        isValid = false;
    } else {
        nameInput.classList.remove('is-invalid');
    }

    // Валидация email
    const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!emailRegex.test(emailInput.value.trim())) {
        emailInput.classList.add('is-invalid');
        isValid = false;
    } else {
        emailInput.classList.remove('is-invalid');
    }

    // Валидация заголовка
    if (titleInput.value.trim() === '') {
        titleInput.classList.add('is-invalid');
        isValid = false;
    } else {
        titleInput.classList.remove('is-invalid');
    }

    // Валидация содержимого
    if (contentInput.value.trim() === '') {
        contentInput.classList.add('is-invalid');
        isValid = false;
    } else {
        contentInput.classList.remove('is-invalid');
    }

    return isValid;
}