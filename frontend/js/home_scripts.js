window.onload = () => {
  // Variables
  const navHome = document.getElementById("nav-home");
  const navProfile = document.getElementById("nav-profile");
  const homePage = document.getElementById("home-page");
  const profilePage = document.getElementById("profile-page");
  const backToHome = document.getElementById("back-to-home");
  const setupProfile = document.getElementById("setup-profile");
  const editProfileContainer = document.getElementById(
    "edit-profile-container"
  );
  const cancelProfileEdit = document.getElementById("cancel-edit-profile");
  const nameArray = document.querySelectorAll(".name");
  const usernameArray = document.querySelectorAll(".username");
  let fullName, username;

  // Functions
  const switchToHome = () => {
    if (navHome.children[2].classList.contains("tab-not-selected")) {
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

  const openEditProfilePopup = () => {
    editProfileContainer.classList.remove("popup-hidden");
  };

  const closeEditProfilePopup = () => {
    editProfileContainer.classList.add("popup-hidden");
  };

  async function isAuthorized() {
    const data = {
      userName: localStorage.getItem("username"),
      token: localStorage.getItem("token"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/authorized.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        return data;
      })
      .catch(error => console.log(error));
  }

  async function view_feed() {
    const data = {
      userName: localStorage.getItem("username"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/view_feed.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        fullName = `${data[0][0].f_name} ${data[0][0].l_name}`;
        username = `@${data[0][0].username}`;
        displayData();
        console.log(data[1][0]);
      })
      .catch(error => console.log(error));
  }

  const displayData = () => {
    nameArray.forEach(elt => (elt.innerText = fullName));
    usernameArray.forEach(elt => (elt.innerText = username));
  };
  //
  if (isAuthorized()) {
    view_feed();
  }

  navHome.addEventListener("click", event => {
    event.preventDefault();
    switchToHome();
  });
  navProfile.addEventListener("click", event => {
    event.preventDefault();
    switchToProfile();
  });
  backToHome.addEventListener("click", switchToHome);

  setupProfile.addEventListener("click", event => {
    event.preventDefault();
    openEditProfilePopup();
  });
  cancelProfileEdit.addEventListener("click", closeEditProfilePopup);
};
