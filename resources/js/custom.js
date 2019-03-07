$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.flashMess').delay(3000).slideUp();

    $('#formAuthors').select2({
        placeholder: 'Выберите автора',
        maximumSelectionLength: 3,
        tags: false,
        language: {
            noResults: function () {
                return "Результатов не найдено";
            },
            maximumSelected: function () {
                return "Вы не можете выбрать более трех авторов";
            }
        }
    });

    $('#formBooks').select2({
        placeholder: 'Выберите книгу',
        tags: false,
        language: {
            noResults: function () {
                return "Результатов не найдено";
            }
        }
    });

});