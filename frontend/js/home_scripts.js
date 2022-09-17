window.onload = () => {
  // Variables
  const navHome = document.getElementById("nav-home");
  const navProfile = document.getElementById("nav-profile");
  const homePage = document.getElementById("home-page");
  const profilePage = document.getElementById("profile-page");

  // Functions
  const switchToHome = () => {
    if (navHome.children[2].classList.contains("tab-not-selected")) {
      console.log("psss");
      navHome.children[0].classList.toggle("hidden");
      navHome.children[1].classList.toggle("hidden");
      navProfile.children[0].classList.toggle("hidden");
      navProfile.children[1].classList.toggle("hidden");
      navHome.children[2].classList.add("tab-selected");
      navHome.children[2].classList.remove("tab-not-selected");
      navProfile.children[2].classList.add("tab-not-selected");
      navProfile.children[2].classList.remove("tab-selected");
      homePage.classList.toggle("hidden");
      profilePage.classList.toggle("hidden");
    }
  };

  const switchToProfile = () => {
    if (navProfile.children[2].classList.contains("tab-not-selected")) {
      console.log("jajs");
      navHome.children[0].classList.toggle("hidden");
      navHome.children[1].classList.toggle("hidden");
      navProfile.children[0].classList.toggle("hidden");
      navProfile.children[1].classList.toggle("hidden");
      navHome.children[2].classList.remove("tab-selected");
      navHome.children[2].classList.add("tab-not-selected");
      navProfile.children[2].classList.remove("tab-not-selected");
      navProfile.children[2].classList.add("tab-selected");
      homePage.classList.toggle("hidden");
      profilePage.classList.toggle("hidden");
    }
  };

  //
  navHome.addEventListener("click", event => {
    event.preventDefault();
    switchToHome();
  });

  navProfile.addEventListener("click", event => {
    event.preventDefault();
    switchToProfile();
  });
};
