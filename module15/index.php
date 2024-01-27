<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>

</head>
<body>

<div class="form-wrapper">
    <form class="form modal-content" method="post" action="process_form.php">
        <span class="loader"></span>
        <h1 class="modal-title">Form registration</h1>
        <div class="mb-3 wrap-field">
            <label class="form-label" for="name">Enter your name</label>
            <input class="form-control name" id="name" type="text" name="name"/>
            <div class="error-name error-field">Right correct name. Name must have at least two letters</div>
        </div>
        <div class="mb-3 wrap-field">
            <label class="form-label" for="email">Enter your e-mail:</label>
            <input class="form-control email" aria-describedby="emailHelp" id="email" type="email" name="email"/>
            <div class="error-email error-field">Right correct email. Email format must be correct</div>
        </div>
        <div class="mb-3 wrap-field">
            <label class="form-label">Comments</label>
            <textarea class="form-control" name="message">...</textarea>
        </div>
        <div class="php-errors">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'mail') {
                ?>
                <div class="error-send">Error send message</div>
                <?php
            }
            if (isset($_GET['error']) && $_GET['error'] === 'length') {
                ?>
                <div class="error-length">Error save file. Length of comments isn't right (min 5, max 500)</div>
                <?php
            }
            ?>
        </div>
        <div>
            <button class="btn btn-danger" type="reset">Reset</button>
            <button class="btn btn-success" type="submit">Send</button>
            <?php
            if (isset($_GET['error'])) {
                ?>
                <a href="index.php" class="btn btn-primary">Try again</a>
                <?php
            }
            ?>
        </div>
    </form>
</div>
</body>
</html>

