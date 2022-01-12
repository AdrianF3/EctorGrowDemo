let json_data = {
  "version":1.10,
  "pageTitleA": "Page A Title",
  "pageDescripA": "Page A Description",
  "pageUrlA": "Page A Url",
  "pageTitleB": "Page B Title",
  "pageDescripB": "Page B Description",
  "pageUrlB": "Page B Url",
 }
;

$(document).ready(function() {
  //Event Listener For Attribution Modal
   $('[data-toggle="popover"]').popover({html:true});

   //NON-Working Function
   // loadJSON(function(response) {
   //   // Parsing JSON string into object
   //  json_data = JSON.parse(response);
   // });

   //Call Meta Override to update Titles and Meta Descriptions
   metaOverride();

   //Version #
   let buildVersion = 0.01;
   console.log("Current Build: " + json_data.version + " | Developed by AFWebDev.com");



});



//Begin Function To Override Meta Title and Description
function metaOverride() {
  let pageTitle = "###";
  let pageDescrip = "###";

  //possibly use switch for logic?
  let cur_url = window.location.href;
  switch (cur_url) {
    case '###':
      //Change Title
      document.title = servicesTitle;
      //Change Description
      document.querySelector('meta[name="description"]').content = servicesDescrip;
      break;
    case '###':
      //Change Title
      document.title = aboutTitle;
      //Change Description
      document.querySelector('meta[name="description"]').content = aboutDescrip;
      break;
    default:
  }
}
//End of metaOverride function



function loadJSON(callback) {

   var xobj = new XMLHttpRequest();
       xobj.overrideMimeType("application/json");
   xobj.open('GET', 'js/data.json', true);
   xobj.onreadystatechange = function () {
         if (xobj.readyState == 4 && xobj.status == "200") {
           // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
           callback(xobj.responseText);
         }
   };
   xobj.send(null);
}

function getPlantData(id) {
  if (id.length == 0) {
    document.getElementById("strainName").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("strainName").innerHTML = this.responseText;
        document.getElementById("origin").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "scripts/getPlantData.php?id=" + id, true);
    xmlhttp.send();
  }
}
