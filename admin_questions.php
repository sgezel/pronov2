<div>

<br />
<h2>Vragen toevoegen</h2>
<form method="post" action="action_admin_addquestion.php">
    <div class="form">
        <label for="question">Vraag:</label>
        <input class="mail_text" type="text" name="question" />
        <br />
        <br />
        <input type="submit" class="btn btn-primary" value="Vraag opslaan" />
    </div>
</form>
</div>

<hr class="solid">
<div>
<br />
<h2>Overzicht</h2>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">question</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <?php foreach ($allQuestionData as $id => $data) : ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $data["question"]; ?></td>
            <td><a href="editquestion.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>