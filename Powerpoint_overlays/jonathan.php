<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../stylesheet/styles.css"> <!-- Link to CSS file -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>
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
            <h3> The equation for satisfaction confidence </h3>
            \( SC = \left(\frac{\text{Users who liked the recommended drug and fulfilled LHS}}{\text{Users who fulfilled LHS and tried RHS}}\right) \times 100\% \)

            </div>
        </div>



        <button type="button" class="slides_button" style="right:30%" onclick="overlay1_on()"> <b>SLIDE 1</b></button>

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