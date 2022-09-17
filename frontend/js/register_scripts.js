window.onload = () => {
  // variables
  const registerSignin = document.getElementById("register-signin");
  const signinContainer = document.getElementById("signin-container");
  const loginSignupBtn = document.getElementById("login-signup-btn");

  // Functions
  const openSigninPopup = () => {
    signinContainer.classList.toggle("popup-hidden");
    console.log("open");
  };
  const closeSigninPopup = () => {
    signinContainer.classList.toggle("popup-visible");
  };

  //
  registerSignin.addEventListener("click", openSigninPopup);
  loginSignupBtn.addEventListener("click", closeSigninPopup);
};
