// Cari Union Catalog
let cariUniUca = document.getElementById('cariUniUca');
let keywordUniUca = document.querySelector('form#cariUniUca [name="keywords"]');
let hasilUniUca  = document.getElementById('hasilUniUca');

cariUniUca.addEventListener('click', function () {
   fetchUniUca(keywordUniUca.value);
});

// Mengambil data JSON dari server
function fetchUniUca(kata) {
    var url = './dispatcher/UniUcajson.php?keywords=' + kata; // URL dari data JSON
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
            hasilUniUca.classList.remove("alert", "alert-warning", "alert-success");
            
            hasilUniUca.innerHTML = `
            Hasil: ${data['info']}
            <br/>
            `;
            
            for (let i = 0; i < data['data'].length; i++) {
                hasilUniUca.innerHTML += `
                <span>${i+1}</span>
                <a target="_blank" href="${data['data'][i][4]}" >${data['data'][i][0]}</a>
                <span>${data['data'][i][1]}</span>
                <span>${data['data'][i][2]}</span>
                <span>${data['data'][i][3]}</span><br/>
                <br/>
                `;
            }

            hasilUniUca.classList.add("alert", "alert-success");
            
        })
        .catch(function (error) {
            hasilUniUca.classList.remove("alert", "alert-warning",  "alert-success");
            hasilUniUca.innerHTML = JSON.stringify(error);
            hasilUniUca.classList.add("alert", "alert-warning");
        });
};