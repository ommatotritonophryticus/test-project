<!DOCTYPE html>
<html>
<head>

    <link href="/static/bootstrap.min.css" rel="stylesheet">
    <link href="/static/main.css" rel="stylesheet">
    <script src="/static/bootstrap.bundle.min.js"></script>

    <title><?= get_title() ?> - Test Project</title>

</head>
<body>
    <div id="content">
    <?= get_content($args) ?>
    </div>
</body>
</html>
