document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.querySelector('form[action="upload-profile.php"]');
    
    profileForm.addEventListener('submit', function (e) {
        const profilePicInput = document.getElementById('profilePic');
        
        if (!profilePicInput.files.length) {
            e.preventDefault(); // Prevent form submission if no file selected
            alert('Please select a profile picture to upload.');
        }
    });

    // Optional: Display selected file name
    document.getElementById('profilePic').addEventListener('change', function () {
        const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        alert(`Selected file: ${fileName}`);
    });
});
