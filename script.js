function toggleMenu() {

    const menu = document.getElementById("navMenu");

    menu.classList.toggle("show");

}


function validateRegister() {

    const name =
        document.getElementById("name").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const password =
        document.getElementById("password").value;


    if (name.length < 3) {

        alert("Name must contain at least 3 characters.");

        return false;

    }


    if (password.length < 6) {

        alert("Password must contain at least 6 characters.");

        return false;

    }


    return true;

}