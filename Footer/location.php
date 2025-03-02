<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location - BAMEL Cinemas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #1a1a1a;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .map-container {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: crimson;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn:hover {
            background: darkred;
        }
    </style>
</head>
<body>
<!-- <button href="" class="btn" onclick="window.history.back();">Back</button> -->

    <div class="container">
        <h1>Visit BAMEL Cinemas</h1>
        <p>Experience the best in entertainment at our location.</p>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4608.132920709427!2d85.51558824565389!3d27.633125927992324!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb0fb2e693a1f5%3A0x4b75f06007dc4415!2sBAMEL%20Cinemas!5e0!3m2!1sen!2snp!4v1740833139102!5m2!1sen!2snp" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <a href="https://maps.app.goo.gl/neCxZWRqev6PP1KV9" target="_blank" class="btn">Get Directions</a>
    </div>

</body>
</html>
