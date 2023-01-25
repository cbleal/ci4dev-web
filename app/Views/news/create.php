<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= service('validation')->listErrors() ?>

<form action="/news/create" method="post">

    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="text" name="title" /><br />

    <label for="body">Text</label>
    <textarea name="body" cols="30" rows="10"></textarea><br />

    <input type="submit" name="submit" value="Save">
</form>