<?= $form->form($this->currentUrl(), 'post', ['class' => 'form']) ?>
<?php if ($update) : ?>
    <?= $form->input('id', 'hidden') ?>
    <?= $form->input('parentId', 'hidden') ?>
<?php else : ?>
    <input type="hidden" name="parentId" value="<?= $questionId ?>">
<?php endif; ?>
    <div class="form-control">
        <div class="form-input">
            <?= $form->textarea('text', ['required' => true, 'rows' => 7, 'autofocus' => true]) ?>
<?php if ($form->hasError('text')) : ?>
            <div class="form-error"><?= $form->getError('text') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-input">
            <input type="submit" value="<?= ($update ? 'Uppdatera' : 'Skicka') ?>">
            <a class="btn btn-2" href="<?= $this->url($return) ?>">Avbryt</a> 
        </div>
    </div>
</form>
