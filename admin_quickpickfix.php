<br />
                    <h2>QuickPickFix&reg;</h2>

                    <form method="post" action="action_admin_forcquickpick.php">
                        <select class="mail_text" name="match">
                            <option selected>Kies match...</option>
                            <?php foreach ($allMatchData as $mid => $match) : ?>
                                <option value="<?= $mid; ?>"> <?= $mid; ?>: <?= $match["home"]; ?> - <?= $match["away"]; ?></option>
                            <?php endforeach; ?>

                        </select>

                        <select class="mail_text" name="user">
                            <option selected>Kies gebruiker...</option>
                            <?php foreach ($allUserData as $uid => $user) : ?>
                                <option value="<?= $uid; ?>"> <?= $uid; ?>: <?= $user["name"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br /><br />
                        <p>
                            <br /><br />

                        </p>
                        <br /><br />

                        <input type="submit" class="btn btn-primary" value="Forceer quickpick" />
                    </form>