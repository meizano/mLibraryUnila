var tampilanData = document.getElementById("tampilanData");
var db;

function indexedDBOk() {
    return "indexedDB" in window;
}

document.addEventListener("DOMContentLoaded", function () {

    //No support? Go in the corner and pout.
    if (!indexedDBOk) return;

    var openRequest = indexedDB.open("data_npm", 1);

    openRequest.onupgradeneeded = function (e) {
        var thisDB = e.target.result;

        if (!thisDB.objectStoreNames.contains("npm")) {
            thisDB.createObjectStore("npm");
        }
    }

    openRequest.onsuccess = function (e) {
        console.log("running onsuccess");

        db = e.target.result;

        //Listen for add clicks
        document.getElementById("btnAmbilData").addEventListener("click", FetchAPIGET);
    }

    openRequest.onerror = function (e) {
        console.log("error: ");
        //Do something for the error
    }

}, false);
var db;
var request = indexedDB.open("data_npm");
request.onerror = function (event) {
    console.log("Why didn't you allow my web app to use IndexedDB?!");
};
request.onsuccess = function (event) {
    db = event.target.result;
};

function FetchAPIGET() {
    var inputID = document.querySelector("#id").value;
    console.log('--------------------PINJAM----------------');
    console.log("About to add " + inputID);
    url = 'dispatcher/api.php/pinjam/' + inputID;
    fetch(url, {
            method: 'GET',
            cache: 'reload'
        })
        .then((resp) => resp.json())
        .then(function (aldi) {

            console.log('------------------------------------');
            console.log(aldi);
            console.log(aldi.hasil);
            console.log(aldi.data);
            console.log('------------------------------------');
            //Define a person
            var person = {
                member_id: inputID,
                created: new Date(),
                data: aldi
            }

            console.log(JSON.stringify(person));

            var transaction = db.transaction(["npm"], "readwrite");
            var store = transaction.objectStore("npm");

            //Perform the add
            var request = store.add(person, 1);

            request.onerror = function (e) {
                console.log("Error", e.target.error.member_id);
                //some type of error handler
            }

            request.onsuccess = function (e) {

                console.log("Woot! Did it");

            }
            tampilkanData(aldi);

        })
        .catch(function (error) {
            console.log(JSON.stringify(error));
        });
}

//Fungsi untuk memudahkan buat Node
function createNode(element) {
    // Membuat tipe elemen yang dilewatkan melalui parameter
    return document.createElement(element);
}

//Fungsi untuk menambahkan sub node di bawah Node
function append(parent, el) {
    // Append parameter kedua ke yang pertama
    return parent.appendChild(el);
}

// Fungsi untuk menampilkan data
function tampilkanData(dataRAW) {
    tampilanData.innerHTML = "status: " + dataRAW.status;
    // memakai fungsi pembuat elemen
    let table = createNode('table'),
        thead = createNode('thead'),
        th1 = createNode('th'),
        th2 = createNode('th'),
        th3 = createNode('th'),
        th4 = createNode('th');
    // memasukkan judul
    th1.innerHTML = 'Nama';
    th2.innerHTML = 'Judul';
    th3.innerHTML = 'Tangal Peminjaman';
    th4.innerHTML = 'Tangal Pengembalian';
    // memakai fungsi append ke parameter pertama
    append(thead, th1);
    append(thead, th2);
    append(thead, th3);
    append(thead, th4);
    append(table, thead);

    for (i = 0; i < dataRAW.data.length; i++) {
        let tr = createNode('tr'),
            td1 = createNode('td'),
            td2 = createNode('td'),
            td3 = createNode('td'),
            td4 = createNode('td');
        // memasukkan data ke dalam data tabel
        td1.innerHTML = dataRAW.data[i].member_name;
        td2.innerHTML = dataRAW.data[i].title;
        td3.innerHTML = dataRAW.data[i].loan_date;
        td4.innerHTML = dataRAW.data[i].return_date;
        // memakai fungsi append ke parameter pertama
        append(tr, td1);
        append(tr, td2);
        append(tr, td3);
        append(tr, td4);
        append(table, tr);
    }
    append(tampilanData, table);
}
//document.getElementById("btnAmbilData").addEventListener("click", FetchAPIGET);
