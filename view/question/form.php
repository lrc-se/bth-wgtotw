<?= $form->form($this->currentUrl(), 'post', ['class' => 'form']) ?>
<?php if ($update) : ?>
    <?= $form->input('id', 'hidden') ?>
    <?= $form->input('parentId', 'hidden') ?>
<?php else : ?>
    <input type="hidden" name="parentId" value="">
<?php endif; ?>
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
        <div class="form-label"><label>Taggar:</label></div>
        <div class="form-input tags">
<?php foreach ($tags as $n => $tag) : ?>
            <span class="nowrap">
                <input id="tag-<?= $n ?>" type="checkbox" name="tagIds[]" value="<?= $tag->id ?>"<?= (in_array($tag->id, $tagIds) ? ' checked' : '') ?>>
                <label for="tag-<?= $n ?>"><?= esc($tag->name) ?></label>
            </span>
<?php endforeach; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"></div>
        <div class="form-input">
            <input type="submit" value="<?= ($update ? 'Uppdatera' : 'Skicka') ?>">
            <a class="btn btn-2" href="<?= $this->url((!empty($admin) ? 'admin/question' : ($update ? 'question/' . $form->getModel()->id : 'question'))) ?>">Avbryt</a> 
        </div>
    </div>
</form>
