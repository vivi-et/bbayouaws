<h1>Laravel crop images - codesource.io</h1>
<?= Form::open(array('files' => true)) ?>
<?= Form::label('image', 'My Image') ?>
<br>
<?= Form::file('image') ?>
<br>
<?= Form::submit('Upload!') ?>
<?= Form::close() ?>