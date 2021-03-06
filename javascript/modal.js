//https://tigu.hk.tlu.ee/~andrus.rinde/2022kevad/vr/styles/modal.css

let photoDir = "gallery_upload_normal/";
let phptpId;

window.onload = function () {
    // kõik pisipildid paneme dialoogiakent avama
    let allThumbs = document.querySelector(".thumbgallery").querySelectorAll(".thumbs");
    for (let i = 0; i < allThumbs.length; i++) {
        allThumbs[i].addEventListener("click", openModal);
    }
    document.querySelector("#modalclose").addEventListener("click", closeModal);
    document.querySelector("#modalimage").addEventListener("click", closeModal);
}

function openModal(e) {
    photoId = e.target.dataset.id;
    for (let i = 1; i < 6; i++) {
        document.querySelector("#rate" + i).checked = false;
    }
    document.querySelector("#storeRating").addEventListener("click", storeRating);
    document.querySelector("#modalimage").src = photoDir + e.target.dataset.filename;
    document.querySelector("#modalcaption").innerHTML = e.target.alt;
    document.querySelector("#modal").showModal();
}

function closeModal() {
    document.querySelector("#modal").close();
}

function storeRating() {
    let rating = 0;
    for (let i = 1; i < 6; i++) {
        //console.log(i)
        if (document.querySelector("#rate" + i).checked) {
            rating = i;
        }
    }
    if (rating > 0) {
        //salvestame
        //saadame info serverisse PFP skriptile, mis salvestab ja tagastab kliendile värskendatud keskmise hinde
        //AJAX
        //Asynchroneus Javascript And XML
        let webRequest = new XMLHttpRequest();
        //oleme valmis eduks ja kui asjad toimivad, siis jälgime, kas õnnestus
        webRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                //kõik, mida teha, kui tuli vastus
                document.querySelector("#avgrating").innerHTML = this.responseText;
                document.querySelector("#storeRating").removeEventListener("click", storeRating);
            }
        };
        //paneme tööle
        //  store_photorating.php?photo=4&rating=5
        webRequest.open("GET", "store_photorating.php?photo=" + photoId + "&rating=" + rating, true);
        webRequest.send();
    }//if rating > 0 lõppeb
}