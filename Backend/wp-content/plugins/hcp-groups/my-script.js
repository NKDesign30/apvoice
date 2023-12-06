
jQuery(document).ready(function($) {
    $('.hcp-delete-action').on('click', function(e) {
        if (!confirm('Sind Sie sicher, dass Sie diesen Benutzer löschen möchten?')) {
            e.preventDefault();
        }
    });
});
