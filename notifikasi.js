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
function notifikasi(){
bacaDB():
let hariPengembalian = new Date(datapinjaman.data[0].return_date);
let tenggatPengembalian = Date.tenggatWaktu(hariPengembalian);

if (tenggatPengembalian < 3) {
    let pesan;
    if (tenggatPengembalian < 0)
        pesan = "Waktu Pengembalian buku sudah lewat " + tenggatPengembalian + " hari";
    else
        pesan = "Waktu Pengembalian buku " + tenggatPengembalian + " hari lagi";
    notifyPengembalian(pesan);
}
}
