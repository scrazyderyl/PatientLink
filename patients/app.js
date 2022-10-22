"use strict"

const INDICATORS = document.getElementById("indicators");
const MEDICATIONS = document.getElementById("medication");
const INSRTUCTIONS = document.getElementById("instructions");
const NOTES = document.getElementById("notes");

function HTTPRequest(method, path, async, data, callback) {
    var request = new XMLHttpRequest();

    if (callback) {
        request.addEventListener("readystatechange", function () {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    if (this.responseText) {
                        callback(JSON.parse(this.responseText));
                    } else {
                        callback(null);
                    }
                } else {
                    if (this.status === 0) {
                        alert("Network Failure");
                    } else {
                        alert("Something went wrong! Status Code: " + this.status);
                    }
                }
            }
        });
    }

    request.open(method, path, async);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send(data);
}

var medications;

HTTPRequest("post", "/api/getMeds.php", false, "id=3", function(response) {
    medications = response;
});

for (let i = 0; i < medications.length; i++) {
    let medication = medications[i];
    let container = document.createElement("div");
    container.classList.add("medication-info");

    let container2 = document.createElement("div");
    container2.classList.add("medication-name");
    container.appendChild(container2);
    
    let name = document.createElement("p");
    name.classList.add("drug-name");
    name.textContent = `${medication.drug}`;
    container2.appendChild(name);

    let button = document.createElement("button");
    button.textContent = "Mark as complete";
    container2.appendChild(button);

    let dosage = document.createElement("p");
    dosage.textContent = `Dosage: ${medication.dosage} times per ${medication.doseInterval}`;
    container.appendChild(dosage);

    let instructions = document.createElement("p");
    instructions.textContent = `Instructions: ${medication.instructions}`;
    container.appendChild(instructions);

    MEDICATIONS.appendChild(container);
}

var indicators = [{name: "Glucose", ave: 110, min: 104, max: 119}, {name: "Blood pressure: Systolic", ave: 110, min: 94, max: 124}, {name: "Blood pressure: Diastolic", ave: 74, min: 68, max: 84}];

for (let i = 0; i < indicators.length; i++) {
    let indicator = indicators[i];
    let element = document.createElement("p");
    element.textContent = `${indicator.name} — Average: ${indicator.ave} / Min: ${indicator.min} / Max: ${indicator.max}`;
    element.classList.add("indicator");
    INDICATORS.appendChild(element);
}