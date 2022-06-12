<x-app-layout>
    <div class="py-3 w-3/5 max-w-3xl mx-auto flex flex-row justify-around">
        <a href="/dashboard"><p>All courses</p></a>
        <a href="{{route('dashboard.active', $user->id)}}"><p>Active</p></a>
        <a href="{{route('dashboard.obligated', $user->id)}}"><p>Obligated</p></a>
        <a href="{{route('dashboard.finished', $user->id)}}"><p>Finished</p></a>
        <a href="{{route('dashboard.recommended', $user->id)}}"><p class="font-semibold">Recommended</p></a>
    </div>
    @if($recommendedCourses)
        <div class="py-5 w-5/6 max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center flex-wrap">
            @foreach($recommendedCourses as $recommendedCourse)
                <x-course :course="$recommendedCourse" class="basis-1/3"/>
            @endforeach
        </div>
    @else
        <div class="bg-white inline-block mr-4 rounded my-5 p-4 text-center w-56 h-60 shadow-md">
            <svg id="Laag_1" data-name="Laag 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1316.74 655.26"><defs>
                    <style>.cls-1{fill:#f1877a;}.cls-2{fill:#305299;}</style>
                </defs>
                <title>logo2ColorCompletePink</title>
                <path class="cls-1" d="M927.67,256.05A209.9,209.9,0,0,0,986,292.44a207.93,207.93,0,0,0,13.51-36.8,161.14,161.14,0,0,0-71.82.41Z"/><path class="cls-2" d="M987.41,144.74a145,145,0,0,0-145,145c0,1.95,0,3.88.13,5.81a160.36,160.36,0,0,1,154.79-53,204.57,204.57,0,0,1-2-25.17c0-1.35-.06-2.72-.06-4.09a208.88,208.88,0,0,1,3.7-39.33q1.35-7.28,3.23-14.33v0c1.22-4.61,2.59-9.17,4.1-13.65-2.51-.33-5-.6-7.6-.78C995,144.88,991.2,144.74,987.41,144.74Z"/><path class="cls-1" d="M1045.18,204.56a12.69,12.69,0,1,0-12.68-12.7A12.7,12.7,0,0,0,1045.18,204.56Z"/><path class="cls-2" d="M1054.54,161.2a42.84,42.84,0,0,1-5.93,77.76,62.7,62.7,0,0,0-42.12,59.26c0,.49,0,1,0,1.49a62.73,62.73,0,0,0,103.8,45.9c1.32-1.15,2.57-2.34,3.78-3.57,23.65-24.38,21.3-63.85,12.22-94.08A145.85,145.85,0,0,0,1073.47,173,167.5,167.5,0,0,0,1054.54,161.2Z"/><path class="cls-1" d="M239.24,429.51l4.12-41.94H302.6a111.63,111.63,0,0,1,8.54-41.93H247.48l4.05-41.94h89.71l4.82-41.94H204.5L184,471.45H337.2a114.55,114.55,0,0,1-27.41-41.94Z"/><path class="cls-1" d="M451.1,324.67A91.33,91.33,0,0,0,430,311.94,60.55,60.55,0,0,0,405.87,307a79.67,79.67,0,0,0-31.75,6.44A82.84,82.84,0,0,0,347.91,331a81.91,81.91,0,0,0-24.12,58.41,78.8,78.8,0,0,0,6.44,31.76,83.89,83.89,0,0,0,17.53,26.21,81.25,81.25,0,0,0,58.11,24.11,59.73,59.73,0,0,0,24-4.94,91.45,91.45,0,0,0,21.27-13.18v12.13H496V215.63H451.1Zm-2.17,80.8a41.72,41.72,0,0,1-38.42,25.24,41.41,41.41,0,0,1-16.4-3.29,42.71,42.71,0,0,1-13.25-8.77A42.27,42.27,0,0,1,372,405.47a41.78,41.78,0,0,1,0-32.5A40.37,40.37,0,0,1,394.11,351a42.23,42.23,0,0,1,32.73,0A40.37,40.37,0,0,1,448.93,373a40.86,40.86,0,0,1,0,32.5Z"/><path class="cls-1" d="M618.73,303.7l.12,93.76a34.65,34.65,0,0,1-2.4,13,30.57,30.57,0,0,1-6.74,10.64,31.78,31.78,0,0,1-9.88,7,28.74,28.74,0,0,1-23.67,0,32,32,0,0,1-9.73-7,35.49,35.49,0,0,1-6.59-10.34,33.82,33.82,0,0,1-2.4-12.73l-.12-94.36H512.48l0,103.05a63.85,63.85,0,0,0,4.49,24c.15.37.3.82.45,1.2a69.43,69.43,0,0,0,13.33,20.52,61.64,61.64,0,0,0,19.77,13.93,60.12,60.12,0,0,0,24.57,5.09,49.4,49.4,0,0,0,24-5.84,75.1,75.1,0,0,0,19.77-15.73v15.58h44.93V303.7Z"/><path class="cls-1" d="M804.15,428.65a86.13,86.13,0,0,1-4.49-11.76,35.1,35.1,0,0,1-12.51,8.69c-6.29,2.85-14,4.34-23.21,4.34a31.34,31.34,0,0,1-14.23-3.52A43.42,43.42,0,0,1,737.5,417a45.87,45.87,0,0,1-8.39-13.56,42.4,42.4,0,0,1-3.07-15.8A48.08,48.08,0,0,1,729,371.29a43.41,43.41,0,0,1,8.09-13.56,39.76,39.76,0,0,1,12.06-9.13,34.52,34.52,0,0,1,14.83-3.37c9.58,0,17.59,1.57,24,4.64a36.14,36.14,0,0,1,11.83,8.46,90.84,90.84,0,0,1,4.65-12.06,105.13,105.13,0,0,1,16.92-26.06,102.26,102.26,0,0,0-13.48-7.49c-13.18-6.06-27.78-9-43.88-9a82.1,82.1,0,0,0-32.66,6.51,83.73,83.73,0,0,0-26.58,17.9,81.45,81.45,0,0,0-18,26.74,83.73,83.73,0,0,0-6.52,32.87A79.21,79.21,0,0,0,687,420.11a88.54,88.54,0,0,0,18.27,26.74,82.83,82.83,0,0,0,26.58,18,80.57,80.57,0,0,0,32.06,6.59,106,106,0,0,0,44-9.14A81.22,81.22,0,0,0,821.23,455c-.08,0-.08-.07-.15-.15A110.39,110.39,0,0,1,804.15,428.65Z"/><path class="cls-1" d="M992.2,355.34A84.56,84.56,0,0,0,973,328.6a93.13,93.13,0,0,0-63.71-24.9,94.05,94.05,0,0,0-63.63,24.45,82.66,82.66,0,0,0-19.48,26.73A76.66,76.66,0,0,0,819,387.73a75.78,75.78,0,0,0,7,32.39,85.54,85.54,0,0,0,19.17,26.73,90.22,90.22,0,0,0,28.72,18,95,95,0,0,0,35.37,6.57A93.52,93.52,0,0,0,944,464.88,91.13,91.13,0,0,0,972.72,447a87,87,0,0,0,19.33-26.59,75.48,75.48,0,0,0,7.18-32.69A77,77,0,0,0,992.2,355.34Zm-41.86,47.59a46,46,0,0,1-8.71,13.6,41.88,41.88,0,0,1-13.75,9.7,44.41,44.41,0,0,1-18.49,3.66,45.38,45.38,0,0,1-18.63-3.66,41.85,41.85,0,0,1-13.91-9.7,42.55,42.55,0,0,1-11.45-28.95,38.83,38.83,0,0,1,3.2-15.21,46.83,46.83,0,0,1,8.86-13.75,42.14,42.14,0,0,1,13.75-9.7,47,47,0,0,1,36.36,0,42.07,42.07,0,0,1,13.76,9.7,46.83,46.83,0,0,1,8.86,13.75,39,39,0,0,1,3.2,15.21A39.66,39.66,0,0,1,950.34,402.93Z"/></svg>
            <p class="font-bold italic">No recommended courses yet...</p>
            <p class="font-bold italic">Obtain some skills to activate this section!</p>
        </div>
    @endif
</x-app-layout>
