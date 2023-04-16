
//Circle color based on avarave pollutant
const color_pollutant = {
    "low":"#00FF00",
    "moderate":"#FFA500",
    "high":"FF0000",
    "very_high":"#6A0DAD",
}   

//Function name: getName
//Description: Gets station name value from a XML document
//Parameters: rec: 
//Return: string
function getName(root){
    return root.getAttribute('name');
}

//Function name: getGeocode
//Description: Gets geocode value from a XML document
//Parameters: rec: 
//Return: string
function getGeocode(root){
    return root.getAttribute('geocode');
}

//Function name: getNox
//Description: Gets Nox value from a XML document
//Parameters: rec: 
//Return: float
function getNox(rec){
    var nox = parseFloat(rec.getAttribute('nox'))
    if(isNaN(nox)){
        return 0.0;
    }
    return nox;
}

//Function name: getNo2
//Description: Gets No2 value from a XML document
//Parameters: rec: 
//Return: float
function getNo2(rec){
    var no2 = parseFloat(rec.getAttribute('no2'))
    if(isNaN(no2)){
        return 0.0;
    }
    return no2;
}

//Function name: getNo
//Description: Gets No value from a XML document
//Parameters: rec: 
//Return: float
function getNo(rec){
    var no = parseFloat(rec.getAttribute('no'))
    if(isNaN(no)){
        return 0.0;
    }
    return no;
}

//Function name: getTime
//Description: Gets timestamp value from a XML document
//Parameters: rec: 
//Return: int
function getTime(rec){
    return ts = parseInt(rec.getAttribute("ts"));
}

function initMap(xml, pollutant, hour_value) {
    let map;
    var lat, lng;
    var xml;
    var avarage_pollutant = 0.0;
    var circleColor = "";

    //If the xml variable has data then run program
    if(xml){
        //Get the first station node
        var station = xml.getElementsByTagName('station')[0];
        //Get all records 
        var rec = xml.getElementsByTagName('rec');
        
        for(var i = 0; i < rec.length; i++){
            var timestampMiliseconds = (getTime(rec[i]) * 1000);
            var dateObj = new Date(timestampMiliseconds);
            var recHours = dateObj.getHours();

            if(recHours == parseInt(hour_value)){
                if(pollutant == "nox"){
                    avarage_pollutant += getNox(rec[i]);
                }else if(pollutant == "no2"){
                    avarage_pollutant += getNo2(rec[i]);
                }else if(pollutant == "no"){
                    avarage_pollutant += getNo(rec[i]);
                }
            }            
        }

        //Calculate avarage pollutant for a certain area
        var result = avarage_pollutant / rec.length;

        if(result >= 0 || result <= 200){
            //low
            circleColor = "low";
        }else if(result >= 201 || result <= 400){
            //moderate
            circleColor = "moderate";
        }else if(result >= 401 || result <= 600){
            //high
            circleColor = "high";
        }else if(result > 601){
            //very high
            circleColor = "very_high";
        }
        //Get station name for circle title
        var station_name = getName(station);
        //Gets geocode to goto location
        var geo_code = getGeocode(station);
        //Get color value for circle
        var circleStroke = color_pollutant[circleColor];

        //Split geocode getting latitude and longitude 
        var split_geocode = geo_code.split(",");
        lat = parseFloat(split_geocode[0]);
        lng = parseFloat(split_geocode[1]);
        
        // console.log("Name: " + station_name + ", Geocode: {lat: " + lat + ",lng: " + lng);
        // console.log("Geocode: {lat: " + lat + ",lng: " + lng);
    
        //get geo location from xml file
        const location = { lat: lat, lng: lng }
    
        //Creates map
        map = new google.maps.Map(document.getElementById("map"), {
            center: location,
            zoom: 12,
        });

        //Places marker on circle location
        var marker = new google.maps.Marker({
            position: location,
            title: station_name,
            customInfo: ("Pollutant: " + pollutant + 
                        "\nName: " + station_name + 
                        "\nGeocode: {lat: " + lat + ",lng: " + lng + "}") + 
                        "\nTime of Day: " + hour_value,
        });

        google.maps.event.addListener(marker, 'click', function() {
            alert(this.customInfo);
        });

        //Draws circle
        const pollutantCircle = new google.maps.Circle({
            strokeColor: circleStroke,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: circleStroke,
            fillOpacity: 0.35,
            map,
            center: location,
            radius: Math.sqrt(150) * 150,
        });
    
        marker.setMap(map);
        
    }
}

function clear2(){
    console.log("Hello");
    window.location.reload();
}

function start(){
    //Gets selected station option
    var select = document.getElementById("station_select");
    var station_value = select.options[select.selectedIndex].value;

    //Gets checkbox value from html page
    var nox = $("#nox").is(":checked") ? "true" : "false";
    var no2 = $("#no2").is(":checked") ? "true" : "false";
    var no = $("#no").is(":checked") ? "true" : "false";

    //Gets selected time option
    var hour_selection = document.getElementById("hour_select");
    var hour_value = hour_selection.options[hour_selection.selectedIndex].value;

    var path = "/assignment/xml/" + station_value;

    if(nox == "true"){
        nox = "nox";
        generateMap(path, nox, hour_value);
    }else if(no2 == "true"){
        no2 = "no2";
        generateMap(path, no2, hour_value);
    }else if(no == "true"){
        no = "no";
        generateMap(path, no, hour_value);
    }
}



function generateMap(path, pollutant, hour_value){
    window.document.close();
    //Create XML http request
    let xmlFile = new XMLHttpRequest();
    //Get file from path
    xmlFile.open("GET", path);
    //Give the file a content type 
    xmlFile.setRequestHeader("Content-Type", "text/xml");
    xmlFile.onreadystatechange = function(){
        //When the is complete
        if(xmlFile.readyState == 4 && xmlFile.status == 200){
            //Create xml parser
            var xmlParser = new DOMParser();
            //Convert the returned text to a DOM object
            var xmlData = xmlParser.parseFromString(xmlFile.responseText, "text/xml");
            window.initMap = initMap(xmlData, pollutant, hour_value);
        }
    }
    xmlFile.send();  
}
  

