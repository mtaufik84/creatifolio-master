<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col">
                <a href="{{route('admin.projects.create')}}" class="w-fit py-4 px-10 text-white bg-indigo-950 rounded-full font-bold">
                    Tambahkan Projek Baru
                </a>
                <hr class="my-10">
                <div class="flex flex-col gap-y-5">

                    @forelse($projects as $project)
                    <div class="item-project flex flex-row gap-x-5 items-center justify-between">
                        <div class="flex flex-row items-center gap-x-5">
                            <img src="{{Storage::url($project->cover)}}" 
                            alt="" class="object-cover- w-[120px] h-[90px] rounded-2xl">
                            <div class="flex flex-col gap-y-1">
                                <h3 class="font-bold text-xl">
                                    {{$project->name}}
                                </h3>
                                <p class="text-sm text-slate-400">
                                    {{$project->category}}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-row items-center gap-x-2">
                            <a href="{{route('admin.project.assign.tool', $project)}}" class="py-3 px-5 rounded-full bg-indigo-950 text-white">
                                Tambah tools
                            </a>
                            <a href="{{route('admin.project_screenshots.create', $project)}}" class="py-3 px-5 rounded-full bg-indigo-950 text-white">
                                Tambahkan screenshot
                            </a>
                        </div>
                        <div class="flex flex-row items-center gap-x-2">
                            <a href="{{route('admin.projects.edit', $project)}}" class="py-3 px-5 rounded-full bg-indigo-500 text-white">
                                Edit
                            </a>
                            <form action="{{route('admin.projects.destroy', $project)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-3 px-5 rounded-full bg-red-500 text-white">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Google Reviews Section -->
                    <div class="google-reviews mt-5" id="google-reviews-{{$project->id}}">
                        <h4 class="text-xl font-semibold">Google Reviews</h4>
                        <div id="reviews-container-{{$project->id}}"></div>
                    </div>
                    @empty
                    <p>
                        Belum ada projek tersedia
                    </p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to fetch and display Google reviews for a specific project
        function loadGoogleReviews(projectId, placeId, apiKey) {
            const url = `https://maps.googleapis.com/maps/api/place/details/json?placeid=${placeId}&fields=reviews&key=${apiKey}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const reviews = data.result.reviews || [];
                    const container = document.getElementById(`reviews-container-${projectId}`);
                    container.innerHTML = '';

                    if (reviews.length > 0) {
                        reviews.forEach(review => {
                            const reviewDiv = document.createElement('div');
                            reviewDiv.classList.add('review');
                            reviewDiv.innerHTML = `
                                <p><strong>${review.author_name}</strong> (${review.rating} stars)</p>
                                <p>${review.text}</p>
                            `;
                            container.appendChild(reviewDiv);
                        });
                    } else {
                        container.innerHTML = '<p>No reviews found.</p>';
                    }
                })
                .catch(error => console.error('Error fetching Google reviews:', error));
        }

        // On page load, load reviews for each project
        document.addEventListener('DOMContentLoaded', function () {
            const projects = @json($projects);
            const apiKey = 'YOUR_API_KEY'; // Gantilah dengan API Key Anda

            projects.forEach(project => {
                const placeId = project.place_id; // Pastikan setiap proyek memiliki place_id yang sesuai
                loadGoogleReviews(project.id, placeId, apiKey);
            });
        });
    </script>
</x-app-layout>