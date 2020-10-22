<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rovers</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *, :after, :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg, video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .flex {
            display: flex
        }


        .justify-center {
            justify-content: center
        }


        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }


        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }


        .pt-8 {
            padding-top: 2rem
        }


        .relative {
            position: relative
        }


        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }


        @media (min-width: 640px) {


            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }


            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

        }


        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme: dark) {


            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }


        }
    </style>

    <style>
        body {
            font-family: 'Nunito';
        }

        #roversOutput {
            white-space: pre-wrap;
        }
    </style>

</head>
<body class="antialiased">
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
    <form id="rovers" action="/" method="post">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <textarea id="roversInput" name="roversInput" rows="15" cols="100"
                          placeholder="The first line of input is the upper-right coordinates of the area, the lower-left coordinates are assumed to be 0,0. The rest of the input is information pertaining to the rovers that have been deployed. Each rover has two lines of input.The first line gives the rover’s position, and the second line is a series of instructions telling the rover how to explore the area. The position is made up of two integers and a letter separated by spaces, corresponding to the x and y co-ordinates and the rover’s orientation. Each rover will be finished sequentially, which means that the second rover won’t start to move until the first one has finished moving."></textarea>
            </div>
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <button type="submit">Process rover data</button>
            </div>
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            </div>
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <textarea id="roversOutput" name="roversOutput" rows="15" cols="100" disabled
                      placeholder="The output for each rover should be its final co-ordinates and heading."></textarea>
            </div>
        </div>
    </form>
</div>
<script>
    $("#rovers").on('submit', function (event) {
        event.preventDefault()
        var $form = $(this),
            url = $form.attr('action');
        $.ajax({
            type: "POST",
            url: url,
            data: $form.serialize(), // serializes the form's elements.
            success: function (data) {
                $("#roversOutput").val((data.data));
            },
            error: function (error) {
                $("#roversOutput").val(error.responseJSON.error.toString());
            }
        });

    });
</script>
</body>
</html>
