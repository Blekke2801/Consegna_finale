function ricerca() {
    var ricerca = document.getElementById("search").value;
    location.href = "Home.php?page=cerca&ricerca=" + ricerca;
}

function show() {
    var free = document.getElementById("free");
    var show = document.getElementById("showOffer");
    if (free.checked) {
        show.innerHTML = '<img src="../img/Free.jpg"><br><span>Potrai vedere tutti i film che vuoi,<br/> ma in una lista limitata</span>';
    } else {
        show.innerHTML = '<img src=".. / img / Premium.jpg "><br><span>Potrai vedere tutti i film che vuoi!<br>Senza limitazioni!</span>';
    }
}