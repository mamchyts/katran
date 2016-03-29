<div class="container" style="width: 400px; margin-top: 10%;">
    <form class="form-signin" action="<?=$currentUrl;?>" method="post">
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">&#xe7fd;</i>
                <input type="text" name="data[login]" id="inputEmail" class="validate" autofocus="autofocus" required="required">
                <label for="inputEmail">Логин</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">&#xe90d;</i>
                <input type="password" name="data[pass]" id="inputPass" class="validate" autofocus="autofocus" required="required">
                <label for="inputPass">Пароль</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 center">
                <input type="submit" name="submit[account|do_login]" class="waves-effect waves-light btn disable-fade" value="Вход"/>
            </div>
        </div>
    </form>
</div>
