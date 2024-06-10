function manageOpeningEdit(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById('opening_div_edit').classList.remove("d-none");
    } else {
        document.getElementById('opening_div_edit').classList.add("d-none");
    }
}

function manageClosingEdit(checkboxItem) {
    if (checkboxItem.checked) {
        document.getElementById('closing_div_edit').classList.remove("d-none");
    } else {
        document.getElementById('closing_div_edit').classList.add("d-none");
    }
}
