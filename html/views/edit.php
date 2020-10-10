<h3 class="uk-heading-line">
    <span>修改学生信息</span>
</h3>
<div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">
    <form class="uk-form-stacked" action="/edit?id=<?php __($id ?? ''); ?>" method="post">

        <?php if (isset($error) && $error !== '') { ?>
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php __($error) ?></p>
            </div>
        <?php } ?>

        <input name="id" type="hidden" value="<?php __($id ?? ''); ?>">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">学号</label>
            <div class="uk-form-controls">
                <input class="uk-input" name="no" type="text" placeholder="请输入数字学号" value="<?php __($no ?? ''); ?>">
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">姓名</label>
            <div class="uk-form-controls">
                <input class="uk-input" name="name" type="text" placeholder="请输入学生姓名" value="<?php __($name ?? ''); ?>">
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-form-label">性别</div>
            <div class="uk-form-controls">
                <label><input class="uk-radio" type="radio" name="gender"
                              value="0" <?php echo(($gender ?? '0') === 0 ? 'checked' : '') ?>>男</label>
                <label><input class="uk-radio" type="radio" name="gender"
                              value="1" <?php echo(($gender ?? '0') === 1 ? 'checked' : '') ?>>女</label>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">电话号码</label>
            <div class="uk-form-controls">
                <input class="uk-input" name="phone" type="text" placeholder="请输入电话号码"
                       value="<?php __($phone ?? ''); ?>">
            </div>
        </div>
        <button type="submit" class="uk-button uk-button-primary">修改学生</button>
    </form>
</div>
