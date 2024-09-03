<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub User Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1>Search GitHub User</h1>
<input type="text" id="username" placeholder="Enter GitHub username">
<button id="searchBtn">Search</button>

<div id="user-info"></div>
<div id="followers"></div>
<button id="loadMoreBtn" style="display: none;">Load More</button>

<script>
    $(document).ready(function() {
        let page = 1;
        let username = '';

        $('#searchBtn').click(function() {
            username = $('#username').val();
            page = 1;
            searchUser(username);
        });

        $('#loadMoreBtn').click(function() {
            loadMoreFollowers(username, ++page);
        });

        function searchUser(username) {
            $.get('/search', { username: username }, function(data) {
                $('#user-info').html(`
                        <h2>${data.user.name}</h2>
                        <p>${data.user.bio}</p>
                        <img src= ${data.user.avatar_url} alt='Avatar' width='50'>
                        <a href=${data.user.html_url} target='_blank'>${data.user.login}</a>
                    `);
                displayFollowers(data.followers);
                if (data.followers.length >= 10) {
                    $('#loadMoreBtn').show();
                } else {
                    $('#loadMoreBtn').hide();
                }
            });
        }

        function loadMoreFollowers(username, page) {
            $.get('/followers', { username: username, page: page }, function(data) {
                displayFollowers(data, true);

                if (data.length < 10) {
                    $('#loadMoreBtn').hide();
                }
            });
        }

        function displayFollowers(followers, append = false) {

            let html = followers.map(follower => `
                    <div>
                        <p>${follower.login}</p>
                        <img src= ${follower.avatar_url} alt='Avatar' width='50'>
                        <a href=${follower.html_url} target='_blank'>${follower.login}</a>
                    </div>

                `).join('');

            if (append) {
                $('#followers').append(html);
            } else {
                $('#followers').html(html);
            }
        }
    });
</script>
</body>
</html>
