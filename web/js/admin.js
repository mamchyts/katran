
// on DOM load
$( document ).ready(function() {

    // menu
    $('.button-collapse').sideNav({
            menuWidth: 200,  // Default is 240
            edge: 'left', // Choose the horizontal origin
            closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
        }
    );

    // http://materializecss.com/forms.html
    $('select').material_select();

    // run wisiwig editor
    $('.wysiwig-container').each(function(index, item){

        $(item).attr('id', 'random-'+index+'-'+Math.floor(Math.random() * 1000));
        var itemId = $(item).attr('id');

        // need for set height
        (function(containerObjId){
            var containerObj = $('#'+containerObjId);
            tinymce.init({
                selector: '#'+containerObjId,
                height: (containerObj.data('height'))?containerObj.data('height'):300,
                language_url : '/js/tinymce_langs/ru.js',
                directionality: 'ltr',
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | ' +
                            'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | ' +
                            'print preview media | forecolor backcolor',
                content_css: [
                    '/css/common.css',
                    '/css/visitor.css'
                ]
              });
        })(itemId)
    });

    // hide alert block onclick
    $('.alert-block__clear').on('click', function () {
        $(this).parent().slideUp()
    })

    // ckeck all/none
    $('#checkbox-all-in-table').on('change', function (e) {
        var checkedVal = e.target.checked;
        $(e.target).parents('table').find('td input[type="checkbox"]').each(function(index, item){
            item.checked = checkedVal;
        });

    })

    // onclick btn delete
    $('.table-btn-action-block__delete').on('click', function (e) {
        var findChecked = false;
        $(e.target).parents('form').find('table td input[type="checkbox"]').each(function(index, item){
            if(item.checked === true){
                findChecked = true;
                return 0;
            }
        });

        if(findChecked === false)
            return  Materialize.toast('Ничего не выбрано', 4000);

        // set handler "YES"
        $('#delete-confirmation .modal-btn-confirm').on('click', function(){
            var $form = $(e.target).parents('form');
            var actionVal = $form.attr('action')
            actionVal = actionVal.replace(/action=[^&\/]+/i, "action=bulkDelete");
            $form.attr('action', actionVal);
            $form.submit();
        })

        $('#delete-confirmation').openModal({
            complete: function(e){
                // remove btn handlers
                $('#delete-confirmation .modal-btn-confirm').off('click');
            }
        });
    })

    // disable double click action
    $('form input[name*=submit]:not(.disable-fade)').on('click', function(e){
        setTimeout(function() {
            fade(99999, 1);
            $(e.target).attr('disabled', 'disabled');
        }, 20);
    })
});




