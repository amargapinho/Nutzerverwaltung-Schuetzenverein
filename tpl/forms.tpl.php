<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mitglied Hinzufügen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="fname">Vorname:</label>
                        <input class="form-control" type="text" id="fname" name="fname" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Nachname:</label>
                        <input class="form-control" type="text" id="lname" name="lname" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Geburtstag:</label>
                        <input class="form-control" type="date" id="birthday" name="birthday" max="<?=date('Y-m-d')?>" required>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="department1" name="department1" value="achery">
                        <label class="form-check-label" for="department1">Ich bin in der Bogenabteilung</label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="department2" name="department2" value="airpressure">
                        <label class="form-check-label" for="department2"> Ich bin in der Luftdruck Abteilung</label>
                    </div>
                    <div class="form-group">
                        <input class="form-check-inline" type="checkbox" id="department3" name="department3" value="firearms">
                        <label class="form-check-label" for="department3"> Ich bin in der Feuerwaffen Abteilung</label>
                    </div>
                    <div class="form-group">
                        <label for="email">Geben Sie ihre E-Mail an:</label>
                        <input class="form-control" type="email" id="email" name="email" maxlength="255">
                    </div>
                    <div class="form-group">
                        <label for="telefon">Telefonnummer:</label>
                        <input type="text" class="form-control" id="telefon" name="telefon" maxlength="255" pattern="^([+](\d{1,3})\s?)?((\(\d{3,5}\)|\d{3,5})(\s)?)\d{3,8}$">
                    </div>
                    <p>Bitte geben Sie ihre Adresse an</p>
                    <div class="form-group">
                        <label for="street">Straße:</label>
                        <input class="form-control" type="text" id="street" name="street" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="number">Hausnummer:</label>
                        <input class="form-control" type="number" id="number" name="number" min="1" step="1" required>
                    </div>
                    <div class="form-group">
                        <label for="zipcode">PLZ:</label>
                        <input class="form-control" type="text" id="zipcode" name="zipcode" min="10000" max="99999" step="1" required>
                    </div>
                    <div class="form-group">
                        <label for="city">Stadt:</label>
                        <input class="form-control" type="text" id="city" name="city" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="memberdate">Ich bin ein Mitglied seit:</label>
                        <input class="form-control" type="date" id="memberdate" name="memberdate" max="<?=date('Y-m-d')?>">
                    </div>
                    <button class="btn btn-primary" type="submit" name="addUser">Speichern</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>