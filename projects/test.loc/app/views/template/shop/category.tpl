<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{$name}</h1>
    <ul>
    {section name=i loop=$arr}
        <li>{$arr[i]}</li>
    {/section}
    </ul>
    <a href="/">BACK</a>
</body>
</html>