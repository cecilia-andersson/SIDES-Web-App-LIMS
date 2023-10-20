<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->

<style>

#text {
    height: 70%;
    width: 70%;
    background-color: #256e8a;
    border: 2px solid #256e8a;
    border-radius: 15px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    padding: 20px;
    color: #ffffff;
    font-size: 2rem;
    overflow-y: auto;
    font-family: 'Roboto', sans-serif;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}

#text ul {
    padding: 0;
    
}

#text ul li {
    margin-bottom: 10px; 
    margin-left: 50px;
    list-style-type: disc; 

}




#overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color:  rgba(0,0,10, 0.5); /*this is 757CB3 */
        z-index: 2;
        cursor: pointer;
        }


.power-button {
            background-color: #9510AC; 
            color: #ffffff;
            border: none;
            padding: 20px 30px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            width: 15%;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            position: fixed;
            bottom: 0;
            left: 0;
            margin: 20px;
        }


        .power-button:hover {
            background-color: #1A3038; 
        }

        #contents {
          justify-content: center;

        }

</style>

</head>
<body>

<div id="overlay" onclick="off()">
  <div id="contents">
    <div id="text">

  <ul>
    <li>Filtering</li>
    <li>Sort and filter on active ingredients, brand and class</li>
    <li>
        Collapsibles
        <ul>
            <li>Closed</li>
            <li>Ratings - ☆ and absolute number</li>
            <li>Comments - User interaction</li>
            <li>Open
                <ul>
                    <li>Information - Class, format, active and inactive ingredients.</li>
                    <li>Description</li>
                  </ul>                
            </li>
        </ul>
        <li>Not implemented</li>
            </ul> 
                <li>Comment and rating preview</li>
                <li>Extensive filtering</li>
            </ul> 
    </li>
</ul>

    </div>
  </div>
</div>

<div style="padding:20px">
  <button type="button" class="power-button" onclick="on()">SLIDES</button>
</div>

<script>
function on() {
  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}
</script>
   
</body>
</html> 
