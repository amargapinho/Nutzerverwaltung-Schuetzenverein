/**
 *
 * @param {string} url
 * @param {Function|null} func
 */
function ajaxRequest(url, func) {
    const xhttp = new XMLHttpRequest();
    if(func !== null) {
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                func(this.responseText);
            }
        };
    }
    xhttp.open("GET", url, true);
    xhttp.send();
}

/**
 *
 * @param {string|number} id
 */
function requestInfo(id){
    ajaxRequest("ajax.php?loadInfo=" + id, loadInfo);
}

/**
 *
 * @param {string|number} id
 */
function requestUser(id){
    ajaxRequest("ajax.php?loadUser=" + id, loadEditUser);
}


/**
 *
 * @param {string} response
 */
function loadInfo(response){
    setButtonDisabled(false);
    response = JSON.parse(response);
    display(response);
    setM_ID(response.M_ID);
    setTraining();
    setNote(response.note);
    setPrice(response.price);
    for (let i = 1;i <= 3;i++){
        let abteilung = document.getElementById(i.toString());
        abteilung.innerText = "";
        if(response.abteilungen.includes(i)){
            abteilung.append(getCheckIcon());
        }else {
            abteilung.append(getCancelIcon());
        }
    }
    setPistole(response.pistole);
}

/**
 *
 * @param {number|string} price
 */
function setPrice(price){
    document.getElementById("total").innerText = formatEuro(price);
}

/**
 *
 * @param response
 */
function display(response) {
    const tn = response.trainingsnachweise;
    const length = tn.length;
    let htmltext = "";
    const currentDate = getCurrentDate();
    for (let i = 0; i < length; i++) {
        if(currentDate === tn[i]["Trainingszeiten"]){
            setButtonDisabled(true);
        }
        htmltext += "<tr><th>"+tn[i]["Trainingszeiten"]+"</th><th><div class='d-flex justify-content-around'><a class='btn btn-outline-danger' href='?removeTraining="+tn[i]["T_ID"]+"'><img src='/src/img/trash-solid.svg' width='32' height='32'></a></div></th></tr>";
    }
    document.getElementById("trainingsnachweis").innerHTML = htmltext;
}

/**
 *
 * @param {boolean} disabled
 */
function setButtonDisabled(disabled){
    const trainingButton = document.getElementById("training");
    trainingButton.disabled = disabled;
    if(disabled){
        trainingButton.style.pointerEvents = "none";
    }else{
        trainingButton.style.pointerEvents = "";
    }
}

/**
 *
 * @param {string} response
 */
function loadEditUser(response){
    const prefix = "edit";
    response = JSON.parse(response);
    setValueById(prefix + "fname", response.fName);
    setValueById(prefix + "lname", response.lName);
    setValueById(prefix + "birthday", response.Geburtstag);
    if(response.email != null) {
        setValueById(prefix + "email", response.email);
    }
    if(response.telefonnummer != null){
        setValueById(prefix + "telefon", response.telefonnummer);
    }
    setValueById(prefix + "street", response.Strasse);
    setValueById(prefix + "number", response.Hausnummer);
    setValueById(prefix + "zipcode", response.PLZ);
    setValueById(prefix + "city", response.Ort);
    setValueById(prefix + "memberdate", response.Eintrittsdatum);
    setValueById("update", response.M_ID);
    for (let i = 1;i <= 3;i++){
        document.getElementById(prefix + "department" + i).checked = response.abteilungen.includes(i);
    }
}

/**
 *
 * @param {string|number} id
 * @param {string|number} value
 */
function setValueById(id, value){
    document.getElementById(id).value = value;
}

function updateNote(note){
    note = {"note": note.value};
    const url = "ajax.php?updateNote&userId=" + getM_ID() + "&" + jQuery.param(note);
    ajaxRequest(url, null);
}

/**
 *
 * @returns {string}
 */
function getM_ID(){
    return document.getElementById("M_ID").innerText;
}

/**
 *
 * @returns {string}
 */
 function getT_ID(){
    return document.getElementById("T_ID").innerText;
}

/**
 *
 * @returns {HTMLImageElement}
 */
function getCancelIcon(){
    const cancelIcon = getImage();
    cancelIcon.setAttribute("src", "/src/img/times-solid.svg");
    return cancelIcon;
}

/**
 *
 * @returns {HTMLImageElement}
 */
function getImage(){
    const img = document.createElement("img");
    img.setAttribute("width", "32");
    img.setAttribute("height", "32");
    return img;
}

/**
 *
 * @returns {HTMLImageElement}
 */
function getCheckIcon(){
    const checkIcon = getImage();
    checkIcon.setAttribute("src", "/src/img/check-solid.svg");
    return checkIcon;
}

function setTraining(){
    const href = "?addTrainingsnachweis=" + getM_ID();
    document.getElementById("training").setAttribute("href", href);
}

/**
 *
 * @param {string|number} text
 */
function setM_ID(text){
    document.getElementById("M_ID").innerText = text;
}

/**
 *
 * @param {string} note
 */
function setNote(note){
    document.getElementById("note").value = note;
}

/**
 *
 * @returns {string}
 */
function getCurrentDate(){
    const date = new Date();
    let month = date.getUTCMonth() + 1;
    if(month < 10){
        month = "0" + month;
    }
    let day = date.getDate();
    if(day < 10){
        day = "0" + day;
    }
    return date.getFullYear() + "-" + month + "-" + day;
}

/**
 *
 * @param {string|number} number
 * @returns {string}
 */
function formatEuro(number){
    return new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(number).toString();
}

/**
 *
 * @param {boolean} pistole
 */
function setPistole(pistole){
    const span = document.getElementById("pistole");
    if(pistole){
        span.innerText = "Ja";
    }else{
        span.innerText = "Nein";
    }
}

