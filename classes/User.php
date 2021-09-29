<?php


class User{

    const DB_PATH = __DIR__ . '/../db/databank.db';

    const SECONDS_IN_YEAR = 31556926;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * User constructor.
     */
    public function __construct(){
        $this->pdo = new PDO('sqlite:' . self::DB_PATH);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getUsers(): array{
        $sql = 'SELECT * FROM Mitglieder INNER JOIN Adresse ON Mitglieder.M_ID = Adresse.M_ID INNER JOIN Name ON Mitglieder.M_ID = Name.M_ID WHERE Mitglieder.deleted = 0';
        return $this->pdo->query($sql)->fetchAll();
    }

    /**
     * @param string|int $id
     * @return array
     */
    public function getUserById($id): array{
        $sql = 'SELECT * FROM Mitglieder INNER JOIN Adresse ON Mitglieder.M_ID = Adresse.M_ID INNER JOIN Name ON Mitglieder.M_ID = Name.M_ID WHERE Mitglieder.M_ID = ? LIMIT 1';
        $statement = $this->pdo->prepare($sql);
        if($statement->execute(array($id))){
            return $statement->fetchAll();
        }
        return array();
    }

    /**
     * @param string|int $aID
     * @param string|int $userID
     * @return bool
     */
    public function addUserToAbteilung($aID, $userID): bool{
        $sql = 'INSERT INTO AbteilungenderMitglieder (A_ID, M_ID) VALUES(?, ?)';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($aID, $userID));
    }

    /**
     * @param string|int $aID
     * @param string|int $userID
     * @return bool
     */
    public function removeUserFromAbteilung($aID, $userID): bool{
        $sql = 'DELETE FROM AbteilungenDerMitglieder WHERE A_ID = ? AND M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($aID, $userID));
    }

    /**
     * @param string|int $aID
     * @param string|int $userID
     * @return bool
     */
    public function isUserInAbteilung($aID, $userID): bool{
        $sql = 'SELECT A_ID FROM AbteilungenDerMitglieder WHERE A_ID = ? AND M_ID = ? LIMIT 1';
        $statement = $this->pdo->prepare($sql);
        if($statement->execute(array($aID, $userID))){
            return !empty($statement->fetchAll());
        }
        return false;
    }

    /**
     * @param string|int $aID
     * @return mixed|null
     */
    public function aIDToName($aID){
        $sql = 'SELECT A_Name FROM Abteilungen WHERE A_ID = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array($aID));
        foreach ($statement->fetchAll() as $row){
            return $row['A_ID'];
        }
        return NULL;
    }

    /**
     * @param string $birthday
     * @return int
     */
    public function birthdayToAge(string $birthday): int{
        $birthdayTimeStamp = strtotime($birthday);
        $currentTimeStamp = strtotime(date('Y-m-d'));
        $ageTimeStamp = $currentTimeStamp - $birthdayTimeStamp;
        return (int)($ageTimeStamp / self::SECONDS_IN_YEAR);
    }

    /**
     * @param string $birthday
     * @return bool
     */
    public function isTodayBirthday(string $birthday): bool{
        return date('m-d', strtotime($birthday)) === date('m-d');
    }

    /**
     * @param string|int $userID
     * @return bool
     */
    public function userCanBuyGun($userID): bool{
        if($this->isMitgliedOverAYear($userID)){
            $count = $this->getTrainingnachweisCountThisYear($userID);
            if($count >= 18){
                return true;
            }else{
                #Nachweise sind mindestens 12 und alle 12 Monate sind vorhanden in den Trainingnachweis Monaten.
                return $count >= 12 && count(array_unique($this->getTrainingnachweisMonthsThisYear($userID))) === 12;
            }
        }
        return false;
    }

    /**
     * @param string|int $userID
     * @return bool
     */
    private function isMitgliedOverAYear($userID): bool{
        $sql = 'SELECT Eintrittsdatum FROM Mitglieder WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array($userID));
        foreach ($statement->fetchAll() as $row){
            return $row['Eintrittsdatum'] >= date('Y-m-d', strtotime('-1 year'));
        }
        return false;
    }

    /**
     * @param string|int $userID
     * @return mixed
     */
    private function getTrainingnachweisCountThisYear($userID){
        $sql = 'SELECT COUNT(*) FROM Trainingsnachweis WHERE M_ID = ? AND Trainingszeiten BETWEEN ? AND ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array($userID, date('Y-m-d'), date('Y-m-d', strtotime('-1 year'))));
        return $statement->fetchColumn();
    }

