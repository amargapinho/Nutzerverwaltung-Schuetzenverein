<?php
/**
 * @var User $user
 */
?>
<div class="container">
    <div class="col-12">
        <h1 class="text-center">Mitglieder Liste</h1><br><br><br>
        <table class="table table-striped table-bordered table-responsive" id="userTable">
            <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Straße</th>
                    <th>Hausnummer</th>
                    <th>PLZ</th>
                    <th>E-Mail</th>
                    <th>Telefonnummer</th>
                    <th>Mitglied Seit</th>
                    <th>Geburtstag</th>
                    <th>Optionen</th>
                </tr>
            </thead>
            <tbody>
            <?php $query = $user->getUsers();?>
            <?php if(!empty($query)):?>
                <?php foreach ($user->getUsers() as $mitglied):?>
                    <tr>
                        <th><?=$mitglied['fName']?></th>
                        <th><?=$mitglied['lName']?></th>
                        <th><?=$mitglied['Strasse']?></th>
                        <th><?=$mitglied['Hausnummer']?></th>
                        <th><?=$mitglied['PLZ']?></th>
                        <th><?=empty($mitglied['email']) ? '' : $mitglied['email']?></th>
                        <th><?=empty($mitglied['telefonnummer']) ? '' : $mitglied['telefonnummer']?></th>
                        <th><span hidden><?=$mitglied['Eintrittsdatum']?></span><?=$user->dateToGerDate($mitglied['Eintrittsdatum'])?></th>
                        <th><span hidden><?=$mitglied['Geburtstag']?></span><?=$user->dateToGerDate($mitglied['Geburtstag'])?><?=$user->isTodayBirthday($mitglied['Geburtstag']) ? '<img title="Hat heute Geburtstag" src="/src/img/birthday-cake-solid.svg" alt="Hat heute Geburtstag" width="24" height="24">' : ''?><br>(<?=$user->birthdayToAge($mitglied['Geburtstag'])?> Jahre alt)</th>
                        <th>
                            <div class="d-flex justify-content-around">
                                <button title="Infos" type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#detailsModal" onclick="requestInfo(<?=$mitglied['M_ID']?>)"><img src="/src/img/info-solid.svg" alt="Infos" width="32" height="32"></button>
                                <button title="Bearbeiten" type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#editUser" onclick="requestUser(<?=$mitglied['M_ID']?>)"><img src="/src/img/edit-solid.svg" alt="Bearbeiten" width="32" height="32"></button>
                                <a title="Löschen" href="?removeUser=<?=$mitglied['M_ID']?>" class="btn btn-outline-danger"><img src="/src/img/trash-solid.svg" alt="Löschen" height="32" width="32"></a>
                            </div>
                        </th>
                    </tr>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>
    </div>
</div>