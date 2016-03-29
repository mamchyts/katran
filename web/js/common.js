
/**
 * on DOM load
 */
$( document ).ready(function() {
    var input_files = $('.input-file-api');
    for (var i = 0, len = input_files.length; i < len; ++i) {
        $(input_files[i]).on('change', function (evt){
            var files = FileAPI.getFiles(evt);
            onFiles(files);
            if(evt.currentTarget && evt.currentTarget.value)
                evt.currentTarget.value = '';
        })
    }

    // hack for normal rendering html
    $('#main_debug_log').toggleClass('noDisplay')

    // function set active image by click
    $('.file-upload-block__list').on('click', function(e){

        // exception for slideshow setting page
        if($(e.target).parents('#slideshow').length === 1)
            return 0;

        // if click was on image - set active value
        if($(e.target).hasClass('file-upload-block-list-item__image')){
            var path = $(e.target).parents('.file-upload-block-list__item').find('input').val();
            if(path){
                var $form = $(e.target).parents('form');

                // add hidden field with main foto value
                if($form.find('input[name="data[main_foto]"]').length === 0)
                    $form.append('<input type="hidden" name="data[main_foto]" value="'+path+'">')
                else{
                    if($form.find('input[name="data[main_foto]"]').val() === path)
                        return false;

                    $form.find('input[name="data[main_foto]"]').val(path)
                }

                // reset active class
                $('.file-upload-block-list__item--active').removeClass('file-upload-block-list__item--active');
                $(e.target).parents('.file-upload-block-list__item').addClass('file-upload-block-list__item--active')
            }
        }
    });

});


/**
 * function generate (show/hide if already exist) fade div (with loading gif if need)
 * 
 * @param  {[type]} zIndex  [description]
 * @param  {[type]} loading [description]
 * @return {[type]}         [description]
 */
function fade(zIndex, loading)
{
    if(!$('#fade').length){
        var load = window.document.createElement('div');
        load.id = 'fade';
        window.document.body.appendChild(load);
    }

    if(!zIndex)
        zIndex = 0;

    if(loading){
        if(!$('#loading_image').length){
            var im = window.document.createElement('img');
            im.id = 'loading_image';
            im.src = '/pic/loading.gif';
            im.className = 'smallPreLoader';
            im.style.top = ($(window).height()-40)/2+'px';
            im.style.left = ($(window).width()-40)/2+'px';
            window.document.body.appendChild(im);
        }

        $('#loading_image').css('display', (zIndex)?'block':'none');
        $('#loading_image').css('zIndex', (zIndex-1));
    }

    $('#fade').css({'zIndex': zIndex, 'display': (zIndex)?'block':'none'});
    if($('#loading_image').length && (!loading || !zIndex))
        $('#loading_image').css('display', 'none');
}


/**
 * [deleteImage description]
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function deleteImage(obj)
{
    var path = $(obj).parents('.file-upload-block-list__item').find('input').val();
    if(!path)
        return Materialize.toast('Произошла ошибка, попробуйте еще раз', 4000);

    fade(2, 2);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/admin?controller=file&action=delete_images&img='+encodeURIComponent(path),
        success: function(data){
            if(data && data.deleted){
                $(obj).parents('.file-upload-block-list__item').remove();
            }
            else{
                Materialize.toast('Произошла ошибка, попробуйте еще раз', 4000)
            }

            fade(0);
        }
    });
}


/**
 * [onFiles description]
 * @param  {[type]} files [description]
 * @return {[type]}       [description]
 */
function onFiles(files){
    FileAPI.each(files, function (file){
        if(!file.size || (file.size < FileAPI.kB) || (file.size >= 16*FileAPI.MB)){
            Materialize.toast('Максимальный размер файла 16MB', 4000)
        }
        else {
            FU.add(file);
            FU.start();
        }
    });
}


