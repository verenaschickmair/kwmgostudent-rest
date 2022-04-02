<!DOCTYPE html>
<html>
<head>
    <title>REST</title>
</head>
<body>
<ul>
    @foreach ($students as $student)
        <li><a href="students/{{$student->id}}">
                {{$student->firstname}} {{$student->lastname}}</a></li>
@endforeach
</ul>
</body>
</html>
