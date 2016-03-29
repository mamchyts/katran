<h5><?=(empty($row['id']))?'Добавить новую страницу':'Редактировать страницу'?></h5>
<div class="clear" style="height: 2em;"></div>

<div class="row">
    <form class="" action="<?=$currentUrl;?>" method="post" name="view" autocomplete="off">
        <input type="hidden" name="id" value="<?=(empty($row['id']))?'new':$row['id'];?>"/>

        <div class="row">
            <div class="input-field col s6">
                <input placeholder="Название" id="row_title" type="text" class="validate" name="data[title]" value="<?=(isset($row['title']))?$row['title']:''?>">
                <label for="row_title" >Название</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input placeholder="Url" id="row_url" type="text" class="validate" name="data[url]" value="<?=(isset($row['url']))?$row['url']:''?>">
                <label for="row_url">Url</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name="data[status]" class="">
                    <?=\Katran\Library\Html::createSelect(\Katran\Helper::_cfg('statuses'), isset($row['status'])?$row['status']:'active')?>
                </select>
                <label>Статус</label>
            </div>
            <div class="input-field col s6">&nbsp;</div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <p>Краткое описание</p>
                <textarea class="wysiwig-container" name="data[descr]" data-height="130"><?=(isset($row['descr']))?$row['descr']:''?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <p>Полное описание</p>
                <textarea class="wysiwig-container" name="data[html]" data-height="350"><?=(isset($row['html']))?$row['html']:''?></textarea>
            </div>
        </div>

        <h5 style="margin-top: 2em;">SEO данные (необязательны для заполнения)</h5>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="row_meta_title" class="materialize-textarea validate" 
                    name="data[meta_title]"><?=(isset($row['meta_title']))?$row['meta_title']:''?></textarea>
                <label for="row_meta_title">Meta Title</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="row_meta_keywords" class="materialize-textarea validate" 
                    name="data[meta_keywords]"><?=(isset($row['meta_keywords']))?$row['meta_keywords']:''?></textarea>
                <label for="row_meta_keywords">Meta Keywords</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <textarea id="row_meta_description" class="materialize-textarea validate" 
                    name="data[meta_description]"><?=(isset($row['meta_description']))?$row['meta_description']:''?></textarea>
                <label for="row_meta_description">Meta description</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input type="submit" name="submit[content|save]" class="btn btn-primary" value="Сохранить">
            </div>
        </div>
    </form>
</div>