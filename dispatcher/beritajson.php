<?php


    ## BAGIAN 1 MENGOLAH HTML MENJADI OBYEK PHP ##
    # Mengambil HTML
    // $url = "http://library.unila.ac.id/web/;
    $url = "http://localhost/git/mLibraryUnila/dispatcher/weblibunila.html";

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

    # Himpunan/kumpulan daftar pustaka yang ditemukan berdasarkan <div class="item">
    $nlist = $xpath->query("//article"); 
    
    # Mendapatkan link/tautan halaman berikutnya berdasarkan <a class="next_link">
    $nextLink = $xpath->query("//div[@class='nav-previous']");

    # Jika satu halaman
    $nLink = NULL;
    # Jika lebih dari satu halaman, maka dibuat link halaman berikut
    # ditambahkan absolute URL karena tautan yang tersimpan masih menggunakan relative URL
    if($nextLink->item(0) != NULL) {
        $nLink = $nextLink->item(0)->childNodes->item(0)->attributes->item(0)->nodeValue;
    }

    ## AKHIR BAGIAN 1 MENGOLAH HTML MENJADI OBYEK PHP ##

    ## BAGIAN 2 MEMBUAT RESPON KELUARAN JSON DARI OBYEK PHP ##
    /* JSON */
    # Obyek $respon menampung seluruh nilai yang akan diekspor ke JSON
    $respon =  new stdClass();

    # Memberikan label, Sebagai penanda bahwa ini adalah data dari opac.unila.ac.id
    $respon->label="library.unila.ac.id/web";

    # Penampung nilai yang akan dimasukkan ke dalam obyek $respon
    $no = 0; // sebagai nomor urut
    $judul = ''; // judul 
    $tanggal = ''; // tanggal
    $pengarang = ''; // pengarang 
    $berita = ''; // berita
    $tautan = ''; // tautan menuju rincian 

    # Menjadikan kumpulan elemen pada $nslist menjadi sebuah obyek $item (yang mewakili satu buah daftar pustaka)
    foreach($nlist as $item) { // array of article
        # Menjadikan setiap elemen dom di dalam obyek $item sebagai $ite
        foreach($item->childNodes as $ite) { // single article
            // print_r($ite);
            # Menjadikan setiap elemen dom di dalam obyek $ite sebagai $it
            if($ite->nodeName == 'header') {
                foreach($ite->childNodes as $it) {
                    // print_r($it);
                    # jika ada $it yang memiliki tag html h2, dimasukkan sebagai nilai $judul
                    if($it->nodeName == 'h2') {
                        $judul = $it->nodeValue;
                        // print_r($it->childNodes->item(0)->attributes->item(0)->nodeValue);
                        $tautan = $it->childNodes->item(0)->attributes->item(0)->nodeValue;
                        continue;
                    }
                    
                    
                
                    # jika ada tag pada $it yang memiliki atribut, diperiksa disini
                    # Agar tidak muncul warning https://stackoverflow.com/questions/2385834/php-dom-get-all-attributes-of-a-node
                    if ($it->hasAttributes()) {
                        foreach($it->childNodes as $t) {
                            # Agar tidak muncul warning https://stackoverflow.com/questions/2385834/php-dom-get-all-attributes-of-a-node
                            if ($t->hasAttributes()) {
                                foreach($t->attributes as $i) {
                                    # jika ada yang memiliki atribut 'author', dimasukkan sebagai nilai $pengarang
                                    if($i->nodeValue == 'posted-on') {
                                        $tanggal = $t->childNodes->item(0)->childNodes->item(0)->nodeValue;
                                    } 
                                    # jika ada yang memiliki atribut 'entry-content', dimasukkan sebagai nilai $berita
                                    else if($i->nodeValue == 'byline') {
                                        $pengarang = $t->nodeValue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
            if ($ite->hasAttributes()) {
                if($ite->attributes->item(0)->nodeValue == 'entry-content') {
                    $berita = $ite->nodeValue;

                }
            }
        }
        
        

        # Menambahkan data yang dikumpulkan dari $item dan menyusunnya sesuai keperluan ke dalam key data
        # $no digunakan sebagai indeks dari data
        $respon->data[$no]=array($judul, $tanggal, $pengarang, $berita, $tautan);//ambil yang perlu saja
        
        # setelah data satuan ditambahkan ke key data, indeks ditambahkan satu
        $no+=1;
    }

    # Menambahkan informasi link/tautan ke halaman berikut
    $respon->nextLink=$nLink;

    echo json_encode($respon);
    /* JSON */
    ## AKHIR BAGIAN 2 MEMBUAT RESPON KELUARAN JSON DARI OBYEK PHP ##
?>