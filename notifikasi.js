function notifyPengembalian(hari) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification(hari);
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification(hari);
            }
        });
    }

    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}

Notification.requestPermission().then(function (result) {
    console.log(result);
});

function spawnNotification(body, icon, title) {
    var options = {
        body: body,
        icon: icon
    };
    var n = new Notification(title, options);
}

Date.tenggatWaktu = function (hrPengembalian) {
    //Get 1 day in milliseconds
    var one_day = 1000 * 60 * 60 * 24;

    // Convert both dates to milliseconds
    let date1_ms = Date.now();
    let date2_ms = hrPengembalian.getTime();

    // Calculate the difference in milliseconds
    let difference_ms = date2_ms - date1_ms;
    // Convert back to days and return
    return Math.round(difference_ms / one_day);
}

// Proses olah per buku
// Iterasi seluruh item pada indexedDB
// Akses tanggal pengembalian setiap buku
function notifyPesan(){

    // Menyalin nilai obyek datapinjaman[0].data.data ke pinjaman
    let pinjaman = datapinjaman[0].data.data;

    let pesan = "";
    // Melakukan iterasi terhadap obyek pinjaman
    for( pinjam in pinjaman) {
        // mengambil nilai return_date
        let hariTerakhirPengembalian = pinjaman[pinjam].return_date;

        // Jika belum dikembalikan ~ nilai return_date null, berikan notifikasi
        // komen baris di bawah ini untuk menguji notifikasi
        if(hariTerakhirPengembalian == null) {
            
            let hariPengembalian = new Date(pinjaman[pinjam].due_date);

            let tenggatPengembalian = Date.tenggatWaktu(hariPengembalian);

            // mengambil nilai title
            let judulPustaka = pinjaman[pinjam].title;
        
            // Jika pengembalian menjelang 3 hari atau kurang
            if (tenggatPengembalian < 3) {
                
                // Jika pengembalian sudah lewat hari
                if (tenggatPengembalian < 0)
                    pesan += judulPustaka + " sudah lewat " + tenggatPengembalian + " hari; ";
                else
                    pesan += judulPustaka + " " + tenggatPengembalian + " hari lagi; ";
   
            }
        // komen baris di bawah ini untuk menguji notifikasi
        }
    }

    // Jika ada buku yang harus dikembalikan menjelang 3 hari atau kurang, lakukan notifikasi
    if(pesan != "")
        notifyPengembalian("Pengembalian: " + pesan);
}

function notifikasi() {
    // Membaca data dari IndexedDB dan meletakkan nilainya pada obyek datapinjaman setelah 1 detik
    window.setTimeout(bacaDB, 1*1000);

    // Menjalankan notifikasi setelah 2 detik
    window.setTimeout(notifyPesan, 2*1000);
}

notifikasi();