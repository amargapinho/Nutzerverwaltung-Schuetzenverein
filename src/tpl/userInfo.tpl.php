<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mitglied Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="M_ID" hidden></span>
                <div class="d-flex justify-content-around">
                    <h5>Bogenabteilung<span id="1"></span></h5>
                    <h5>Luftdruck<span id="2"></span></h5>
                    <h5>Feuerwaffen<span id="3"></span></h5>
                </div>
                <h3 class="text-center">Kosten:<span id="total"></span></h3>
                <h3 class="text-center">Darf Mitglied eine Pistole kaufen: <span id="pistole"></span></h3>
                <hr>
                <label for="note">Notizen</label>
                <textarea class="form-control" id="note" oninput="updateNote(this)" maxlength="1700"></textarea>
                <hr>
                <a href="?" id="training" type="button" class="btn btn-primary">Mitglied ist heute erschienen.</a>
                <hr>
                <h3 class="text-center">Trainingsnachweis</h3>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Optionen</th>
                        </tr>
                    </thead>
                    <tbody id="trainingsnachweis">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>