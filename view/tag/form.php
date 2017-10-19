<?php $this->renderView('default/msgs'); ?>
<?= $form->form($this->currentUrl(), 'post', ['class' => 'form']) ?>
<?php if ($update) : ?>
    <?= $form->input('id', 'hidden') ?>
<?php endif; ?>
    <div class="form-control">
        <div class="form-label"><?= $form->label('name', 'Namn:') ?></label></div>
        <div class="form-input">
            <?= $form->text('name', ['required' => true, 'maxlength' => 25, 'autofocus' => true]) ?>
<?php if ($form->hasError('name')) : ?>
            <div class="form-error"><?= $form->getError('name') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('description', 'Beskrivning:') ?></div>
        <div class="form-input">
            <?= $form->textarea('description', ['required' => true, 'rows' => 7, 'maxlength' => 200]) ?>
<?php if ($form->hasError('description')) : ?>
            <div class="form-error"><?= $form->getError('description') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"></div>
        <div class="form-input">
            <input type="submit" value="<?= ($update ? 'Spara' : 'Skapa') ?>">
            <a class="btn btn-2" href="<?= $this->url('admin/tag') ?>">Avbryt</a> 
        </div>
    </div>
</form>
