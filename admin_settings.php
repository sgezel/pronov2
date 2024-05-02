<br />
                    <h2>Instellingen aanpassen</h2>

                    <form method="post" action="action_admin_settings.php">
                        <label for="baseurl">Baseurl: <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Standaard toevoeging aan basis URL."></i></label>
                        <input type="text" class="form-control" name="baseurl" value="<?= $settings["baseurl"] ?>" />
                        <br />
                        <br />
                        <label for="apikey">API Key:</label>
                        <input type="text" class="form-control" name="apikey" value="<?= $settings["apikey"] ?>" />
                       
                        <a href="https://rapidapi.com/sudityakumar1/api/free-football-live-score/pricing" class="small link-primary">https://rapidapi.com/sudityakumar1/api/free-football-live-score/pricing</a>
                        <br />
                        <br />
                        <label for="sponsor">Sponsor tonen? <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Logo sponsor + slide tonen"></i></label>
                        <input type="checkbox" name="sponsor" <?= $settings["sponsor"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="registrations">Gebruikers mogen registreren: <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Registratie pagina activeren"></i></label>
                        <input type="checkbox" name="registrations" <?= $settings["registrations"] ? "checked=checked" : "" ?> />
                        <br />
                        <br />
                        <label for="questionvalue">Waarde van 1 vraag: <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Punten voor juiste vraag"></i></label>
                        <input type="number" width="20px" class="form-control input-score" name="questionvalue" value="<?= $settings["questionvalue"] ?>" />
                        <br />

                        <label for="bonuspointsmatches">Quickpick bonuspunten na # matchen:</label>
                        <input type="number" width="20px" class="form-control input-score" name="bonuspointsmatches" value="<?= $settings["bonuspointsmatches"] ?>" />
                        <br />
                        <label for="bonuspoints">Quickpick bonuspunten:</label>
                        <input type="number" width="20px" class="form-control input-score" name="bonuspoints" value="<?= $settings["bonuspoints"] ?>" />
                        <br />
                        <br />
                        <label for="scoreboardequalplace">Gelijke plaatsen op scorebord: <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Deelnemers kunnen op dezelfde plaats in het scorebord staan."></i></label>
                        <input type="checkbox" name="scoreboardequalplace" <?= $settings["scoreboardequalplace"] ? "checked=checked" : "" ?> />
                        <br />
                        <br />
                        <label for="questionslocked">Vragen afsluiten? <i class="fa fa-info-circle" aria-hidden="true" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Gebruikers kunnen geen vragen meer invullen. Bij het locken van de eerse match zal dit ook worden aangezet."></i></label>
                        <input type="checkbox" name="questionslocked" <?= $settings["questionslocked"] ? "checked=checked" : "" ?> />
                        <br />
                        <br />
                        <h3>Zichtbaarheid wedstrijdrondes</h3>
                        <label for="round1">Groepsfase:</label>
                        <input type="checkbox" name="round1" <?= $settings["round1"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round2">Achtste finales:</label>
                        <input type="checkbox" name="round2" <?= $settings["round2"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round3">Kwartfinales:</label>
                        <input type="checkbox" name="round3" <?= $settings["round3"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round4">Halve finales:</label>
                        <input type="checkbox" name="round4" <?= $settings["round4"] ? "checked=checked" : "" ?> />
                        <br />
                        <label for="round5">Finale:</label>
                        <input type="checkbox" name="round5" <?= $settings["round5"] ? "checked=checked" : "" ?> />

                        <br />
                        <br />
                        <h3>SMTP</h3>
                        <label for="smtp_host">SMTP host:</label>
                        <input type="text" name="smtp_host" class="form-control" value="<?= $settings["smtp_host"]; ?>" />

                        <label for="smtp_port">SMTP port:</label>
                        <input type="text" name="smtp_port" class="form-control" value="<?= $settings["smtp_port"]; ?>" />

                        <label for="smtp_user">SMTP Username:</label>
                        <input type="text" name="smtp_user" class="form-control" value="<?= $settings["smtp_user"]; ?>" />

                        <label for="smtp_password">SMTP Password:</label>
                        <input type="password" name="smtp_password" class="form-control" value="<?= $settings["smtp_password"]; ?>" />

                        <br />
                        <input type="submit" class="btn btn-primary" value="Instellingen Opslaan" />
                    </form>