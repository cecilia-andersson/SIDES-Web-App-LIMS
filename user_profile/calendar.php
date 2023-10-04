<!DOCTYPE html>
<html>

<head>
    <style>
        ul {
            list-style-type: none;
        }

        .container {
            position: relative;
            max-width: fit-content;
            max-height: fit-content;
        }

        .month {
            background: #1A3038;
            width: auto;
            text-align: center;
        }

        .month ul {
            margin: 0;
            padding: 5px;
        }

        .month ul li {
            color: white;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* Previous button inside month header */
        .month .prev {
            float: left;
            margin: 10px;
        }

        /* Next button */
        .month .next {
            float: right;
            margin: 10px;
        }

        /* Weekdays (Mon-Sun) */
        .weekdays {
            margin: 0;
            background-color: #64a7ac;
            padding: 1px;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .weekdays li {
            color: #fff;
            margin: 5px;
        }

        /* Days (1-31) */
        .days {
            background: #eee;
            margin: 0;
            padding: 2px;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .days li {
            color: #777;
            font-size: 16px;
            text-align: center;
            margin: 10px;
            
        }

        .days li .active {
            background: #757CB3;
            color: white;
            border-radius: 8px;
            padding:8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="month" style="border-radius: 2px;">
            <ul>
                <li class="prev" onclick="prevMonth()">&#10094;</li>
                <li class="next" onclick="nextMonth()">&#10095;</li>
                <li id="month-year">October<br><span>2023</span></li>
            </ul>
        </div>

        <ul class="weekdays" style="border-radius: 2px;">
            <li>Mo</li>
            <li>Tu</li>
            <li>We</li>
            <li>Th</li>
            <li>Fr</li>
            <li>Sa</li>
            <li>Su</li>
        </ul>

        <ul id="days-list" class="days" style="border-radius: 2px;">
        </ul>
    </div>

    <script>
        var currentMonth = 9; // October is 9 (0-based index)
        var currentYear = 2023;

        function updateCalendar() {
            var monthYearElement = document.getElementById('month-year');
            var daysListElement = document.getElementById('days-list');
            daysListElement.innerHTML = '';

            // Set the month and year in the header
            monthYearElement.innerHTML = getMonthName(currentMonth) + '<br><span>' + currentYear + '</span>';

            // Get the first day of the month (0 for Sunday, 1 for Monday, etc.)
            var firstDay = new Date(currentYear, currentMonth, 1).getDay() - 1;
            if (firstDay === -1) {
                firstDay = 6; // Adjust Sunday (0) to 6
            }

            // Get the current date
            var currentDate = new Date();

            // Calculate the number of days in the month
            var numDays = new Date(currentYear, currentMonth + 1, 0).getDate();

            // Create empty list items for the days before the first day of the month
            for (var i = 0; i < firstDay; i++) {
                var listItem = document.createElement('li');
                daysListElement.appendChild(listItem);
            }

            // Create list items for the days of the month
            // Create list items for the days of the month
            for (var day = 1; day <= numDays; day++) {
                var listItem = document.createElement('li');
                if (
                    currentDate.getDate() === day &&
                    currentDate.getMonth() === currentMonth &&
                    currentDate.getFullYear() === currentYear
                ) {
                    var span = document.createElement('span');
                    span.textContent = day;
                    span.classList.add('active');
                    listItem.appendChild(span);
                } else {
                    listItem.textContent = day;
                }
                daysListElement.appendChild(listItem);
            }

        }

        function prevMonth() {
            if (currentMonth === 0) {
                currentMonth = 11;
                currentYear--;
            } else {
                currentMonth--;
            }
            updateCalendar();
        }

        function nextMonth() {
            if (currentMonth === 11) {
                currentMonth = 0;
                currentYear++;
            } else {
                currentMonth++;
            }
            updateCalendar();
        }

        function getMonthName(monthIndex) {
            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            return months[monthIndex];
        }

        // Initialize the calendar
        updateCalendar();
    </script>
</body>

</html>