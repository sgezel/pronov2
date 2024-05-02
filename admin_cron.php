<br />
                    <h2>Cron functies aanroepen</h2>

                    <div class="list-group">

                        <?php foreach ($cron_actions as $action) : ?>
                            <a href="cron.php?func=<?= str_replace("cron_", "", $action); ?>" class="list-group-item list-group-item-action" target="_blank"><?= str_replace("cron_", "", $action); ?></a>
                        <?php endforeach; ?>

                    </div>