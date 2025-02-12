<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <form action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="flex flex-col gap-y-5">
                        <h1 class="text-3xl text-indigo-950 font-bold">
                            Tambah Projek Baru
                        </h1>
                        <a href="{{ route('admin.project.assign.tool', $project->id) }}" class="py-2 px-4 rounded-full bg-indigo-900 text-white">
                            Tambah tools
                        </a>
                        <div class="flex flex-col gap-y-2">
                            <h3>
                                Nama
                            </h3>
                            <input type="text" id="name" name="name">
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <h3>
                                Kategori
                            </h3>
                            <select name="category" id="category">
                                <option value="">Pilih kategori</option>
                                <option value="Website developement">Website developement</option>
                                <option value="App developement">App developement</option>
                                <option value="Graphic design">Graphic design</option>
                                <option value="marketing">Digital marketing</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <h3>
                                Cover image
                            </h3>
                            <input type="file" id="cover" name="cover">
                        </div>
                        <div class="flex flex-col gap-y-2">
                            <h3>
                                About
                            </h3>
                            <textarea name="about" id="about" cols="30" rows="10"></textarea>
                        </div>
                        <button type="submit" class="py-4 w-full rounded-full bg-violet-700 font-bold text-white">Upload project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>