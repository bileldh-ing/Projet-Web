const swiper = new Swiper(".swiper-container", {
  loop: true, // Enable infinite loop
  slidesPerView: 3, // Show only 3 cards at a time
  spaceBetween: 20, // Space between cards
  navigation: {
    nextEl: "#right", // Right arrow (span with id 'right')
    prevEl: "#left", // Left arrow (span with id 'left')
  },
  breakpoints: {
    576: {
      slidesPerView: 1, // Show 1 card per slide on small screens
    },
    768: {
      slidesPerView: 2, // Show 2 cards per slide on medium screens
    },
    992: {
      slidesPerView: 3, // Show 3 cards per slide on large screens
    },
  },
});
const sentences = [
  "your perfect home",
  "the key to your dream home",
  "the home you've always imagined",
];

let currentSentenceIndex = 0;
let textPosition = 0;
let isDeleting = false;
const speed = 120; // typing speed
const deleteSpeed = 60; // deletion speed

const element = document.querySelector("h4 em").nextElementSibling; // Selects the part after <em>Discover</em>

function typeEffect() {
  const currentSentence = sentences[currentSentenceIndex];

  if (isDeleting) {
    element.textContent = currentSentence.substring(0, textPosition - 1);
    textPosition--;

    if (textPosition === 0) {
      isDeleting = false;
      currentSentenceIndex = (currentSentenceIndex + 1) % sentences.length;
    }
  } else {
    element.textContent = currentSentence.substring(0, textPosition + 1);
    textPosition++;

    if (textPosition === currentSentence.length) {
      isDeleting = true;
    }
  }

  setTimeout(typeEffect, isDeleting ? deleteSpeed : speed);
}

typeEffect();
function handleSearch() {
  const searchText = document.getElementById("searchText").value.toLowerCase(); // Get search query
  const content = document.body; // The entire page content to search through
  const matches = []; // To store all the found elements

  // Clear previous highlights
  const highlightedElements = document.querySelectorAll(".highlight");
  highlightedElements.forEach((el) => {
    el.classList.remove("highlight");
  });

  if (searchText === "") {
    return; // If search input is empty, do nothing
  }

  // Find all the text nodes in the body
  const walker = document.createTreeWalker(
    content,
    NodeFilter.SHOW_TEXT,
    null,
    false
  );

  while (walker.nextNode()) {
    const node = walker.currentNode;
    const text = node.nodeValue.toLowerCase();

    // Check if the text node contains the search term
    if (text.includes(searchText)) {
      // Create a range to highlight the text
      const range = document.createRange();
      const startIndex = text.indexOf(searchText);
      const endIndex = startIndex + searchText.length;

      range.setStart(node, startIndex);
      range.setEnd(node, endIndex);

      // Wrap the found text in a span with a class to highlight
      const span = document.createElement("span");
      span.classList.add("highlight");
      range.surroundContents(span);

      matches.push(span); // Add to matches
    }
  }

  // If there are matches, scroll to the first one
  if (matches.length > 0) {
    const firstMatch = matches[0];
    firstMatch.scrollIntoView({ behavior: "smooth", block: "center" });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const profileLink = document.getElementById("profile-link");
  const dropdownMenu = document.getElementById("dropdown-menu");
  const logoutBtn = document.getElementById("logout-btn");
  const profileUsername = document.getElementById("profile-username");

  // Retrieve user data from localStorage
  const user = localStorage.getItem("user");

  if (user) {
    // Parse the user data from localStorage (Assuming it's stored as a stringified JSON object)
    const userData = JSON.parse(user);

    // Set the username in the profile link
    profileUsername.textContent = userData.username || "Profile"; // If username exists, set it; else default to 'Profile'
  } else {
    // If no user is logged in, display 'Profile'
    profileUsername.textContent = "Profile";
  }

  // Toggle the dropdown menu when clicking on the Profile link
  profileLink.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link action
    dropdownMenu.style.display =
      dropdownMenu.style.display === "block" ? "none" : "block";
  });

  // Close the dropdown menu if the user clicks outside
  document.addEventListener("click", function (event) {
    if (
      !profileLink.contains(event.target) &&
      !dropdownMenu.contains(event.target)
    ) {
      dropdownMenu.style.display = "none";
    }
  });

  // Log out the user and redirect to the sign-up page
  logoutBtn.addEventListener("click", function () {
    // Clear user data from localStorage
    localStorage.removeItem("user");

    // Redirect to the sign-up page
    window.location.href = "signup.html";
  });
});
