
document.addEventListener("DOMContentLoaded", function () {

  var closeButton = document.querySelector(".close");

  if(closeButton){
    closeButton.addEventListener("click", togglePopup);
  }

});

var popup = document.querySelector(".popup");
function togglePopup() {
    popup.classList.toggle("show");
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
/*btn.onclick = function() {
  modal.style.display = "block";
  
}*/
// When the user clicks on <span> (x), close the modal
if(span){
  span.onclick = function() {
    modal.style.display = "none";
  }
}

// Get the getOfferBtn button that will show the offer
var getOfferbtn = document.getElementById("getOfferBtn");

// When the user clicks the button, open the modal 
if(getOfferbtn){
  getOfferbtn.onclick = function() {
    var flipCardInner = document.getElementsByClassName("flip-card-inner")[0];
    flipCardInner.classList.toggle('flip-card-inner-transform');
    this.disabled=true;


    var signUpBtnATag = document.getElementById("signUpBtnATag");
    document.getElementById("signUpBtnATag").style.display = 'block';
    this.style.display = 'none';
  }
  
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}




/*********Scratch card ***************************************/


let canvas = document.getElementById("overlayCanvas");
let context = null;
if(canvas){
  context = canvas.getContext("2d");
}

//initially mouse X and Y positions are 0
let mouseX = 0;
let mouseY = 0;
let isDragged = false;
// Events for touch and mouse
let events = {
	mouse: {
		down: "mousedown",
		move: "mousemove",
		up: "mouseup"
	},
	touch: {
		down: "touchstart",
		move: "touchmove",
		up: "touchend"
	}
};
let deviceType = "";
//Detect touch device
const is_touch_device = () => {
	try {
		//We try to create TouchEvent (it would fail for desktops and throw error)
		document.createEvent("TouchEvent");
		deviceType = "touch";
		return true;
	} catch (e) {
		deviceType = "mouse";
		return false;
	}
};


let gradientColor = context? context.createLinearGradient(0, 0, 135, 135): null;
if(context){
  gradientColor.addColorStop(0, "#C3A3F1");
  gradientColor.addColorStop(1, "#6414E9");
  context.fillStyle = gradientColor;
  
}

var element = document.getElementById("overlayCanvas");

if(element && context){
  context.fillRect(0, 0, element.clientWidth, element.clientHeight);
}

//get left and top of canvas
let rectLeft = 0;
let rectTop = 0;
if(canvas){
  rectLeft = canvas.getBoundingClientRect().left;
  rectTop = canvas.getBoundingClientRect().top;
  
}

//exact x and y position of mouse/touch
const getXY = (e) => {
	mouseX = (!is_touch_device() ? e.pageX : e.touches[0].pageX) - rectLeft;
	mouseY = (!is_touch_device() ? e.pageY : e.touches[0].pageY) - rectTop;
};

const scratch = (x, y) => {
  if(context){
    // destination-out draws new shapes behind the existing canvas content.
    context.globalCompositeOperation = "destination-out";
    context.beginPath();
    //arc makes circle- x,y,radius,start angle, end angle
    context.arc(x, y, 25, 0, 2 * Math.PI);
    context.fill();
  }
};

is_touch_device();
if(canvas){
  // start scratch
  canvas.addEventListener(events[deviceType].down, (event) => {
    isDragged = true;
    //get x and y position
    getXY(event);
    scratch(mouseX, mouseY);
  });

  //mousemove/touchmove
  canvas.addEventListener(events[deviceType].move, (event) => {
    if (!is_touch_device()) {
      event.preventDefault();
    }
    if (isDragged) {
      getXY(event);
      scratch(mouseX, mouseY);
    }
  });

  // stop drawing
  canvas.addEventListener(events[deviceType].up, () => {
    isDragged = false;
  });

  // if mouse leaves the square
  canvas.addEventListener("mouseleave", () => {
    isDragged = false;
  });

}


/**************************************************************************************/

