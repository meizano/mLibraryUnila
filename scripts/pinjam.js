var tampilanData = document.getElementById("tampilanData");
var db;
var datapinjaman = [];

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
        document.getElementById("btnAmbilData").addEventListener("click", FetchAPIGET, bacaDB);
    }

    openRequest.onerror = function (e) {
        console.log("error: ");
        //Do something for the error
    }

}, false);

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

            //Perform the delete
            var request = store.delete(0);
        
            request.onerror = function (e) {
                console.log("Error", e.target.error.member_id);
                //some type of error handler
            }

            request.onsuccess = function (e) {

                console.log("Berhasil menghapus");

            }

            //Perform the add
            var request = store.add(person, 1);

            request.onerror = function (e) {
                console.log("Error", e.target.error.member_id);
                //some type of error handler
            }

            request.onsuccess = function (e) {

                console.log("Berhasil menambahkan");

            }
            tampilkanData(aldi);

        })
        .catch(function (error) {
            console.log(JSON.stringify(error));
        });
}

function getObjectStore(store_name, mode) {
    var store = db.transaction(store_name, mode);
    return store.objectStore(store_name);
}

function bacaDB() {

    var store = getObjectStore("npm", 'readonly');


    req = store.openCursor();
    req.onsuccess = function (evt) {
        var cursor = evt.target.result;

        // If the cursor is pointing at something, ask for the data
        if (cursor) {
            // console.log(cursor);
            req = store.get(cursor.key);
            req.onsuccess = function (evt) {
                var value = evt.target.result;
                datapinjaman.push(value);
                console.log(value);
                console.log(value.member_id);
                console.log(value["member_id"]);
                console.log(value.data.data[0].return_date);
                //                console.log(value.loan_date);
                //                console.log(value.member_name);
                //                console.log(value.return_date);
                //                console.log(value.title);
            };

            // Move on to the next object in store
            cursor.continue();


        } else {
            console.log("No more entries");
        }
    };
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
        th4 = createNode('th'),
        th5 = createNode('th');
    // memasukkan judul
    th1.innerHTML = 'Nama';
    th2.innerHTML = 'Judul';
    th3.innerHTML = 'Tanggal Peminjaman';
    th4.innerHTML = 'Batas Waktu';
    th5.innerHTML = 'Tanggal Pengembalian';
    // memakai fungsi append ke parameter pertama
    append(thead, th1);
    append(thead, th2);
    append(thead, th3);
    append(thead, th4);
    append(thead, th5);
    append(table, thead);

    for (i = 0; i < dataRAW.data.length; i++) {
        let tr = createNode('tr'),
            td1 = createNode('td'),
            td2 = createNode('td'),
            td3 = createNode('td'),
            td4 = createNode('td'),
            td5 = createNode('td');
        // memasukkan data ke dalam data tabel
        td1.innerHTML = dataRAW.data[i].member_name;
        td2.innerHTML = dataRAW.data[i].title;
        td3.innerHTML = dataRAW.data[i].loan_date;
        td4.innerHTML = dataRAW.data[i].due_date;
        td5.innerHTML = dataRAW.data[i].return_date;
        // memakai fungsi append ke parameter pertama
        append(tr, td1);
        append(tr, td2);
        append(tr, td3);
        append(tr, td4);
        append(tr, td5);
        append(table, tr);
    }
    append(tampilanData, table);
}
//document.getElementById("btnAmbilData").addEventListener("click", FetchAPIGET); 
