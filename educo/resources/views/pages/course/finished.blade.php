<x-app-layout>
    <h1>Course Finished, congratulations!</h1>
    <h2>{{$course->title}}</h2>
    <div>
        <h2>Certificates obtained</h2>
        @foreach($certificates as $certificate)
            <div>
                <h2>{{$certificate->title}}</h2>
                <p>{{$certificate->date_acquired}}</p>
            </div>
        @endforeach
    </div>

</x-app-layout>
