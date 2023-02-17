let dialog1 = document.getElementById("dialog1");


function openDialog(value) {
  switch (value) {
    case "Delete Account":
      dialog1 = document.getElementById("dialog1");
      if (dialog1 != null) dialog1.style.display = "block";
      break;
    case "Delete Menu":
      dialog2 = document.getElementById("dialog2");
      if (dialog2 != null) dialog2.style.display = "block";
      break;  
    case "Delete Restaurant":
      dialog3 = document.getElementById("dialog3");
      if (dialog3 != null) dialog3.style.display = "block";
      break;   
  }
}

function closeDialog(value) {
  switch (value) {
    case "Delete Account":
      dialog1 = document.getElementById("dialog1");
      if (dialog1 != null) dialog1.style.display = "none";
      break;
    case "Delete Menu":
      dialog2 = document.getElementById("dialog2");
      if (dialog2 != null) dialog2.style.display = "none";
      break;
    case "Delete Restaurant":
      dialog3 = document.getElementById("dialog3");
      if (dialog3 != null) dialog3.style.display = "none";
      break;    
    
  }
}

