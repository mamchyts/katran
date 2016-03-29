<div class="">
    <div class="row">
        <div class="col s12" style="margin-bottom: 1em;">
            <ul class="tabs z-depth-1">
                <li class="tab col s3"><a href="#slideshow">Слайдшоу</a></li>
            </ul>
        </div>
        <div id="slideshow" class="col s12">
            <form action="<?=$currentUrl;?>" method="post" name="slideshow" autocomplete="off">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>File</span>
                        <input type="file" multiple class="input-file-api">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Upload one or more files">
                    </div>
                </div>
                <div class="row file-upload-block">
                    <div class="col s4 file-upload-block__process"></div>
                    <div class="col s8 file-upload-block__list">
                        <?php foreach ($tabs['slideshow'] as $m):?>
                            <div class="file-upload-block-list__item">
                                <div class="file-upload-block-list-item z-depth-1">
                                    <input type="hidden" name="data[images][]" value="<?=$m?>">
                                    <img class="file-upload-block-list-item__image" src="<?=$m?>" alt="<?=$m?>">
                                    <div class="file-upload-block-list-item__delete" onclick="deleteImage(this)"><i class="material-icons md-18">&#xe5cd;</i></div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <input type="submit" name="submit[setting|slideshow_update]" class="btn btn-primary" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
</div>

