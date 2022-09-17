window.onload = () => {
  // variables
  const registerSignin = document.getElementById("register-signin");
  const signinContainer = document.getElementById("signin-container");
  const loginSignupBtn = document.getElementById("login-signup-btn");
  const identificationInput = document.getElementById("identification-input");
  const passwordInput = document.getElementById("password-input");
  const loginSignin = document.getElementById("login-signin");

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

    await fetch("http://localhost/fswo5/twitterclone/login.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        if (data == "username not found!") {
          alert("Wrong username!")
        } else if (data == "incorrect password") {
          alert("Incorrect password!")
        }else{

        }
      });
  }

  //
  registerSignin.addEventListener("click", openSigninPopup);
  loginSignupBtn.addEventListener("click", closeSigninPopup);
  loginSignin.addEventListener("click", event => {
    event.preventDefault();
    login();
  });
};
