<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Framed</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Main Grid Container */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(33%, 1fr));
        }

        /* The Wrapper for each Iframe (This is what resizes) */
        .iframe-container {
            background: white;
            border: 0 none;
            
            height: 50vh; /* Initial Height */
            overflow: hidden; /* Required for resize handle to show properly */
            resize: both;     /* Allows vertical and horizontal resizing */
            
            /* Layout internals */
            display: flex;
            flex-direction: column;
        }

        /* Header bar just for looks */
        .panel-header {
            background-color: #e0e0e0;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: bold;
            color: #555;
            border-bottom: 0 none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        /* The Iframe itself */
        iframe {
            border: 0 none;
            width: 100%;
            height: 100%;
            flex-grow: 1; /* Fills the rest of the container space */
        }

        
    </style>
</head>
<body>
    <div class="dashboard-grid">

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

        <div class="iframe-container">
            <iframe src="{{route('home')}}"></iframe>
        </div>

    </div>

</body>
</html>