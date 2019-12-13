<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$title}</title>
</head>
<body>
    <h1>{$title}</h1>
    <ul>
    {section name=i loop=$articles}
        <li>{$articles[i]}</li>
    {/section}
    </ul>
    <a href="/shop">SHOP</a>
    <a href="/category">CATEGORY</a>
</body>
</html>