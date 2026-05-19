function searchMedicine() {
    let input = document.getElementById('searchBar').value;
    let category = document.getElementById('categoryFilter').value;
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('medicineList').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../controllers/SearchController.php?q=" + input + "&category=" + category, true);
    xhttp.send();
}