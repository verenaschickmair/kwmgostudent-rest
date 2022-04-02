<!DOCTYPE html>
<html>
<head>
    <title>Hello World!</title>
</head>
<body>
<ul>
    @foreach ($students as $student)
        <li>{{$student->firstname}} {{$student->lastname}}</li>
    @endforeach
</ul>
</body>
</html>
