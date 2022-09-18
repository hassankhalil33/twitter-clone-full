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
  const nameNav = document.getElementById("name-nav");
  const usernameNav = document.getElementById("username-nav");
  let fullName, username;
  const cards = document.getElementById("cards");
  const profileName = document.querySelectorAll(".profile-name");
  const profileUsername = document.querySelectorAll(".profile-username");
  const profileDescription = document.querySelectorAll(".profile-description");
  const profileDate = document.getElementById("profile-date");
  const profileFollowing = document.getElementById("profile-following");
  const profileFollowers = document.getElementById("profile-followers");

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

  async function viewFeed() {
    const data = {
      userName: localStorage.getItem("username"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/view_feed.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        nameNav.innerText = `${data[0][0].f_name} ${data[0][0].l_name}`;
        usernameNav.innerText = `@${data[0][0].username}`;
        let card = ``;
        data[1].map(values => {
          card += `<div class="flex-container card">
          <img class="card-pp" src="images/pp.png" alt="" />
          <div class="flex-column-container card-content">
            <div class="flex-container card-head">
              <p class="nav-name">${values.f_name} ${values.l_name}</p>
              <p class="nav-username">@${values.username}</p>
              <p class="date">${values.time}</p>
            </div>
            <p class="card-text">
              ${values.text}
            </p>
            <img
              class="card-img"
              src="images/twitter-cover-page.png"
              alt="" />
            <div class="flex-container">
              <a href="">
                <img class="icons" src="images/like-icon.png" alt="" />
              </a>
              <p>${values.likes}</p>
            </div>
          </div>
        </div>`;
        });
        cards.innerHTML = card;
      })
      .catch(error => console.log(error));
  }

  async function viewProfile() {
    await fetch(
      `http://localhost/fswo5/twitter-clone/view_profile.php?userName=${localStorage.getItem(
        "username"
      )}`
    )
      .then(respone => respone.json())
      .then(data => {
        profileName.forEach(pN => {
          pN.innerHTML = `${data[0].f_name} ${data[0].l_name}`;
        });
        profileUsername.forEach(pU => {
          pU.innerHTML = `@${data[0].username}`;
        });
        profileDescription.innerText = data[0].description;
        profileDate.innerText = data[0].date_of_joining;
        profileFollowing.innerText = data[0].following;
        profileFollowers.innerText = data[0].followers;
      })
      .catch(error => console.log(error));
  }

  //
  if (isAuthorized()) {
    viewFeed();
  }

  navHome.addEventListener("click", event => {
    event.preventDefault();
    switchToHome();
  });
  navProfile.addEventListener("click", event => {
    event.preventDefault();
    switchToProfile();
    if (isAuthorized()) {
      viewProfile();
    }
  });
  backToHome.addEventListener("click", switchToHome);

  setupProfile.addEventListener("click", event => {
    event.preventDefault();
    openEditProfilePopup();
  });
  cancelProfileEdit.addEventListener("click", closeEditProfilePopup);
};
