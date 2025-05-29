$(document).ready(function () {
    const resetButtonHtml = `
        <p class="mt-5">
            <button id="reset-button" class="btn btn-secondary">В начало</button>
        </p>
    `;

    const errorContent = '<h5 class="text-danger">Не удалось создать ссылку</h5>';

    function renderContent(innerHtml) {
        $('#content').html(`
            <div class="text-center my-4">
                ${innerHtml}
                ${resetButtonHtml}
            </div>
        `);

        $('#reset-button').on('click', function () {
            location.reload();
        });
    }

    $('#link-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const button = $('#submit-button');
        const formData = form.serialize();

        button.prop('disabled', true);

        $.ajax({
            url: form.attr('action') || '/link/shorten',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                $('#title').text(data.success ? 'Готово!' : 'Ошибка');
                $('#subtitle').text(data.message);

                let contentHtml = '';

                if (data.success) {
                    contentHtml = `
                        <p> 
                            <a href="${data.shortUrl}" target="_blank">${data.shortUrl}</a>
                        </p>
                        <p class="my-2">
                            <img class="img-fluid" src="${data.qrCode}" alt="QR Code">
                        </p>
                    `;
                } else {
                    contentHtml = errorContent;
                }

                renderContent(contentHtml);
            },
            error: function () {
                $('#title').text('Ошибка');
                $('#subtitle').text(data.message);

                renderContent(errorContent);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });
});
