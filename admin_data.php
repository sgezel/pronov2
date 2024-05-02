<br />
                    <h2>Data file aanpassen</h2>

                    <div class="row">
                        <div class="col-2">

                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <?php foreach ($backup_files as $folder => $filelist) : ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-head-<?= $folder; ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?= $folder; ?>" aria-expanded="false" aria-controls="flush-collapseOne">
                                                <?= $folder; ?>
                                            </button>
                                        </h2>
                                        <div id="flush-<?= $folder; ?>" class="accordion-collapse collapse" aria-labelledby="flush-head-<?= $folder; ?>" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                    <?php foreach ($filelist as $file) : ?>

                                                        <a class="nav-link" href="admin.php?tab=data&folder=<?= $folder; ?>&file=<?= $file; ?>"><?= $file ?></a>

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>


                        <?php
                        $json_data = $userCrud->data;

                        if (isset($_GET["folder"]) && isset($_GET["file"])) {
                            if ($_GET["folder"] != "current" && $_GET["file"] != "data.json") {
                                $json_data = json_decode(file_get_contents("backup/" . $_GET["folder"] . "/" . $_GET["file"]));
                            }
                        }
                        ?>

                        <div class="col-8">

                            <form method="post" action="action_admin_data.php">
                                <textarea class="form-control textas vh-60" name="datafile">
                            <?= json_encode($json_data, JSON_PRETTY_PRINT); ?>
                        </textarea>
                                <br /><br />
                                <input type="submit" class="btn btn-primary" value="Data Opslaan" />
                            </form>
                        </div>
                    </div>

