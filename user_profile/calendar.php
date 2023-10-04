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
            padding: 0;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .weekdays li {
            color: #fff;
            margin-left: 4px;
            margin-right: 3px;
        }

        /* Days (1-31) */
        .days {
            background: #eee;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .days li {
            color: #777;
            font-size: 16px;
            text-align: center;
            margin: 6px;
        }

        .days li .active {
            background: #757CB3;
            color: white;
            padding: 4px;
            border-radius: 5px;
        }
        
    </style>
</head>


<div class='container'>
    <div class="month" style="border-radius: 2px;">
        <ul>
            <li class="prev">&#10094;</li>
            <li class="next">&#10095;</li>
            <li>October<br><span>2023</span></li>
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

    <ul class="days" style="border-radius: 2px;">
        <li>1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
        <li>6</li>
        <li>7</li>
        <li>8</li>
        <li>9</li>
        <li><span class="active">10</span></li>
        <li>11</li>
        <li>12</li>
        <li>13</li>
        <li>14</li>
        <li>15</li>
        <li>16</li>
        <li>17</li>
        <li>18</li>
        <li>19</li>
        <li>20</li>
        <li>21</li>
        <li>22</li>
        <li>23</li>
        <li>24</li>
        <li>25</li>
        <li>26</li>
        <li>27</li>
        <li>28</li>
        <li>29</li>
        <li>30</li>
        <li>31</li>
    </ul>
</div>