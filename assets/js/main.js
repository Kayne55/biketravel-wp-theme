// Scroll to Top Button
//Get the button:
mybutton = document.getElementById("bt-scrolltop");

// When the user scrolls down 20px from the top of the document, show the button
/*window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}*/

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    document.getElementById("navbar").style.padding = ".25rem .5rem";
    document.getElementById("bt-header-brand").style.maxWidth = "70px";
    mybutton.style.display = "block";
  } else {
    document.getElementById("navbar").style.padding = ".5rem 1rem";
    document.getElementById("bt-header-brand").style.maxWidth = "100px";
    mybutton.style.display = "none";
  }
}

// Video Modal Popup
// Open the Modal
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

// Close the Modal
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

// Add focus Styles for Keyboard User

function handleFirstTab(e) {
  if (e.keyCode === 9) { // the "I am a keyboard user" key
      document.body.classList.add('user-is-tabbing');
      window.removeEventListener('keydown', handleFirstTab);
  }
}

window.addEventListener('keydown', handleFirstTab);

// BT Accordions
var acc = document.getElementsByClassName("bt-accordion-heading");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("bt-active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

// BT Fullscreen Navigation Overlay

function fullScreenNav() {
  document.getElementById('bt-NavOverlay').style.height = "100%";
}
function fullScreenNavClose() {
  document.getElementById('bt-NavOverlay').style.height = "0%";
}