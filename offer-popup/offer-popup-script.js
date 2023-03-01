
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
let context = canvas.getContext("2d");
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


let gradientColor = context.createLinearGradient(0, 0, 135, 135);
gradientColor.addColorStop(0, "#C3A3F1");
gradientColor.addColorStop(1, "#6414E9");
context.fillStyle = gradientColor;

var element = document.getElementById("overlayCanvas");

if(element){
  context.fillRect(0, 0, element.clientWidth, element.clientHeight);
}

//get left and top of canvas
let rectLeft = canvas.getBoundingClientRect().left;
let rectTop = canvas.getBoundingClientRect().top;

//exact x and y position of mouse/touch
const getXY = (e) => {
	mouseX = (!is_touch_device() ? e.pageX : e.touches[0].pageX) - rectLeft;
	mouseY = (!is_touch_device() ? e.pageY : e.touches[0].pageY) - rectTop;
};

const scratch = (x, y) => {
	// destination-out draws new shapes behind the existing canvas content.
	context.globalCompositeOperation = "destination-out";
	context.beginPath();
	//arc makes circle- x,y,radius,start angle, end angle
	context.arc(x, y, 25, 0, 2 * Math.PI);
	context.fill();
};

is_touch_device();
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

/**************************************************************************************/



/**********************************************************************************************
 * 
 * Spin wheel js
 * 
 */

/* --------------- Spin Wheel  --------------------- */
const spinWheel = document.getElementById("spinWheel");
const spinBtn = document.getElementById("spin_btn");
const text = document.getElementById("text");
/* --------------- Minimum And Maximum Angle For A value  --------------------- */
const spinValues = [
  { minDegree: 61, maxDegree: 120, value: 100 },
  { minDegree: 0, maxDegree: 60, value: 300 },
  { minDegree: 301, maxDegree: 360, value: 500 },
  { minDegree: 241, maxDegree: 300, value: 700 },
  { minDegree: 181, maxDegree: 240, value: 900 },
  { minDegree: 121, maxDegree: 180, value: 1100 },
];
/* --------------- Size Of Each Piece  --------------------- */
const size = [10, 10, 10, 10, 10, 10];
/* --------------- Background Colors  --------------------- */
var spinColors = [
  "#E74C3C",
  "#7D3C98",
  "#2E86C1",
  "#138D75",
  "#F1C40F",
  "#D35400"
];
/* --------------- Chart --------------------- */
/* --------------- Guide : https://chartjs-plugin-datalabels.netlify.app/guide/getting-started.html --------------------- */
let spinChart = new Chart(spinWheel, {
  plugins: [ChartDataLabels],
  type: "pie",
  data: {
    labels: [1, 2, 3, 4, 5, 6],
    datasets: [
      {
        backgroundColor: spinColors,
        data: size,
      },
    ],
  },
  options: {
    responsive: true,
    animation: { duration: 0 },
    plugins: {
      tooltip: false,
      legend: {
        display: false,
      },
      datalabels: {
        rotation: 90,
        color: "#ffffff",
        formatter: (_, context) => context.chart.data.labels[context.dataIndex],
        font: { size: 24 },
      },
    },
  },
});
/* --------------- Display Value Based On The Angle --------------------- */
const generateValue = (angleValue) => {
  for (let i of spinValues) {
    if (angleValue >= i.minDegree && angleValue <= i.maxDegree) {
      text.innerHTML = `<p>Congratulations, You Have Won $${i.value} ! </p>`;
      spinBtn.disabled = false;
      break;
    }
  }
};
/* --------------- Spinning Code --------------------- */
let count = 0;
let resultValue = 101;
spinBtn.addEventListener("click", () => {
  spinBtn.disabled = true;
  text.innerHTML = `<p>Best Of Luck!</p>`;
  let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);
  let rotationInterval = window.setInterval(() => {
    spinChart.options.rotation = spinChart.options.rotation + resultValue;
    spinChart.update();
    if (spinChart.options.rotation >= 360) {
      count += 1;
      resultValue -= 5;
      spinChart.options.rotation = 0;
    } else if (count > 15 && spinChart.options.rotation == randomDegree) {
      generateValue(randomDegree);
      clearInterval(rotationInterval);
      count = 0;
      resultValue = 101;
    }
  }, 10);
});
/* --------------- End Spin Wheel  --------------------- */