// Object for FileAPI
var FU = {
    icon: {
        def:   '/pics/FileAPI/unknown.png',
        image: '/pics/FileAPI/image.png',
        audio: '/pics/FileAPI/music.png',
        video: '/pics/FileAPI/video.png'
    },
    files: [],
    index: 0,
    active: false,

    add: function (file){
        FU.files.push(file);

        if( /^image/.test(file.type) ){
            FileAPI.Image(file).preview(35).get(function (err, img){
                if( !err ){
                    var fid = FU.getFileId(file);

                    var html = '<div class="fu-item__image"></div>';
                    html += '<div class="fu-item__info fu-item-info">';
                    html += '<div class="fu-item-info__title">'+file.name+'</div>';
                    html += '<div class="fu-item-info__info noDisplay">Размер: '+((file.size/1024).toFixed(1))+' KB, Статус: <span>error</span></div>';
                    html += '<div class="fu-item-info__progress progress"><div class="determinate" style="width: 1%"></div></div>';
                    html += '<div class="fu-item-info__abort" onclick="FU.abort(\''+FileAPI.uid(file)+'\')"><i class="material-icons" md-18>&#xe5cd;</i></div>';
                    html += '<div class="clear"></div>';
                    html += '</div>';

                    // append new item
                    var str = '<div class="fu-item z-depth-1" id="'+fid+'">' + html + '</div>';
                    $('.file-upload-block .file-upload-block__process').append(str);

                    if(img)
                        $('#'+fid+' .fu-item__image').append(img);
                }
                else{
                    Materialize.toast('Разрешено загрузать только изображения: ' + err, 4000)
                }
            });
        }
        else{
            Materialize.toast('Разрешено загрузать только изображения', 4000)
        }
    },

    getFileId: function (file){
        return 'file-'+FileAPI.uid(file);
    },

    start: function (){
        if( !FU.active && (FU.active = FU.files.length > FU.index) ){
            FU._upload(FU.files[FU.index]);
        }
    },

    abort: function (id){
        var file = this.getFileById(id);
        if( file.xhr ){
            file.xhr.abort();
        }
    },

    getFileById: function (id){
        var i = FU.files.length;
        while( i-- ){
            if( FileAPI.uid(FU.files[i]) == id ){
                return  FU.files[i];
            }
        }
    },

    _upload: function (file){
        if( file ){
            file.xhr = FileAPI.upload({
                url: '/admin?controller=file&action=upload_images',
                files: { file: file },
                upload: function (){
                },
                progress: function (evt){
                    var fid = FU.getFileId(file);

                    // if error
                    if(!$(fid))
                        return Materialize.toast('Произошла ошибка, попробуйте снова', 4000);

                    $('#'+fid+' .determinate').css('width', (evt.loaded/evt.total*100)+'%');
                },
                complete: function (err, xhr){
                    var fid = FU.getFileId(file);
                    var state = err ? 'ошибка' : 'загружено';

                    if(!$(fid))
                        return 0;

                    $('#'+fid+' .fu-item-info__progress').addClass('noDisplay');
                    $('#'+fid+' .fu-item-info__abort').addClass('noDisplay');
                    $('#'+fid+' .fu-item-info__info').removeClass('noDisplay');

                    // set status
                    $('#'+fid+' .fu-item-info__info').children(0).text((err ? (xhr.statusText || err) : state))

                    FU.index++;
                    FU.active = false;
                    FU.start();

                    var response = JSON.parse(xhr.response);
                    if(response && response.images && response.images.file){
                        var obj = response.images.file;

                        var html = '<div class="file-upload-block-list__item">';
                        html += '<div class="file-upload-block-list-item z-depth-1">';
                        html += '<input type="hidden" name="data[images][]" value="'+obj.filePath+'">';
                        html += '<img class="file-upload-block-list-item__image" src="'+obj.dataURL+'" alt="'+obj.nameWrapped+'">';
                        html += '<div class="file-upload-block-list-item__delete" onclick="deleteImage(this)"><i class="material-icons md-18">&#xe5cd;</i></div>';
                        html += '</div>';
                        html += '</div>';

                        $('.file-upload-block__list').append(html);
                    }
                }
            });
        }
    }
};


