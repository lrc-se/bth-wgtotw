<?php $this->renderView('default/msgs'); ?>
<?= $form->form($this->currentUrl(), 'post', ['class' => 'form']) ?>
<?php if ($update) : ?>
    <?= $form->input('id', 'hidden') ?>
<?php endif; ?>
    <input type="hidden" name="parentId" value="">
    <div class="form-control">
        <div class="form-label"><?= $form->label('title', 'Rubrik:') ?></label></div>
        <div class="form-input">
            <?= $form->text('title', ['required' => true, 'maxlength' => 100, 'autofocus' => true]) ?>
<?php   if ($form->hasError('title')) : ?>
            <div class="form-error"><?= $form->getError('title') ?></div>
<?php   endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('text', 'Text:') ?></div>
        <div class="form-input">
            <?= $form->textarea('text', ['required' => true, 'rows' => 7]) ?>
<?php if ($form->hasError('text')) : ?>
            <div class="form-error"><?= $form->getError('text') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"></div>
        <div class="form-input">
            <input type="submit" value="<?= ($update ? 'Uppdatera' : 'Skicka') ?>">
<?php if ($update || $admin) : ?>
            <a class="btn btn-2" href="<?= $this->url(($admin ? 'admin/post' : 'question')) ?>">Avbryt</a> 
<?php endif; ?>
        </div>
    </div>
</form>
