<br />
                    <h2>Gebruikers aanpassen</h2>

                    <table class="table table-hover" id="usertable" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">email</th>
                                <th scope="col">name</th>
                                <th scope="col">group</th>
                                <th scope="col">paid</th>
                                <th scope="col">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allUserData as $id => $data) : ?>

                                <?php
                                if (!isset($_SESSION["superadmin"]) || $_SESSION["superadmin"] != true) {
                                    if ($_SESSION["group"] != $data["group"])
                                        continue;
                                }

                                ?>

                                <?php $allUserMailString .= ";" . $data["username"]; ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $data["username"]; ?></td>
                                    <td><?= $data["name"]; ?></td>
                                    <td><?= $data["group"]; ?></td>
                                    <td><?= $data["paid"] ?></td>
                                    <td><a href="edituser.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <p class="wit">
                                <a href="mailto:?bcc=<?= $allUserMailString;  ?>&subject=Pr(emed)onostiek Update" class="btn btn-warning">Alle deelnemers mailen</a>
                            </p>
                        </div>
                    </div>

                    