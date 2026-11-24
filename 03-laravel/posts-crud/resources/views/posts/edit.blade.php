<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="mx-auto max-w-2xl px-4 py-10">

    <div class="mb-8">

        <a href="{{ route('posts.index') }}"
           class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
            ← Back to Posts
        </a>

        <h1 class="mt-4 text-3xl font-bold text-gray-900">
            Edit Post
        </h1>

        <p class="mt-1 text-gray-600">
            Update your post.
        </p>

    </div>


    <form
        action="{{ route('posts.update', $post->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm"
    >

        @csrf
        @method('PUT')


        <!-- Title -->

        <div>

            <label class="block text-sm font-medium text-gray-900">
                Title
            </label>

            <input
                type="text"
                name="title"
                value="{{ old('title', $post->title) }}"
                class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        <!-- Description -->

        <div>

            <label class="block text-sm font-medium text-gray-900">
                Description
            </label>

            <textarea
                name="description"
                rows="6"
                class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
            >{{ old('description', $post->description) }}</textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        <!-- Current Image -->

        @if ($post->image)

            <div>

                <p class="mb-2 text-sm font-medium text-gray-900">
                    Current Image
                </p>

                <img
                    src="{{ asset('storage/' . $post->image) }}"
                    class="h-48 w-full rounded-lg object-cover"
                >

            </div>

        @endif


        <!-- New Image -->

        <div>

            <label class="block text-sm font-medium text-gray-900">
                Change Image
            </label>

            <input
                type="file"
                name="image"
                class="mt-2 w-full rounded-lg border border-gray-300 bg-white px-4 py-3"
            >

            @error('image')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        <!-- Buttons -->

        <div class="flex justify-end gap-3">

            <a
                href="{{ route('posts.index') }}"
                class="rounded-lg border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700"
            >
                Update Post
            </button>

        </div>

    </form>

</div>

</body>
</html>