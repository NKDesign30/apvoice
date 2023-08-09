/**
 * Delete level
 * @returns {boolean}
 */
function apoUserLevelsDeleteLevel(e)
{
    let $ = jQuery;
    $(e).closest('p').remove();

    // Recalc levels
    let counter = 2;
    $.each($('.input-level'), function() {
        $(this).val(counter);
        counter++;
    });
    return false;
}

/**
 * Add level
 * @returns {null}
 */
function apoUserLevelsAddLevel(e)
{
    let $ = jQuery;
    let count = $('.input-level').length + 2;
    let p = $('<p></p>');
    let levelInput = $('<input style="width:100px" name="levels[level][]" type="number" readonly value="'+count+'" placeholder="Level" class="regular-text input-level">');
    let levelPoint = $('<input style="width:100px; margin-left:5px;" name="levels[points][]" type="number" value="5" placeholder="Points" class="regular-text input-points">');
    let levelRemove = $('<a href="#" style="margin-left:5px;">Remove level</a>').click(function() {
        return apoUserLevelsDeleteLevel(this);
    });
    p.append(levelInput);
    p.append(levelPoint);
    p.append(levelRemove);

    $('.level-list').append(p);

    return null;
}

/**
 * Apo user levels
 * Event listener
 */
jQuery(document).ready(function() {
    let $ = jQuery;
    $('#add-apo-user-level').click(function() {
        return apoUserLevelsAddLevel(this);
    });

    $('.level-list a').click(function() {
        return apoUserLevelsDeleteLevel(this);
    });
});