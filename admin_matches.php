<div>
                        <br />
                        <h2>Matchen toevoegen</h2>

                        <form method="post" action="action_admin_addmatch.php">
                            <div class="form">
                                <label for="date">Datum:</label>
                                <input class="mail_text" type="date" name="date" />
                                <br />
                                <label for="time">Uur:</label>
                                <input class="mail_text" type="time" name="time" />
                                <br />
                                <label for="home">Thuisploeg:</label>
                                <input class="mail_text" type="text" name="home" />
                                <br />
                                <label for="away">Uitploeg:</label>
                                <input class="mail_text" type="text" name="away" />
                                <br />
                                <label for="round">Ronde:</label><br />
                                <select class="mail_text" name="round">
                                    <option selected>Kies...</option>
                                    <option value="1">Groepsfase</option>
                                    <option value="2">Achtste finales</option>
                                    <option value="3">Kwartfinales</option>
                                    <option value="4">Halve finales</option>
                                    <option value="5">Finale</option>
                                </select>
                                <br />
                                <label for="id">ID:</label>
                                <input class="mail_text" type="number" name="id" />
                                <br />
                                <br />
                                <input type="submit" class="btn btn-primary" value="Wedstrijd Opslaan" />
                            </div>
                        </form>
                    </div>
                    <hr class="solid">
                    <div>
                        <br />
                        <h2>Overzicht</h2>
                        <?php $round = "";
                        $rounddesc = ""; ?>
                        <?php foreach ($allMatchData as $id => $data) :
                            if (strcmp($round, $data["round"]) != 0) :
                                if ($round != "") : ?>
                                    </tbody>
                                    </table>
                                <?php endif;

                                $round = $data["round"];
                                if ($round == "1") {
                                    $rounddesc = "Groepsfase";
                                }
                                if ($round == "2") {
                                    $rounddesc = "Achtste finale";
                                }
                                if ($round == "3") {
                                    $rounddesc = "Kwartfinale";
                                }
                                if ($round == "4") {
                                    $rounddesc = "Halve finale";
                                }
                                if ($round == "5") {
                                    $rounddesc = "Finale";
                                } ?>
                                <h3><?= $rounddesc; ?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">date</th>
                                            <th scope="col">time</th>
                                            <th scope="col">home</th>
                                            <th scope="col">away</th>
                                            <th scope="col">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php endif; ?>

                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $data["date"]; ?></td>
                                        <td><?= $data["time"]; ?></td>
                                        <td><?= $data["home"]; ?></td>
                                        <td><?= $data["away"] ?></td>
                                        <td><a href="editmatch.php?id=<?= $id; ?>" class="btn btn-primary">Edit</a></td>
                                    </tr>

                                <?php endforeach; ?>

                                    </tbody>
                                </table>
                    </div>