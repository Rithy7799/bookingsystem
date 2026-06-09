<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <form action="{{url('store-test')}}" method="post">
        @csrf
        <label>
            <input type="checkbox" name="cbx[]" id="cbx" value="1">
            cbx1
        </label>

        <label>
            <input type="checkbox" name="cbx[]" id="cbx" value="2">
            cbx1
        </label>

        <label>
            <input type="checkbox" name="cbx[]" id="cbx" value="3">
            cbx1
        </label>

        <button type="submit">save</button>
    </form>
</body>
</html>
