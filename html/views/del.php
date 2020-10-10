<h3 class="uk-heading-line">
    <span>删除学生信息</span>
</h3>
<div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">
    <form class="uk-form-stacked" action="/delete?id=<?php __($id ?? ''); ?>" method="post">
        <div class="uk-alert-danger" uk-alert>
            <p>数据无价，请再次确认是否删除！</p>
        </div>

        <input name="id" type="hidden" value="<?php __($id ?? ''); ?>">

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">学号</label>
            <div class="uk-form-controls">
                <?php __($no ?? ''); ?>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">姓名</label>
            <div class="uk-form-controls">
                <?php __($name ?? ''); ?>
            </div>
        </div>

        <div class="uk-margin">
            <div class="uk-form-label">性别</div>
            <div class="uk-form-controls">
                <?php echo(($gender ?? '0') === 0 ? '男' : '女') ?>
            </div>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">电话号码</label>
            <div class="uk-form-controls">
                <?php __($phone ?? ''); ?>
            </div>
        </div>
        <button type="submit" class="uk-button uk-button-danger">确认删除</button>
    </form>
</div>
