<br />
                    <h2>Melding versturen?</h2>

                    <form method="post" action="action_admin_notification.php">

                        <?php foreach ($allUserData as $id => $data) : ?>
                            <?php if (isset($data["devicekey"]) && !$data["devicekey"] == "") : ?>
                                <input type="checkbox" name="devicekey[]" value="<?= $data["devicekey"]; ?>" ?> <?= $data["name"]; ?> <br />
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <br />
                        <label for="notificationtitle">Title:</label>
                        <input type="text" class="form-control" name="notificationtitle" />
                        <br />
                        <br />
                        <label for="notificationtext">Text:</label>
                        <input type="text" class="form-control" name="notificationtext" />
                        <br />
                        <br />
                        <label for="notificationimg">ImageURL:</label>
                        <input type="text" class="form-control" name="notificationimg" />
                        <br />
                        <br />
                        <br /><br />
                        <input type="submit" class="btn btn-primary" value="Versturen" />
                    </form>