
let currentPage = 1;

function updatePlace() {
    var userTypeSelect = document.getElementById('userType');
    var placeInput = document.getElementById('place');

    switch (userTypeSelect.value) {
        case 'faculty':
        case 'staff':
            placeInput.value = "Beside Kadasig Gym";
            break;
        case 'student':
            placeInput.value = "Beside the CME Building";
            break;
        case 'visitor':
            placeInput.value = "Front";
            break;
        default:
            placeInput.value = "";
            break;
    }
}


function nextPage(nextPageId) {
    const currentForm = document.getElementById(`page${currentPage}`);
    const nextForm = document.getElementById(nextPageId);

    if (currentPage === 1) {
        // Validation logic for Page 1 remains unchanged
    } else if (currentPage === 2) {
        // Validation logic for the newly created Page 2
    }

    currentForm.style.display = 'none';
    nextForm.style.display = 'block';
    currentPage++;
}

function prevPage(prevPageId) {
    const currentForm = document.getElementById(`page${currentPage}`);
    const prevForm = document.getElementById(prevPageId);

    currentForm.style.display = 'none';
    prevForm.style.display = 'block';
    currentPage--;
}
