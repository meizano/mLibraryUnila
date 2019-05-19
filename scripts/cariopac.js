// Cari OPAC
let cariOPAC = document.getElementById('cariOPAC');
let keywordOPAC = document.querySelector('form#cariOPAC [name="keywords"]');
let hasilOPAC = document.getElementById('hasilOPAC');

cariOPAC.addEventListener('click', function () {
   fetchOPAC(keywordOPAC.value);
});

// Mengambil data JSON dari server
function fetchOPAC(kata) {
    var url = './dispatcher/OPACjson.php?keywords=' + kata; // URL dari data JSON
    fetch(url)
        .then((resp) => resp.json())
        .then(function (data) {
            hasilOPAC.classList.remove("alert", "alert-warning", "alert-success"); 
            hasilOPAC.innerHTML = `
            Hasil: ${data['info']}
            <br/>
            `;
            
            for (let i = 0; i < data['data'].length; i++) {
                hasilOPAC.innerHTML += `
                <span>${i+1}</span>
                <a target="_blank" href="${data['data'][i][4]}" >${data['data'][i][0]}</a>
                <span>${data['data'][i][1]}</span>
                <span>${data['data'][i][2]}</span>
                <span>${data['data'][i][3]}</span>
                <br/>
                `;
            }

            hasilOPAC.classList.add("alert", "alert-success");
            
        })
        .catch(function (error) {
            hasilOPAC.classList.remove("alert", "alert-warning",  "alert-success");
            hasilOPAC.innerHTML = JSON.stringify(error);
            hasilOPAC.classList.add("alert", "alert-warning");
        });
};