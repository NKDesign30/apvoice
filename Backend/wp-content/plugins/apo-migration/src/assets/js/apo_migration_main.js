jQuery(document).ready(function($) {

    var migrationTypeField = $('#apo-migration-class');
    var migrationMethodField = $('#apo-migration-method');

    $('.apo-migration-process-handler').click(function(e) {

        if($(this).hasClass('apo-confirm')) {
            if(!confirm('Migration for this resource has already run. Are you sure you want execute it again?')) {
                e.preventDefault();
                return;
            }
        }

        $('.apo-migration-process-handler').removeClass('button-primary');
        $(this).addClass('button-primary');
        migrationTypeField.val($(this).data().migrationClass);
        migrationMethodField.val($(this).data().migrationMethod);
    });

    $('.apo-collapse-handler').click(function() {
        $(this).next('.apo-collapsable').slideToggle();
        $(this).toggleClass('active');
    });

});