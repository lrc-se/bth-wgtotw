<?php if (!empty($title)) : ?>
<h1><?= $title ?></h1>
<?php endif; ?>
<?php $this->renderView('default/msgs'); ?>
<?= $form->form($this->currentUrl(), 'post', ['class' => 'form']) ?>
<?php if ($update) : ?>
    <?= $form->input('id', 'hidden') ?>
<?php endif; ?>
    <div class="form-control">
        <div class="form-label"><?= $form->label('username', 'Användarnamn:') ?></label></div>
        <div class="form-input">
<?php if (!$update) : ?>
            <?= $form->text('username', ['required' => true, 'maxlength' => 25, 'autofocus' => true]) ?>
<?php   if ($form->hasError('username')) : ?>
            <div class="form-error"><?= $form->getError('username') ?></div>
<?php   endif; ?>
<?php else : ?>
            <div class="form-static"><?= esc($user->username) ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('password', 'Lösenord:') ?></div>
        <div class="form-input">
            <?= $form->input('password', 'password', ['minlength' => 8, 'required' => !$update, 'placeholder' => ($update ? 'Lämna blankt för att behålla nuvarande' : '')]) ?>
<?php if ($form->hasError('password')) : ?>
            <div class="form-error"><?= $form->getError('password') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('password2', 'Upprepa lösenord:') ?></div>
        <div class="form-input">
            <?= $form->input('password2', 'password', ['minlength' => 8, 'required' => !$update]) ?>
<?php if ($form->hasError('password2')) : ?>
            <div class="form-error"><?= $form->getError('password2') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('email', 'E-postadress:') ?></div>
        <div class="form-input">
            <?= $form->input('email', 'email', ['maxlength' => 200]) ?>
<?php if ($form->hasError('email')) : ?>
            <div class="form-error"><?= $form->getError('email') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('website', 'Webbplats:') ?></div>
        <div class="form-input">
            <?= $form->input('website', 'url', ['maxlength' => 500]) ?>
<?php if ($form->hasError('website')) : ?>
            <div class="form-error"><?= $form->getError('website') ?></div>
<?php endif; ?>
        </div>
    </div>
    <div class="form-control">
        <div class="form-label"><?= $form->label('hideEmail', 'Dölj e-post:') ?></div>
        <div class="form-input">
            <?= $form->checkbox('hideEmail', 1) ?>
        </div>
    </div>
<?php if ($admin) : ?>
    <div class="form-control">
        <div class="form-label"><?= $form->label('isAdmin', 'Administratör:') ?></div>
        <div class="form-input">
<?php   if (!$user || $user->id != $admin->id) : ?>
            <?= $form->checkbox('isAdmin', 1) ?>
<?php   else : ?>
            <input type="hidden" name="isAdmin" value="1">
            <div class="form-static">Ja</div>
<?php   endif; ?>
        </div>
    </div>
<?php endif; ?>
    <div class="form-control">
        <div class="form-label"></div>
        <div class="form-input">
            <input type="submit" value="<?= ($update ? 'Spara' : 'Registrera') ?>">
<?php if ($update || $admin) : ?>
            <a class="btn btn-2" href="<?= $this->url(($admin ? 'admin/user' : 'user/' . $user->id)) ?>">Avbryt</a> 
<?php endif; ?>
        </div>
    </div>
</form>
