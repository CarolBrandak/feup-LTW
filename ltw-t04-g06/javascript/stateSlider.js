var slider = document.getElementById("myRange");
var output = document.getElementById("State");
output.innerHTML = slider.value;

var labels = ['Received', 'Preparing', 'Ready', 'Delivered'];

slider.value = 0;
sliderInputChange();


slider.oninput = sliderInputChange;

function sliderInputChange() {
  var val = slider.value;
  var unit = 12.5;
  var optionNum;

  if (val <= 25) {
    slider.value = unit;
    optionNum = 1;
  } else if (val <= 50) {
    slider.value = 25 + unit;
    optionNum = 2;
  } else if (val <= 75) {
    slider.value = 50 + unit;
    optionNum = 3;
  } else {
    slider.value = 75 + unit;
    optionNum = 4;
  }
  output.innerHTML = 'State: ' + labels[optionNum - 1];
}