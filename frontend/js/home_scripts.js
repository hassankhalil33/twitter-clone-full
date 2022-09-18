window.onload = () => {
  //
  // Variables
  //
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
  const cards = document.getElementById("cards");
  const profileName = document.querySelectorAll(".profile-name");
  const profileUsername = document.querySelectorAll(".profile-username");
  const profileDescription = document.getElementById("profile-description");
  const profileDate = document.getElementById("profile-date");
  const profileFollowing = document.getElementById("profile-following");
  const profileFollowers = document.getElementById("profile-followers");
  const follow = document.getElementById("follow");
  const block = document.getElementById("block");
  const newDescription = document.getElementById("new-description");
  const newFirstName = document.getElementById("new-first-name");
  const newLastName = document.getElementById("new-last-name");
  const updateProfileBtn = document.getElementById("update-profile");
  const searchInput = document.getElementById("search-input");
  const searchBtn = document.getElementById("search-btn");
  const searchResultsBox = document.getElementById("search-results-box");
  const tweetBtn = document.getElementById("tweet-btn");
  const tweetTextarea = document.getElementById("tweet-textarea");

  //
  // Functions
  //

  // Switch to home
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

  // Switch to profile
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

  // Open edit profile popup
  const openEditProfilePopup = () => {
    editProfileContainer.classList.remove("popup-hidden");
  };

  // Close edit profile popup
  const closeEditProfilePopup = () => {
    editProfileContainer.classList.add("popup-hidden");
  };

  // Fetch is_authorized api
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

  // Fetch view_feed api
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
          card += `<div class="flex-container card" id="${values.id}">
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
              <a class="like-tweet" href="">
                <img class="icons" src="images/like-icon.png" alt="" />
              </a>
              <p>${values.likes}</p>
            </div>
          </div>
        </div>`;
        });
        cards.innerHTML = card;

        const likeTweetBtns = document.querySelectorAll(".like-tweet");
        likeTweetBtns.forEach(like => {
          like.addEventListener("click", event => {
            event.preventDefault();
            likeTweet(like.parentElement.parentElement.parentElement.id);
          });
        });
      })
      .catch(error => console.log(error));
  }

  // Fetch view_profile api
  async function viewProfile(user) {
    await fetch(
      `http://localhost/fswo5/twitter-clone/view_profile.php?userName=${user}`
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
    if (user == localStorage.getItem("username")) {
      if (setupProfile.classList.contains("hidden")) {
        setupProfile.classList.remove("hidden");
        follow.classList.add("hidden");
        block.classList.add("hidden");
      } else {
        follow.classList.add("hidden");
        block.classList.add("hidden");
      }
    } else {
      localStorage.setItem("visited", user);
      if (setupProfile.classList.contains("hidden")) {
        follow.classList.remove("hidden");
        block.classList.remove("hidden");
      } else {
        setupProfile.classList.add("hidden");
        follow.classList.remove("hidden");
        block.classList.remove("hidden");
      }
    }
  }

  // Fetch update_profile api
  async function updateProfile() {
    const data = {
      firstName: newFirstName.value,
      lastName: newLastName.value,
      description: newDescription.value,
      photo: "",
      userName: localStorage.getItem("username"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/update_profile.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(location.reload())
      .catch(error => console.log(error));
  }

  // Fetch search_user api
  async function search() {
    const data = {
      userName: localStorage.getItem("username"),
      searchQuery: searchInput.value,
    };
    searchResultsBox.classList.remove("hidden");
    await fetch("http://localhost/fswo5/twitter-clone/search_user.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        let searchCard = ``;
        data.map(values => {
          searchCard += `<a class="search-res" href=""><div class="flex-container">
          <img class="card-pp" src="images/pp.png" alt="" />
          <div class="flex-column-container">
            <p class="nav-name">${values.f_name} ${values.l_name}</p>
            <p class="nav-username">${values.username}</p>
          </div>
          </div></a>
          `;
          searchResultsBox.innerHTML = searchCard;
        });
        searchResultsBox.innerHTML = searchCard;
        const searchRes = document.querySelectorAll(".search-res");
        searchRes.forEach(s => {
          s.addEventListener("click", event => {
            event.preventDefault();
            switchToProfile();
            viewProfile(s.children[0].children[1].children[1].innerText);
          });
        });
      })
      .catch(error => console.log(error));
  }

  // Fetch follow_user api
  async function followUser() {
    const data = {
      userName: localStorage.getItem("username"),
      followed: localStorage.getItem("visited"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/follow_user.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        console.log(data);
        if (follow.innerText == "Follow") {
          follow.innerText = "Followed";
          follow.classList.add("followed");
        } else {
          follow.innerText = "Follow";
          follow.classList.remove("followed");
        }
      })
      .catch(error => console.log(error));
  }

  // Fetch block_user api
  async function blockUser() {
    const data = {
      userName: localStorage.getItem("username"),
      blocked: localStorage.getItem("visited"),
    };
    await fetch("http://localhost/fswo5/twitter-clone/block_user.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        console.log(data);
        if (block.innerText == "block") {
          block.innerText = "blocked";
          block.classList.add("blocked");
        } else {
          block.innerText = "block";
          block.classList.remove("blocked");
        }
      })
      .catch(error => console.log(error));
  }

  // Fetch like_tweet api
  async function likeTweet(id) {
    const data = {
      userName: localStorage.getItem("username"),
      tweetId: id,
    };
    await fetch("http://localhost/fswo5/twitter-clone/like_tweet.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        console.log(data);
      })
      .catch(error => console.log(error));
  }

  // Fetch tweet_post api
  async function tweetPost() {
    const data = {
      userName: localStorage.getItem("username"),
      text: tweetTextarea.value,
    };
    await fetch("http://localhost/fswo5/twitter-clone/post_tweet.php", {
      method: "POST",
      body: new URLSearchParams(data),
    })
      .then(respone => respone.json())
      .then(data => {
        console.log(data);
      })
      .catch(error => console.log(error));
  }

  //
  //
  //
  if (isAuthorized()) {
    viewFeed();
  }

  //
  navHome.addEventListener("click", event => {
    event.preventDefault();
    switchToHome();
  });

  //
  navProfile.addEventListener("click", event => {
    event.preventDefault();
    switchToProfile();
    viewProfile(localStorage.getItem("username"));
  });

  //
  backToHome.addEventListener("click", switchToHome);

  //
  setupProfile.addEventListener("click", event => {
    event.preventDefault();
    openEditProfilePopup();
  });

  //
  cancelProfileEdit.addEventListener("click", closeEditProfilePopup);

  //
  updateProfileBtn.addEventListener("click", event => {
    event.preventDefault();
    updateProfile();
  });

  //
  searchBtn.addEventListener("click", search);

  //
  follow.addEventListener("click", event => {
    event.preventDefault();
    followUser();
  });

  //
  block.addEventListener("click", event => {
    event.preventDefault();
    blockUser();
  });

  //
  tweetBtn.addEventListener("click", event => {
    event.preventDefault();
    tweetPost();
  });
};
