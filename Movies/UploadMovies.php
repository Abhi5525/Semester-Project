<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="movies.css">

    <script>
        function validation() {
            var title = document.getElementById("title").value;
            var description = document.getElementById("description").value;
            var duration = document.getElementById("duration").value;
            var url = document.getElementById("url").value;
            var genre = document.getElementById("genre").value; 
            var thumbnail = document.getElementById("thumbnail").value;           


            document.getElementById("titleError").textContent = "";
            document.getElementById("descriptionError").textContent = "";
            document.getElementById("durationError").textContent = "";
            document.getElementById("urlError").textContent = "";
            document.getElementById("genreError").textContent = "";
            document.getElementById("thumbnailError").textContent = "";



            var valid = true;

            if (title == "") {
                document.getElementById("titleError").textContent = "Missing the movie title";
                valid = false;
            }

            if (description == "") {
                document.getElementById("descriptionError").textContent = "Missing the movie description";
                valid = false;
            }

            if (duration == "") {
                document.getElementById("durationError").textContent = "Missing the movie duration";
                valid = false;
            }

            if (url == "") {
                document.getElementById("urlError").textContent = "Missing the movie trailor's URL";
                valid = false;
            }

            if (genre == "") {
                document.getElementById("genreError").textContent = "Missing the movie genre";
                valid = false;
            }

            if (thumbnail == "") {
                document.getElementById("thumbnailError").textContent = "Please upload a movie thumbnail";
                valid = false;
            }

            return valid;
        }
    </script>

</head>
<body>
    <div class="container">
        <form action="MoviesController.php" method = "POST" enctype="multipart/form-data" onsubmit = "return validation();">
        
            <div class="input-field">
                <label for="title">Movie Title: </label>
                <input type="text" name = "title" id = "title">
                <span class = "error" id = "titleError"></span>
            </div>

            <div class="input-field">
                <label for="description ">Movie Description: </label>
                <input type="text" name = "description" id = "description">
                <span class = "error" id = "descriptionError"></span>
            </div>
                
            <div class="input-field">
                <label for="duration ">Movie Duration : </label>
                <input type="text" name = "duration" id = "duration">
                <span class = "error" id = "durationError"></span>
            </div>

            <div class="input-field">
                <label for="url ">Movie Trailer URL : </label>
                <input type="text" name = "url" id = "url">
                <span class = "error" id = "urlError"></span>
            </div>

            <div class="input-field">
                <label for="genre">Movie Genre: </label>
                <select name="genre" id="genre">
                    <option value="">Select Genre</option> <!-- Optional default option -->
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Sci-Fi">Sci-Fi</option>
                    <!-- Add other genres as needed -->
                </select>
                <span class="error" id="genreError"></span>
            </div>


            <div class="input-field">
                <label for="thumbnail ">Movie Thumbnail: </label>
                <input type="file" accept="image/*" name = "thumbnail" id = "thumbnail">
                <span class = "error" id = "thumbnailError"></span>
            </div>
        
            <input type="submit" value = "Upload">
        </form>

    </div>    

    
</body>
</html>