<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mitglied Bearbeiten</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="editfname">Vorname:</label>
                        <input class="form-control" type="text" id="editfname" name="fname" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="editlname">Nachname:</label>
                        <input class="form-control" type="text" id="editlname" name="lname" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="editbirthday">Geburtstag:</label>
                        <input class="form-control" type="date" id="editbirthday" name="birthday" max="<?=date('Y-m-d')?>" required>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="editdepartment1" name="department1" value="achery">
                        <label class="form-check-label" for="editdepartment1">Ich bin in der Bogenabteilung</label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="editdepartment2" name="department2" value="airpressure">
                        <label class="form-check-label" for="editdepartment2"> Ich bin in der Luftdruck Abteilung</label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="editdepartment3" name="department3" value="firearms">
                        <label class="form-check-label" for="editdepartment3"> Ich bin in der Feuerwaffen Abteilung</label>
                    </div>
                    <div class="form-group">
                        <label for="editemail">Geben Sie ihre E-Mail an:</label>
                        <input class="form-control" type="email" id="editemail" name="email" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="edittelefon">Telefonnummer:</label>
                        <input type="text" class="form-control" id="edittelefon" name="telefon" maxlength="255" pattern="^([+](\d{1,3})\s?)?((\(\d{3,5}\)|\d{3,5})(\s)?)\d{3,8}$">
                    </div>
                    <p>Bitte geben Sie ihre Adresse an</p>
                    <div class="form-group">
                        <label for="editstreet">Straße:</label>
                        <input class="form-control" type="text" id="editstreet" name="street" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="editnumber">Hausnummer:</label>
                        <input class="form-control" type="number" id="editnumber" name="number" min="1" step="1" required>
                    </div>
                    <div class="form-group">
                        <label for="editzipcode">PLZ:</label>
                        <input class="form-control" type="text" id="editzipcode" name="zipcode" min="10000" max="99999" step="1" required>
                    </div>
                    <div class="form-group">
                        <label for="editcity">Stadt:</label>
                        <input class="form-control" type="text" id="editcity" name="city" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="editmemberdate">Ich bin ein Mitglied seit:</label>
                        <input class="form-control" type="date" id="editmemberdate" name="memberdate" max="<?=date('Y-m-d')?>">
                    </div>
                    <button class="btn btn-primary" type="submit" name="update" id="update">Speichern</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>