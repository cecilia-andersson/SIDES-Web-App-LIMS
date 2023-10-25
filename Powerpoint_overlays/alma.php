<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->

<style>

       /* START STYLE PRESENTATION SLIDES */
       .slides_button {
            background-color: #9510AC;
            border: none;
            color: white;
            position: fixed; /* So it does not scroll when you scroll */
            top: 15%; /* Positioning */
            border-radius: 50%;
            padding: 25px;
            width: 110px;
            height: 110px;
            z-index: 10;  /* On top of everything else */         
        }

        .slides_button:hover {
            background-color: #1A3038;
        }

        /* Start slide overlay */
        #overlay1 {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 10, 0.5);
            /*this is 757CB3 */
            z-index: 2;
            cursor: pointer;
        }

        #overlay2 {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 10, 0.5);
            /*this is 757CB3 */
            z-index: 2;
            cursor: pointer;
        }

        #outerContainer {
            background-color: #ffffff;
            border: 2px solid #256e8a;
            border-radius: 15px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;

            max-height: 95vh;
            /* Set maximum height for the container */
            overflow-y: auto;
            /* Enable vertical scrolling if content overflows */

            position: absolute;
            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        /* End slide overlay */
        /* END STYLE PRESENTATION SLIDES */

</style>



        <!-- start stuff for the presentation -->
        <div id="overlay1">
            <div id="outerContainer">
            <h3> Searching for contraceptives </h3>
            <ul>
              <li> Filtering </li>
                <ul>
                  <li>Sort and filter on active ingredients, brand and class</li>
                </ul>
                <li> Collapsibles </li>
                <ul>
                  <li>Closed</li>
                    <ul>
                      <li>Ratings - ☆ and absolute number</li>
                      <li>Comments - User interaction</li>
                    </ul>
                  <li>Open</li>
                    <ul>
                      <li>Information - Class, format, active and inactive ingredients.</li>
                      <li>Description</li>
                    </ul>                
            </ul>
            </div>
        </div>

        <div id="overlay2">
            <div id="outerContainer">
            <h3> Logging side effects </h3>
            <ul>
              <li> Checkbox and intensity slider </li>
              <li> Customisable list </li>
              <ul>
                  <li>Quick access to your most logged side effects</li>
              </ul>
              <li> Dynamic list </li>
              <ul>
                  <li>Logging less common side effects through dropdown list</li>
                  <li>Options to opt out</li>
              </ul>
            </ul>
            </div>
        </div>

        <button type="button" class="slides_button" style="right:30%" onclick="overlay1_on()"> <b>SLIDE 1</b></button>
        <button type="button" class="slides_button" style="right:20%" onclick="overlay2_on()"><b>SLIDE 2</b></button>

        <script>
            function overlay1_on() {
                var overlay = document.getElementById("overlay1");
                if (overlay.style.display === "block") {
                    overlay.style.display = "none";
                } else {
                    overlay.style.display = "block";
                }
            }

            function overlay1_off() {
                document.getElementById("overlay1").style.display = "none";
            }

            function overlay2_on() {
                  var overlay = document.getElementById("overlay2");
                  if (overlay.style.display === "block") {
                      overlay.style.display = "none";
                  } else {
                      overlay.style.display = "block";
                  }
            }

            function overlay2_off() {
                document.getElementById("overlay2").style.display = "none";
            }

            document.addEventListener("keydown", function (event) {// to allow for esc closing 
                if (event.key === "Escape") {
                    overlay1_off();
                    overlay2_off(); y
                }
            });

        </script>