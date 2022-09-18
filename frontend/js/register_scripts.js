// Init Variables

const registerSignin = document.getElementById("register-signin");
const signinContainer = document.getElementById("signin-container");
const loginSignupBtn = document.getElementById("login-signup-btn");
const identificationInput = document.getElementById("identification-input");
const passwordInput = document.getElementById("password-input");
const loginSignin = document.getElementById("login-signin");
const registerMe = document.getElementById("register-me");
const firstName = document.getElementById("first-name");
const lastName = document.getElementById("last-name");
const userName = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");


// Functions

const openSigninPopup = () => {
    signinContainer.classList.toggle("popup-hidden");
};

const closeSigninPopup = () => {
    signinContainer.classList.toggle("popup-visible");
};

async function login() {
    const data = {
    userName: identificationInput.value,
    password: passwordInput.value,
    };

    await fetch("http://localhost/fswo5/twitter-clone/login.php", {
    method: "POST",
    body: new URLSearchParams(data),
    })
    .then(respone => respone.json())
    .then(data => {
        if (data == "username not found!") {
        alert("Wrong username!");
        } else if (data == "incorrect password") {
        alert("Incorrect password!");
        } else {
        localStorage.setItem("token", data);
        localStorage.setItem("username", identificationInput.value);
        location.replace("./feed.html");
        };
    });
};

async function register() {
    const data = {
    userName: userName.value,
    password: password.value,
    firstName: firstName.value,
    lastName: lastName.value,
    email: email.value,
    };

    await fetch("http://localhost/fswo5/twitter-clone/register.php", {
    method: "POST",
    body: new URLSearchParams(data),
    })
    .then(respone => respone.json())
    .then(data => {
        if (data == "success") {
        alert("Registered Successfully");
        } else {
        alert("Username / Email Already in Use");
        };
    });
};

// Script

window.onload = () => {
    registerSignin.addEventListener("click", openSigninPopup);
    loginSignupBtn.addEventListener("click", closeSigninPopup);
    loginSignin.addEventListener("click", event => {
        event.preventDefault();
        login();
    });

    registerMe.addEventListener("click", event => {
        event.preventDefault();
        register();
    });
};
