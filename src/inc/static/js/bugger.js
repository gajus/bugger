$(function () {
    $('.code').on('click', function () {
        var argsContainer = $(this).parents('li').find('.args');

        argsContainer.toggleClass('min');
    });
});