    /**
     * @param string|int $userID
     * @return array
     */
    private function getTrainingnachweisMonthsThisYear($userID): array{
        $months = array();
        $sql = 'SELECT Trainingszeiten FROM Trainingsnachweis WHERE M_ID = ? AND Trainingszeiten BETWEEN ? AND ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array($userID, date('Y-m-d'), date('Y-m-d', strtotime('-1 year'))));
        foreach ($statement->fetchAll() as $row){
            $months[] = (int) date('m', strtotime($row['Trainingszeiten']));
        }
        return $months;
    }

    /**
     * @param string|int $userID
     * @return bool
     */
    public function addTrainingsnachweis($userID): bool{
        $sql = 'INSERT INTO Trainingsnachweis (M_ID, Trainingszeiten) VALUES(?, ?)';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($userID, date('Y-m-d')));
    }

    /**
     * @param string|int $tID
     * @return bool
     */
    public function removeTrainingnachweis($tID): bool{
        $sql = 'DELETE FROM Trainingsnachweis WHERE T_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($tID));
    }

    /**
     * @param string|int $userID
     * @return array
     */
    public function getTrainingsnachweise($userID): array{
        $sql = 'SELECT Trainingszeiten, T_ID FROM Trainingsnachweis WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        if($statement->execute(array($userID))) {
            return $statement->fetchAll();
        }
        return array();
    }

    /**
     * @return bool
     */
    public function addUser(): bool{
        $telefonnummer = $_POST['telefon'] ?? null;
        $email = $_POST['email'] ?? null;
        return $this->addToMitglieder($_POST['birthday'], $_POST['memberdate'], $email, $telefonnummer) && $this->addToName($_POST['fname'], $_POST['lname']) && $this->addToAdresse($_POST['street'], $_POST['number'], $_POST['zipcode'], $_POST['city']) && $this->addUserToAbteilungen($this->getNewestUserId());
    }

    /**
     * @return int
     */
    public function getAbteilungsCount(): int{
        $sql = 'SELECT COUNT(*) FROM Abteilung';
        return (int)$this->pdo->query($sql)->fetchColumn();
    }

    /**
     * @param string $birthday
     * @param string $joinDate
     * @param string|null $email
     * @param string|null $telefonnummer
     * @return bool
     */
    public function addToMitglieder(string $birthday, string $joinDate, $email = '', $telefonnummer = ''): bool{
        $sql = 'INSERT INTO Mitglieder (Geburtstag, Eintrittsdatum, email, telefonnummer) VALUES(?, ?, ?, ?)';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($birthday, $joinDate, $email, $telefonnummer));
    }

    /**
     * @param string $fName
     * @param string $lName
     * @return bool
     */
    private function addToName(string $fName, string $lName): bool{
        $sql = 'INSERT INTO Name (fName, lName) VALUES (?, ?)';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($fName, $lName));
    }

    /**
     * @param string $street
     * @param string $hausnummer
     * @param string|int $plz
     * @param string $city
     * @return bool
     */
    private function addToAdresse(string $street, string $hausnummer, $plz, string $city): bool{
        $sql = 'INSERT INTO Adresse (Strasse, Hausnummer, PLZ, Ort) VALUES (?, ?, ?, ?)';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($street, $hausnummer, $plz, $city));
    }

    /**
     * @param mixed $message
     */
    public function sendAjax($message){
        if(is_array($message)){
            $message = json_encode($message);
        }
        echo $message;
    }

    /**
     * @param string|int $userID
     * @return array
     */
    public function getMitgliedAbteilungen($userID): array{
        $abteilungen = array();
        $sql = 'SELECT A_ID FROM AbteilungenDerMitglieder WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        if($statement->execute(array($userID))) {
            foreach ($statement->fetchAll() as $row) {
                $abteilungen[] = (int)$row['A_ID'];
            }
        }
        return $abteilungen;
    }

    /**
     * @param string|int $userID
     * @return int
     */
    public function getMitgliedCost($userID): int{
        $abteilungen = $this->getMitgliedAbteilungen($userID);
        $abteilungenCount = count($abteilungen);
        if($abteilungenCount > 1){
            return 18;
        }elseif ($abteilungenCount === 1){
            return $this->getAbteilungPrice($abteilungen[0]);
        }
        return 0;
    }

    /**
     * @param string|int $aID
     * @return int
     */
    private function getAbteilungPrice($aID): int{
        $sql = 'SELECT Price FROM Abteilung WHERE A_ID = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array($aID));
        foreach ($statement->fetchAll() as $row){
            return (int)$row['Price'];
        }
        return 0;
    }

    /**
     * @param float|int|string $number
     * @return string
     */
    public function numberToEuro($number): string{
        return number_format($number, 2, ',', '') . '€';
    }

    /**
     * @return false|PDOStatement
     */
    public function getAbteilungen(){
        $sql = 'SELECT * FROM Abteilung';
        return $this->pdo->query($sql);
    }

    /**
     * @param string|int $userID
     * @param string $birthday
     * @param string $joinDate
     * @param string $street
     * @param string|int $hausnummer
     * @param string|int $plz
     * @param string $city
     * @param string $fName
     * @param string $lName
     * @return bool
     */
    public function updateUser($userID, string $birthday, string $joinDate, string $street, $hausnummer, $plz, string $city, string $fName, string $lName, $email = '', $telefonnummer = ''): bool{
        return $this->updateMitglied($userID, $birthday, $joinDate, $email, $telefonnummer) && $this->updateAdresse($userID, $street, $hausnummer, $plz, $city) && $this->updateName($userID, $fName, $lName) && $this->removeUserFromAbteilungen($userID) && $this->addUserToAbteilungen($userID);
    }

    /**
     * @param string|int $userId
     * @return bool
     */
    private function removeUserFromAbteilungen($userId): bool{
        $sql = 'DELETE FROM AbteilungenDerMitglieder WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($userId));
    }


    /**
     * @param string|int $userID
     * @param string $birthday
     * @param string $joinDate
     * @param string|null $email
     * @param string|null $telefonnummer
     * @return bool
     */
    private function updateMitglied($userID, string $birthday, string $joinDate, $email = '', $telefonnummer = ''): bool{
        $sql = 'UPDATE Mitglieder SET Geburtstag = ?, Eintrittsdatum = ?, email = ?, telefonnummer = ? WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($birthday, $joinDate, $email, $telefonnummer,$userID));
    }

    /**
     * @param string|int $userID
     * @param string $street
     * @param string|int $hausnummer
     * @param string|int $plz
     * @param string $city
     * @return bool
     */
    private function updateAdresse($userID, string $street, $hausnummer, $plz, string $city): bool{
        $sql = 'UPDATE Adresse SET Strasse = ?, Hausnummer = ?, PLZ = ?, Ort = ? WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($street, $hausnummer, $plz, $city, $userID));
    }

    /**
     * @param string|int $userID
     * @param string $fName
     * @param string $lName
     * @return bool
     */
    private function updateName($userID, string $fName, string $lName): bool{
        $sql = 'UPDATE Name SET fName = ?, lName = ? WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($fName, $lName, $userID));
    }

    /**
     * @param string $date
     * @return false|string
     */
    public function dateToGerDate(string $date){
        return date('d.m.Y', strtotime($date));
    }

    /**
     * @param string|int $id
     * @return bool
     */
    public function removeUser($id): bool{
        $sql = 'UPDATE Mitglieder SET deleted = 1 WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($id));
    }

    /**
     * @return int
     */
    public function getNewestUserId(): int{
        $sql = 'SELECT MAX(M_ID) FROM Mitglieder';
        return (int)$this->pdo->query($sql)->fetchColumn();
    }

    /**
     * @param string|int $userId
     * @return bool
     */
    private function addUserToAbteilungen($userId): bool{
        $abteilungsCount = $this->getAbteilungsCount();
        for($i = 1;$i <= $abteilungsCount;$i++) {
            if (isset($_POST['department' . $i])) {
                if($this->addUserToAbteilung($i, $userId) === false){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param string|int $userId
     * @return string
     */
    public function getNote($userId): string{
        $sql = 'SELECT note FROM Mitglieder WHERE M_ID = ? LIMIT 1';
        $statement = $this->pdo->prepare($sql);
        if($statement->execute(array($userId))){
            foreach ($statement->fetchAll() as $row){
                return (string)$row['note'];
            }
        }
        return '';
    }

    /**
     * @param string|int $userId
     * @param string $note
     * @return bool
     */
    public function updateNote($userId, string $note): bool{
        $sql = 'UPDATE Mitglieder SET note = ? WHERE M_ID = ?';
        $statement = $this->pdo->prepare($sql);
        return $statement->execute(array($note, $userId));
    }

}