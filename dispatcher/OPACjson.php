<?php
# Jika tidak ada parameter GET yang dikirimkan, tidak ada respon yang diberikan
if($_GET){
    # Jika input type tidak ada, diberi nilai NULL
    $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : NULL;

    ## BAGIAN 1 MENGOLAH HTML MENJADI OBYEK PHP ##
    # Mengambil HTML
    // $url = "http://opac.unila.ac.id/index.php?search=search&keywords=" . $keywords;
    $url = "http://localhost/git/mLibraryUnila/dispatcher/OPACjamur.html";

    # Use the Curl extension to query and get back a page of results
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $html = curl_exec($ch);
    curl_close($ch);

    # Create a DOM parser object
    $dom = new DOMDocument();

    # Parse the HTML.
    # The @ before the method call suppresses any warnings that
    # loadHTML might throw because of invalid HTML in the page.
    @$dom->loadHTML($html);
    # Mencetak HTML
    // print_r($dom->saveHTML());

    # Create DOMXPath Object and load DOMDocument Object into XPath for magical goodness
    $xpath = new DOMXPath($dom);

    # returns list
    # Mencari nilai berdasarkan persyaratan kondisi query
    # Informasi jumlah hasil pencarian
    $infoJumlahLengkap = $xpath->query("//div[@class='search-found-info']");
    $infoJumlah = $infoJumlahLengkap;
    $infoJumlahValue = $infoJumlah->item(0)->nodeValue;
    // echo $infoJumlahValue;
    # Informasi kata kunci pencarian
    $infoKataKunci = $xpath->query("//span[@class='search-keyword-info']");
    $infoKataKunciValue = $infoKataKunci->item(0)->nodeValue;
    // echo $infoKataKunciValue;
    # Informasi kata kunci pencarian
    $infoWaktu = $xpath->query("//div[@class='search-query-time']");
    $infoWaktuValue = $infoWaktu->item(0)->nodeValue;
    // echo $infoWaktuValue;

    # Himpunan/kumpulan daftar pustaka yang ditemukan berdasarkan <div class="item">
    $nlist = $xpath->query("//div[@class='item']"); 
    
    # Mendapatkan link/tautan halaman berikutnya berdasarkan <a class="next_link">
    $nextLink = $xpath->query("//a[@class='next_link']");

    # Jika satu halaman
    $nLink = NULL;
    # Jika lebih dari satu halaman, maka dibuat link halaman berikut
    # ditambahkan absolute URL karena tautan yang tersimpan masih menggunakan relative URL
    if($nextLink->item(0) != NULL)
        $nLink = 'http://opac.unila.ac.id' . $nextLink->item(0)->attributes->item(0)->nodeValue;

    ## AKHIR BAGIAN 1 MENGOLAH HTML MENJADI OBYEK PHP ##

    ## BAGIAN 2 MEMBUAT RESPON KELUARAN JSON DARI OBYEK PHP ##
    /* JSON */
    # Obyek $respon menampung seluruh nilai yang akan diekspor ke JSON
    $respon =  new stdClass();

    # Memberikan label, Sebagai penanda bahwa ini adalah data dari opac.unila.ac.id
    $respon->label="opac.unila.ac.id";
    
    # Memasukkan informasi jumlah hasil pencarian ke dalam obyek $respon
    $respon->info=$infoJumlahValue;

    # Penampung nilai yang akan dimasukkan ke dalam obyek $respon
    $no = 0; // sebagai nomor urut
    $judul = ''; // judul pustaka
    $pengarang = ''; // pengarang pustaka
    $callNumber = ''; // nomor panggil pustaka
    $tersedia = ''; // ketersediaan pustaka
    $cantuman = ''; // tautan menuju rincian pustaka

    # Menjadikan kumpulan elemen pada $nslist menjadi sebuah obyek $item (yang mewakili satu buah daftar pustaka)
    foreach($nlist as $item) {
        # Menjadikan setiap elemen dom di dalam obyek $item sebagai $ite
        foreach($item->childNodes as $ite) {
            # Menjadikan setiap elemen dom di dalam obyek $ite sebagai $it
            foreach($ite->childNodes as $it) {
                # jika ada $it yang memiliki tag html h4, dimasukkan sebagai nilai $judul
                if($it->nodeName == 'h4') {
                    $judul = $it->nodeValue;
                    continue;
                }
                # jika ada tag pada $it yang memiliki atribut, diperiksa disini
                # Agar tidak muncul warning https://stackoverflow.com/questions/2385834/php-dom-get-all-attributes-of-a-node
                if ($it->hasAttributes()) {
                    foreach($it->attributes as $i) {
                        # jika ada yang memiliki atribut 'author', dimasukkan sebagai nilai $pengarang
                        if($i->nodeValue == 'author') {
                            $pengarang = $it->nodeValue;
                        } 
                        # jika ada yang memiliki atribut 'customField callNumberField', dimasukkan sebagai nilai $callNumber
                        else if($i->nodeValue == 'customField callNumberField') {
                            $callNumber = $it->nodeValue;
                        } 
                        # jika ada yang memiliki atribut 'customField availabilityField', dimasukkan sebagai nilai $tersedia
                        else if($i->nodeValue == 'customField availabilityField') {
                            $tersedia = $it->nodeValue;
                        } 
                        # jika ada yang memiliki atribut 'subItem', dimasukkan sebagai nilai $cantuman
                        # ditambahkan absolute URL karena tautan yang tersimpan masih menggunakan relative URL
                        else if($i->nodeValue == 'subItem') {
                            $cantuman = 'http://opac.unila.ac.id' . $it->childNodes->item(0)->attributes->item(0)->nodeValue;
                        }
                    }
                }

            }
        }

        # Menambahkan data yang dikumpulkan dari $item dan menyusunnya sesuai keperluan ke dalam key data
        # $no digunakan sebagai indeks dari data
        $respon->data[$no]=array($judul, $pengarang, $callNumber, $tersedia, $cantuman);//ambil yang perlu saja
        
        # setelah data satuan ditambahkan ke key data, indeks ditambahkan satu
        $no+=1;
    }

    # Menambahkan informasi link/tautan ke halaman berikut
    $respon->nextLink=$nLink;

    echo json_encode($respon);
    /* JSON */
    ## AKHIR BAGIAN 2 MEMBUAT RESPON KELUARAN JSON DARI OBYEK PHP ##
}
?>