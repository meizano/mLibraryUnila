var tampilkanData = document.getElementById("tampilanData");

        function Fetchlogin() {
            var inputID = document.getElementById("id").value;
            url = 'api.php/pinjam/' + inputID;
            fetch(url,
                    {
                        method: 'GET',
                        cache: 'reload'
                    }
                 )
                .then((resp) => resp.json())
                .then(function(data) {
                    tampilkanData(data);
                })
                .catch(function(error) {
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
        function tampilkanDatatampilkanData(dataRAW) {
            tampilkanData.innerHTML = "Status: " + dataRAW.status;
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
            th3.innerHTML = 'Tangal Peminjaman';       th4.innerHTML = 'Tangal Pengembalian';
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
            append(tampilkanData, table);
        }
        document.getElementById("btnAmbilData").addEventListener("click", Fetchlogin);