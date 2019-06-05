<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bird-board</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
</head>
<body>
    <form action="/projects" method="post" class="container" style="padding:40px;">
        @csrf
            <h1 class="heading is-1">Create a Project</h1>
        <div class="control">
            <input type="text" name="title" class="input" placeholder="title">
        </div>
        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
            <textarea name="description" class="textarea"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create Prject</button>
            </div>
        </div>
    </form>
</body>
</html>
