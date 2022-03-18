<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Document</title>
</head>

<body>
    <h3 >GitHub API</h3>
	<form id="gitHubForm"  style="width: 280px" method="post">
		<input id="usernameInput"  type="text" name="username" placeholder="GitHub Username">
		<input type="submit" value="Find User">
	</form>
	<ul id="userRepos" style="width: 500px">

	</ul>
    <script type="text/javascript">

function requestUserRepos(username){
    
    // Create new XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    
    // GitHub endpoint, dynamically passing in specified username
    const url = `https://api.github.com/users/${username}/repos`;

    // Open a new connection, using a GET request via URL endpoint
    // Providing 3 arguments (GET/POST, The URL, Async True/False)
    xhr.open("GET", url, true);
    
    // When request is received
    // Process it here
    xhr.onload = function () {
    
        // Parse API data into JSON
        const data = JSON.parse(this.response);

        console.log(data);

        // Get the ul with id of of userRepos
        let ul = document.getElementById("userRepos");

        data.sort(function(a, b) {
        return parseFloat(b.stargazers_count) - parseFloat(a.stargazers_count);
        });

        let p = document.createElement('p');
        p.innerHTML = (`<p><strong>Number of Public Repos: ${data.length}</p>`)
        
        // Initiate counter for posts
        let counter = 0;

        // Loop over each object in data array
        for (let i in data) {

            // break loop once over 5 iterations
            if (counter >= 5) {
                break;
            } 
            // Create variable that will create li"s to be added to ul
            let li = document.createElement("li");
        
            // Create the html markup for each li
            li.innerHTML = ("<p><strong>Repo:</strong> " + data[i].name + "</p><p><strong>Description:</strong> " + data[i].description + "</p><p><strong>Stars:</strong> " + data[i].stargazers_count + "</p><p><strong>URL:</strong> <a href=\'" + data[i].html_url + "\'>" + data[i].html_url + "</a></p>" );
            

            
            // Append each li to the ul
            ul.appendChild(li);
            counter++;
            
        }

    }
    
    // Send the request to the server
    xhr.send();
    
}
const gitHubForm = document.getElementById("gitHubForm");

// Listen for submissions on GitHub username input form
gitHubForm.addEventListener("submit", (e) => {
    
    // Prevent default form submission action
    e.preventDefault();

    // Get the GitHub username input field on the DOM
    let usernameInput = document.getElementById("usernameInput");

    // Get the value of the GitHub username input field
    let gitHubUsername = usernameInput.value;          

    // Run GitHub API function, passing in the GitHub username
    requestUserRepos(gitHubUsername);

});
</script>
</body>

</html>