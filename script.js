
$(document).ready(function () {

    $("#registrationForm").on("submit", function (event) {

        let valid = true;
        let messages = [];

        const name = $("#name").val().trim();
        const usn = $("#usn").val().trim();
        const email = $("#email").val().trim();
        const phone = $("#phone").val().trim();
        const department = $("#department").val();
        const semester = $("#semester").val();
        const address = $("#address").val().trim();

        if (!/^[a-zA-Z ]{3,50}$/.test(name)) {
            valid = false;
            messages.push("Enter a valid name.");
        }

        if (!/^[a-zA-Z0-9-]{5,20}$/.test(usn)) {
            valid = false;
            messages.push("Enter a valid USN.");
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            valid = false;
            messages.push("Enter a valid email.");
        }

        if (!/^[0-9]{10}$/.test(phone)) {
            valid = false;
            messages.push("Phone number must have 10 digits.");
        }

        if (department === "") {
            valid = false;
            messages.push("Select your department.");
        }

        if (semester === "") {
            valid = false;
            messages.push("Select your semester.");
        }

        if (address === "" || address.length > 300) {
            valid = false;
            messages.push("Enter a valid address.");
        }

        if (!valid) {
            event.preventDefault();
            alert(messages.join("\n"));
        }

    });

});
