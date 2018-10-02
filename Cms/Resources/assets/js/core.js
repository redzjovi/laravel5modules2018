$(document).on('click', '.table_row_checkbox', function () {
    var checked = true;
    $('.table_row_checkbox').each(function () {
        var self = $(this);
        if (self.is(':checked')) { self.closest('tr').addClass('table-info'); }
        else { self.closest('tr').removeClass('table-info'); checked = false; }
        $('.table_row_checkbox_all').prop('checked', checked);
    });
});

$(document).on('click', '.table_row_checkbox_all', function () {
    var self = $(this);
    if (self.is(':checked')) { self.closest('table').find('tbody tr').addClass('table-info').find('.table_row_checkbox').prop('checked', true); }
    else { self.closest('table').find('tbody tr').removeClass('table-info').find('.table_row_checkbox').prop('checked', false); }
});
