/**
 * Image Checkbox Custom Control
 *
 * @author Anthony Hortin <http://maddisondesigns.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 * @link https://github.com/maddisondesigns
 */

$('.multi-image-checkbox').on('change', function () {
    skyrocketGetAllImageCheckboxes($(this).parent().parent());
});

// Get the values from the checkboxes and add to our hidden field
function skyrocketGetAllImageCheckboxes($element) {
    var inputValues = $element.find('.multi-image-checkbox').map(function() {
        if( $(this).is(':checked') ) {
        return $(this).val();
        }
    }).toArray();
    // Important! Make sure to trigger change event so Customizer knows it has to save the field
    $element.find('.customize-control-multi-image-checkbox').val(inputValues).trigger('change');
}