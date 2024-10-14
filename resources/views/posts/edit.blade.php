<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post View') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <form action="{{ route('posts.update', $post) }}" method="post">
                        @csrf

                        <x-input-label for="title" value="Title" />
                        <x-text-input name="title" value="{{ $post->title }}" type="text" class="mt-1 block w-full" />

                        <x-input-label for="title" value="Content" />
                        <textarea name="content" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-5 block w-full" rows="10">
                            {!! trim($post->content) !!}
                        </textarea>

                        <x-primary-button class="mt-5">Save</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
